<?php

declare(strict_types = 1);

namespace LMS3\Lms3bigbluebutton\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */


use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use LMS3\Lms3bigbluebutton\Service\BBBService;
use TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;

class MeetingController extends ActionController
{
    protected BBBService $bbbService;

    public function initializeAction()
    {
        $config = [
            'bbbUrl' => $this->settings['bbbUrl'],
            'bbbSecret' => $this->settings['bbbSecret'],
        ];

        $this->bbbService = GeneralUtility::makeInstance(BBBService::class, $config);
    }

    /**
     * Show the join session and recordings after session end
     */
    public function indexAction(): void
    {
        $meetingId = (int) ($this->settings['meeting'] ?? 0);
        $meeting = $this->bbbService->findMeeting($meetingId);

        if ($this->bbbService->getMeetingInfo($meeting->getMeetingId()) === null) {
            $this->bbbService->createMeeting($meeting);
        }

        $this->view->assign('meeting', $meeting);
    }

    /**
     * Join meeting
     *
     * @return void
     * @throws NoSuchArgumentException
     * @throws StopActionException|IllegalObjectTypeException
     */
    public function joinAction(): void
    {
        if (!$this->request->hasArgument('meetingId')) {
            $this->redirect('index');
        }

        $meetingId = (int) $this->request->getArgument('meetingId');
        $meeting = $this->bbbService->findMeeting($meetingId);

        if ($this->bbbService->getMeetingInfo($meeting->getMeetingId()) === null) {
            $this->bbbService->createMeeting($meeting);
        }

        $url = $this->bbbService->getJoinMeetingURL($meeting);

        if (empty($url)) {
            $this->redirect('index');
        }

        $this->redirectToUri($url);
    }
}
