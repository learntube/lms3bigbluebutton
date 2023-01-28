<?php

$EM_CONF['lms3bigbluebutton'] = [
    'title' => 'LMS3 BigBlueButton',
    'description' => 'This plugin integrates BigBlueButton into TYPO3.',
    'category' => 'misc',
    'author' => 'Sagar Desai',
    'author_email' => 'sagardesai1990@gmail.com',
    'author_company' => 'LEARNTUBE! GmbH',
    'state' => 'beta',
    'clearCacheOnLoad' => true,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-11.5.99',
        ],
    ],
];
