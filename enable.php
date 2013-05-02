<?php
/*
 * Account plugin for Wolf CMS. <http://www.wolfcms.org>
 * Copyright (C) 2010-2013 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of the Account plugin for Wolf CMS.
 *
 * The Account plugin for Wolf CMS is made available under the terms of the GNU GPLv3 license.
 * Please see <http://www.gnu.org/licenses/gpl.html> for full details.
 */

/**
 * The Account plugin allows end users to view and manipulate their accounts.
 *
 * @package wolf
 * @subpackage plugin.account
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 License
 * @copyright Martijn van der Kleijn, 2010-2013
 */

/* Security measure */
if (!defined('IN_CMS') || !defined('ACCOUNT_VERSION')) { exit(); }

// Check if the plugin's settings already exist and create them if not.
if (Plugin::getSetting('version', 'account') === false) {
    // Store settings new style
    $settings = array('version' => ACCOUNT_VERSION,
                      'layout'  => '1',
                      'uri'     => 'account'
                     );

    Plugin::setAllSettings($settings, 'account');
}

$PDO = Record::getConnection();
$driver = strtolower($PDO->getAttribute(Record::ATTR_DRIVER_NAME));

// Setup table structure
if ($driver == 'mysql') {
    $PDO->exec("CREATE TABLE ".TABLE_PREFIX."account_setting (
        id int(11) unsigned NOT NULL auto_increment,
        user_id int(11) unsigned NOT NULL,
        name varchar(40) NOT NULL,
        value varchar(255) NOT NULL,
        PRIMARY KEY (id)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8");
}

if ($driver == 'sqlite') {
    Flash::setNow('error', __('Our appologies, your database type is not yet supported by this plugin.'));
    return;
}

if ($driver == 'pgsql') {
    Flash::setNow('error', __('Our appologies, your database type is not yet supported by this plugin.'));
    return;
}
