<?php
/*
 * Account plugin for Wolf CMS. <http://www.wolfcms.org>
 * Copyright (C) 2010 Martijn van der Kleijn <martijn.niji@gmail.com>
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
 * @version 1.0.0
 * @since Wolf version 0.7.0
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 License
 * @copyright Martijn van der Kleijn, 2010
 */

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

// Check if the plugin's settings already exist and create them if not.
if (Plugin::getSetting('version', 'account') === false) {
    // Store settings new style
    $settings = array('version' => '1.0.0',
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
