CREATE TABLE tx_lms3bigbluebutton_domain_model_meeting
(
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT 0 NOT NULL,
    title VARCHAR(45) NOT NULL,
    duration int(11) DEFAULT 0 NOT NULL,
    meeting_id VARCHAR(45) NOT NULL,
    moderator_password VARCHAR(45) NOT NULL,
    attendee_password VARCHAR(45) NOT NULL,
    moderator_user_groups VARCHAR(255) NOT NULL,
    welcome MEDIUMTEXT NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    max_participants tinyint(4) unsigned DEFAULT '1' NOT NULL,
    logout_url VARCHAR(255) NOT NULL,
    moderator_only_message tinyint(1) unsigned DEFAULT '0' NOT NULL,
    webcams_only_for_moderator tinyint(1) unsigned DEFAULT '0' NOT NULL,
    mute_on_start tinyint(1) unsigned DEFAULT '0' NOT NULL,
    allow_mods_to_unmute_users tinyint(1) unsigned DEFAULT '0' NOT NULL,
    logo VARCHAR(255) NULL,
    server_created_at int(11) DEFAULT 0 NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);
