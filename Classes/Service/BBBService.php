<?php

namespace LMS3\Lms3bigbluebutton\Service;

use BigBlueButton\BigBlueButton;
use BigBlueButton\Core\Meeting;
use BigBlueButton\Parameters\CreateMeetingParameters;
use BigBlueButton\Parameters\GetMeetingInfoParameters;
use BigBlueButton\Parameters\JoinMeetingParameters;
use BigBlueButton\Responses\CreateMeetingResponse;
use LMS3\Lms3bigbluebutton\Domain\Repository\MeetingRepository;
use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\Exception;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use LMS3\Lms3bigbluebutton\Domain\Model\Meeting as LMS3Meeting;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/**
 * Class BBBService
 * @package LMS3\Lms3bigbluebutton\Service
 */
class BBBService implements SingletonInterface
{
    /**
     * @var BigBlueButton
     */
    protected BigBlueButton $bigBlueButton;

    /**
     * @var array
     */
    protected array $config;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * @var MeetingRepository
     */
    protected MeetingRepository $meetingRepository;

    /**
     * BBBService constructor.
     *
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config = [])
    {
        $this->bigBlueButton = new BigBlueButton($config['bbbUrl'], $config['bbbSecret']);
        $this->config = $config;
        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->meetingRepository = $objectManager->get(MeetingRepository::class);
    }

    /**
     * @param int $meetingID
     * @return LMS3Meeting
     */
    public function findMeeting(int $meetingID): LMS3Meeting
    {
        return $this->meetingRepository->findByUid($meetingID);
    }

    /**
     * Create meeting on the BBB server
     *
     * @param LMS3Meeting $meeting
     * @return CreateMeetingResponse
     */
    public function createMeeting(LMS3Meeting $meeting): CreateMeetingResponse
    {
        $createMeetingParams = $this->getMeetingParams($meeting);
        $response = $this->bigBlueButton->createMeeting($createMeetingParams);

        if ($response->getReturnCode() == 'FAILED') {
            $this->logger->emergency('MeetingID: ' . $meeting->getMeetingId());
            $this->logger->emergency('Can\'t create room! please contact our administrator.');
            $this->logger->emergency('MessageKey: ' . $response->getMessageKey());
            $this->logger->emergency('Message: ' . $response->getMessage());
        } else {
            $persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
            $meeting->setServerCreatedAt(strtotime($response->getCreationDate()));
            try {
                $this->meetingRepository->update($meeting);
            } catch (IllegalObjectTypeException|UnknownObjectException) {
                $this->logger->warning('Failed to update server create time for meeting ' . $meeting->getMeetingId());
            }
            $persistenceManager->persistAll();

            $this->logger->info('MeetingID: ' . $meeting->getMeetingId());
            $this->logger->info('MessageKey: ' . $response->getMessageKey());
            $this->logger->info('Message: ' . $response->getMessage());
        }

        return $response;
    }

    /**
     * @param LMS3Meeting $meeting
     * @return CreateMeetingParameters
     */
    public function getMeetingParams(LMS3Meeting $meeting): CreateMeetingParameters
    {
        $createMeetingParams = new CreateMeetingParameters($meeting->getMeetingId(), $meeting->getTitle());
        $createMeetingParams->setAttendeePassword($meeting->getAttendeePassword());
        $createMeetingParams->setModeratorPassword($meeting->getModeratorPassword());
        $createMeetingParams->setDuration($meeting->getDuration());
        $createMeetingParams->setLogoutUrl($meeting->getLogoutUrl());
        $createMeetingParams->setMaxParticipants($meeting->getMaxParticipants());
        $createMeetingParams->setWelcomeMessage($meeting->getWelcome());
        $createMeetingParams->setModeratorOnlyMessage($meeting->isWebcamsOnlyForModerator());
        $createMeetingParams->setAllowModsToUnmuteUsers($meeting->isAllowModsToUnmuteUsers());
        $createMeetingParams->setLogo($meeting->getLogo());
        $createMeetingParams->setMuteOnStart($meeting->isMuteOnStart());

        return $createMeetingParams;
    }

    /**
     * Get meeting url to join the session
     *
     * @param LMS3Meeting $meeting
     * @return string
     */
    public function getJoinMeetingURL(LMS3Meeting $meeting): string
    {
        $user = $GLOBALS['TSFE']->fe_user->user;

        if ($user === null) {
            return '';
        }

        $meetingInfo = $this->getMeetingInfo($meeting->getMeetingId());
        if ($meetingInfo === null) {
            return '';
        }

        $isModerator = $this->isModerator($meeting->getModeratorUserGroups(), $user['usergroup'] ?? '');
        $password = $isModerator ? $meeting->getModeratorPassword() : $meeting->getAttendeePassword();
        $joinMeetingParams = new JoinMeetingParameters($meeting->getMeetingId(), $this->getUsername($user), $password);
        $joinMeetingParams->setUserId($user['uid']);
        $joinMeetingParams->setRedirect(true);

        return $this->bigBlueButton->getJoinMeetingURL($joinMeetingParams);
    }

    /**
     * Get meeting information
     *
     * @param string $meetingID
     * @return Meeting|null
     */
    public function getMeetingInfo(string $meetingID): ?Meeting
    {
        $getMeetingInfoParams = new GetMeetingInfoParameters($meetingID);
        $response = $this->bigBlueButton->getMeetingInfo($getMeetingInfoParams);

        if ($response->getReturnCode() == 'FAILED') {
            $this->logger->warning('MeetingID: ' . $meetingID);
            $this->logger->warning('MessageKey: ' . $response->getMessageKey());
            $this->logger->warning('Message: ' . $response->getMessage());

            return null;
        } else {
            return $response->getMeeting();
        }
    }

    /**
     * Check if the user is moderator
     *
     * @param string $moderatorGroups
     * @param string $userGroups
     * @return bool
     */
    private function isModerator(string $moderatorGroups, string $userGroups): bool
    {
        $moderatorGroups = explode(',', trim($moderatorGroups));
        $userGroups = explode(',', trim($userGroups));

        return !empty(array_intersect($moderatorGroups, $userGroups));
    }

    /**
     * Get username
     *
     * @param array $user
     * @return string
     */
    private function getUsername(array $user): string
    {
        if (!empty($user['first_name']) && !empty($user['last_name'])) {
            return sprintf(
              '%s %s (%s)',
                $user['first_name'],
                $user['last_name'],
                $user['username']
            );
        }

        return $user['username'];
    }
}
