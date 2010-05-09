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

Plugin::setInfos(array(
    'id'          => 'account',
    'title'       => 'Account',
    'description' => 'Adds a My Account page to your site.',
    'version'     => '1.0.0',
    'license'     => 'GPLv3',
    'author'      => 'Martijn van der Kleijn',
    'website'     => 'http://www.vanderkleijn.net/wolf-cms.html',
    'update_url'  => 'http://www.vanderkleijn.net/plugins.xml',
    'type'        => 'both',
    'require_wolf_version' => '0.7.0'
));

// Setup the controller.
Plugin::addController('account', 'Account', 'administrator', false);

// Setup routes to the forum.
Dispatcher::addRoute(array(
    '/account'          => '/plugin/account/index',
    '/account/'          => '/plugin/account/index',
    '/account/password' => '/plugin/account/password',
    //'/account/:any/'    => '/plugin/account/$1',
    //'/users'            => '/plugin/account/list',
   ));