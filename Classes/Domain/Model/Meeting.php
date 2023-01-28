<?php

namespace LMS3\Lms3bigbluebutton\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Meeting extends AbstractEntity
{
    protected string $meetingId;
    protected string $title;
    protected int $duration;
    protected string $moderatorUserGroups;
    protected ?string $welcome;
    protected string $moderatorPassword;
    protected string $attendeePassword;
    protected int $maxParticipants;
    protected string $logoutUrl;
    protected bool $moderatorOnlyMessage = false;
    protected bool $webcamsOnlyForModerator;
    protected bool $muteOnStart;
    protected bool $allowModsToUnmuteUsers;
    protected string $logo;
    protected int $serverCreatedAt;

    /**
     * @return string
     */
    public function getMeetingId(): string
    {
        return $this->meetingId;
    }

    /**
     * @param string $meetingId
     * @return Meeting
     */
    public function setMeetingId(string $meetingId): Meeting
    {
        $this->meetingId = $meetingId;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Meeting
     */
    public function setTitle(string $title): Meeting
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getModeratorUserGroups(): string
    {
        return $this->moderatorUserGroups;
    }

    /**
     * @param string $moderatorUserGroups
     * @return Meeting
     */
    public function setModeratorUserGroups(string $moderatorUserGroups): Meeting
    {
        $this->moderatorUserGroups = $moderatorUserGroups;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWelcome(): ?string
    {
        return $this->welcome;
    }

    /**
     * @param string|null $welcome
     * @return Meeting
     */
    public function setWelcome(?string $welcome): Meeting
    {
        $this->welcome = $welcome;
        return $this;
    }

    /**
     * @return string
     */
    public function getModeratorPassword(): string
    {
        return $this->moderatorPassword;
    }

    /**
     * @param string $moderatorPassword
     * @return Meeting
     */
    public function setModeratorPassword(string $moderatorPassword): Meeting
    {
        $this->moderatorPassword = $moderatorPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttendeePassword(): string
    {
        return $this->attendeePassword;
    }

    /**
     * @param string $attendeePassword
     * @return Meeting
     */
    public function setAttendeePassword(string $attendeePassword): Meeting
    {
        $this->attendeePassword = $attendeePassword;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxParticipants(): int
    {
        return $this->maxParticipants;
    }

    /**
     * @param int $maxParticipants
     * @return Meeting
     */
    public function setMaxParticipants(int $maxParticipants): Meeting
    {
        $this->maxParticipants = $maxParticipants;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogoutUrl(): string
    {
        return $this->logoutUrl;
    }

    /**
     * @param string $logoutUrl
     * @return Meeting
     */
    public function setLogoutUrl(string $logoutUrl): Meeting
    {
        $this->logoutUrl = $logoutUrl;
        return $this;
    }

    /**
     * @return bool
     */
    public function isModeratorOnlyMessage(): bool
    {
        return $this->moderatorOnlyMessage;
    }

    /**
     * @param bool $moderatorOnlyMessage
     * @return Meeting
     */
    public function setModeratorOnlyMessage(bool $moderatorOnlyMessage): Meeting
    {
        $this->moderatorOnlyMessage = $moderatorOnlyMessage;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWebcamsOnlyForModerator(): bool
    {
        return $this->webcamsOnlyForModerator;
    }

    /**
     * @param bool $webcamsOnlyForModerator
     * @return Meeting
     */
    public function setWebcamsOnlyForModerator(bool $webcamsOnlyForModerator): Meeting
    {
        $this->webcamsOnlyForModerator = $webcamsOnlyForModerator;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMuteOnStart(): bool
    {
        return $this->muteOnStart;
    }

    /**
     * @param bool $muteOnStart
     * @return Meeting
     */
    public function setMuteOnStart(bool $muteOnStart): Meeting
    {
        $this->muteOnStart = $muteOnStart;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowModsToUnmuteUsers(): bool
    {
        return $this->allowModsToUnmuteUsers;
    }

    /**
     * @param bool $allowModsToUnmuteUsers
     * @return Meeting
     */
    public function setAllowModsToUnmuteUsers(bool $allowModsToUnmuteUsers): Meeting
    {
        $this->allowModsToUnmuteUsers = $allowModsToUnmuteUsers;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @param string $logo
     * @return Meeting
     */
    public function setLogo(string $logo): Meeting
    {
        $this->logo = $logo;
        return $this;
    }

    /**
     * @return int
     */
    public function getServerCreatedAt(): int
    {
        return $this->serverCreatedAt;
    }

    /**
     * @param int $serverCreatedAt
     * @return Meeting
     */
    public function setServerCreatedAt(int $serverCreatedAt): Meeting
    {
        $this->serverCreatedAt = $serverCreatedAt;
        return $this;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     * @return Meeting
     */
    public function setDuration(int $duration): Meeting
    {
        $this->duration = $duration;
        return $this;
    }
}
