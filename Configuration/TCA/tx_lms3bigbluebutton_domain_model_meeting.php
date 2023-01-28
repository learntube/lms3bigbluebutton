<?php

$ll = 'LLL:EXT:lms3bigbluebutton/Resources/Private/Language/locallang.xlf:';

return [
    'ctrl' => [
        'title' => $ll . 'tx_lms3bigbluebutton_domain_model_meeting',
        'label' => 'title',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'iconfile' => 'EXT:lms3bigbluebutton/Resources/Public/Icon/bbb.svg',
    ],
    'types' => [
        '1' => [
            'showitem' => '
                --div--; ' . $ll . 'general,
                title, duration, moderator_user_groups, welcome, max_participants, logout_url, moderator_only_message, webcams_only_for_moderator, mute_on_start, allow_mods_to_unmute_users, logo
            '
        ]
    ],
    'columns' => [
        'meeting_id' => [
            'exclude' => true,
            'label' => $ll . 'meeting.meetingId',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => md5(time())
            ]
        ],
        'moderator_password' => [
            'exclude' => true,
            'label' => $ll . 'meeting.moderatorPassword',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => rand(11111, 99999)
            ]
        ],
        'attendee_password' => [
            'exclude' => true,
            'label' => $ll . 'meeting.attendeePassword',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required',
                'default' => rand(11111, 99999)
            ]
        ],
        'title' => [
            'label' => $ll . 'meeting.name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required'
            ]
        ],
        'duration' => [
            'label' => $ll . 'meeting.duration',
            'config' => [
                'type' => 'input',
                'eval' => 'int,required',
                'size' => 3,
            ]
        ],
        'moderator_user_groups' => [
            'label' => $ll . 'meeting.moderatorUserGroups',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'allowed' => 'fe_groups',
                'size' => 3,
                'maxitems' => 50,
                'minitems' => 1,
                'foreign_table' => 'fe_groups',
                'foreign_table_where' => 'AND fe_groups.deleted = 0 AND fe_groups.hidden = 0 order by fe_groups.title',
            ]
        ],
        'welcome' => [
            'label' => $ll . 'meeting.welcome',
            'config' => [
                'type' => 'text',
            ]
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'default' => 0,
                'items' => [
                    [
                        0 => '',
                        1 => '',
                    ]
                ],
            ]
        ],
        'max_participants' => [
            'label' => $ll . 'meeting.maxParticipants',
            'config' => [
                'type' => 'input',
                'eval' => 'int',
                'size' => 3,
            ]
        ],
        'logout_url' => [
            'label' => $ll . 'meeting.logoutUrl',
            'config' => [
                'type' => 'input',
            ]
        ],
        'moderator_only_message' => [
            'label' => $ll . 'meeting.moderatorOnlyMessage',
            'config' => [
                'type' => 'check',
            ]
        ],
        'webcams_only_for_moderator' => [
            'label' => $ll . 'meeting.webcamsOnlyForModerator',
            'config' => [
                'type' => 'check',
            ]
        ],
        'mute_on_start' => [
            'label' => $ll . 'meeting.muteOnStart',
            'config' => [
                'type' => 'check',
            ]
        ],
        'allow_mods_to_unmute_users' => [
            'label' => $ll . 'meeting.allowModsToUnmuteUsers',
            'config' => [
                'type' => 'check',
            ]
        ],
        'logo' => [
            'label' => $ll . 'meeting.logo',
            'config' => [
                'type' => 'input',
            ]
        ],
        'server_created_at' => [
            'exclude' => true,
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
            ]
        ],
    ]
];
