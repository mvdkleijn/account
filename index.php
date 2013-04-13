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

define('ACCOUNT_VERSION', '1.0.0');

Plugin::setInfos(array(
    'id'          => 'account',
    'title'       => 'Account',
    'description' => 'Adds a My Account page to your site.',
    'version'     => ACCOUNT_VERSION,
    'license'     => 'GPLv3',
    'author'      => 'Martijn van der Kleijn',
    'website'     => 'http://www.vanderkleijn.net/wolf-cms.html',
    'update_url'  => 'http://www.vanderkleijn.net/plugins.xml',
    'type'        => 'both',
    'require_wolf_version' => '0.7.6'
));

if (Plugin::isEnabled('account')) {
    // Setup the controller.
    Plugin::addController('account', 'Account', 'admin_edit', false);

    // Load classes.
    AutoLoader::addFolder(CORE_ROOT.'/plugins/account/models/');

    // Get settings
    $settings = Plugin::getAllSettings('account');
    $uri = $settings['uri'];

    // Setup routes to the account plugin.
    Dispatcher::addRoute(array(
        '/'.$uri                => '/plugin/account/index',
        '/'.$uri.'/'            => '/plugin/account/index',
        '/'.$uri.'/edit'        => '/plugin/account/edit',
        '/'.$uri.'/password'    => '/plugin/account/password',
        '/'.$uri.'/:any'        => '/plugin/account/profile/$1',
        '/'.$uri.'/:any/'       => '/plugin/account/profile/$1',
        '/'.$uri.'/logout/'     => '/login/logout',
        //'/users'            => '/plugin/account/list',
       ));

    //Observer::observe('admin_login_success', 'notifyLogin');

    function notifyLogin($user) {
        Flash::setNow('message', 'You are now logged in.');
    }   
}