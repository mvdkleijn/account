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

class AccountController extends PluginController {
    static $actions = array();

    function __construct() {
        AuthUser::load();
        if (defined('CMS_BACKEND')) {
            define('ACCOUNT_VIEWS', 'account/views');
            $this->setLayout('backend');
        }
        else {
            define('ACCOUNT_VIEWS', '../../plugins/account/views');
            //$page = Page::findByUri(Plugin::getSetting('layout', 'account'));
            //$layout_id = $this->getLayoutId($page);
            $settings = Plugin::getAllSettings('account');

            $layout = Layout::findById($settings['layout']);
            $this->setLayout($layout->name);
        }
        $this->assignToLayout('sidebar', new View('../../plugins/account/views/sidebar'));
    }

    private function getLayoutId($page) {
        if ($page->layout_id)
            return $page->layout_id;
        else if ($page->parent)
                return $this->getLayoutId($page->parent);
            else
                exit ('You need to set a layout!');
    }

    private function _checkLoggedIn() {
        if (!AuthUser::isLoggedIn())
            $this->display(ACCOUNT_VIEWS.'/403');
    }

    public function content($part=false, $inherit=false) {
        if (!$part)
            return $this->content;
        else
            return false;
    }

    public function index() {
        $this->_checkLoggedIn();

        $this->display(ACCOUNT_VIEWS.'/index', array('settings' => Plugin::getAllSettings('account'),
                                                     'user' => AuthUser::getRecord()
                                                    ));
    }

    public function password() {
        $this->_checkLoggedIn();

        if (!isset($_POST['user'])) {
            $this->display(ACCOUNT_VIEWS.'/password', array('user' => AuthUser::getRecord(),
                                                         'csrf_token' => SecureToken::generateToken(BASE_URL.'account/password'),
                                                         'url' => BASE_URL.'account/password'
            ));
        }
        
        $data = $_POST['user'];
        $user = AuthUser::getRecord();

        // CSRF checks
        if (isset($_POST['csrf_token'])) {
            $csrf_token = $_POST['csrf_token'];
            if (!SecureToken::validateToken($csrf_token, BASE_URL.'account/password')) {
                $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Invalid token found.')));
                exit();
            }
        }
        else {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('No CSRF token found!')));
            exit();
        }

        if ($user->password != sha1($data['old'].$user->salt)) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('The old password you entered was incorrect.')));
        }

        if ($data['password'] != $data['confirm'] || strlen($data['password']) < 5) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Password and Confirm are not the same or too small!')));
        }

        $user->password = sha1($data['password'].$user->salt);
        if (!$user->save()) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Unable to update password!')));
        }

        $this->display(ACCOUNT_VIEWS.'/success', array('message' => 'Your password was successfully changed.'));
    }


    public function edit() {
        $this->_checkLoggedIn();

        $user = AuthUser::getRecord();

        if (!isset($_POST['profile'])) {
            $profile = array();

            $profile['username'] = $user->username;
            $profile['name'] = $user->name;
            $profile['email'] = $user->email;

            $this->display(ACCOUNT_VIEWS.'/edit', array('profile' => $profile,
                                                         'csrf_token' => SecureToken::generateToken(BASE_URL.'account/edit'),
                                                         'url' => BASE_URL.'account/edit'
            ));
        }

        $profile = $_POST['profile'];

        // CSRF checks
        if (isset($_POST['csrf_token'])) {
            $csrf_token = $_POST['csrf_token'];
            if (!SecureToken::validateToken($csrf_token, BASE_URL.'account/edit')) {
                $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Invalid token found.')));
                exit();
            }
        }
        else {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('No CSRF token found!')));
            exit();
        }

        $errors = array();

        if (strlen($profile['name']) < 3) {
            $errors[] = __('Your username must be at least three characters.');
        }

        if (count($errors) > 0) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => $errors));
        }

        // Set values
        $user->name = $profile['name'];
        $user->email = $profile['email'];

        if (!$user->save()) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Unable to update profile!')));
        }

        redirect(get_url(Plugin::getSetting('uri', 'account')));
    }

    public function documentation() {
        $this->display(ACCOUNT_VIEWS.'/documentation');
    }

    public function settings() {
        $this->_checkLoggedIn();

        if (!AuthUser::hasPermission('administrator')) {
            $this->display(ACCOUNT_VIEWS.'/403');
        }

        $this->display(ACCOUNT_VIEWS.'/settings', array('settings' => Plugin::getAllSettings('account'),
                                                        'layouts' => Layout::findAll()
                                                        ));
    }

    function save() {
        if (isset($_POST['settings'])) {
            $settings = $_POST['settings'];
            foreach ($settings as $key => $value) {
                $settings[$key] = mysql_escape_string($value);
            }

            if (Plugin::setAllSettings($settings, 'account')) {
                Flash::set('success', __('The settings have been saved.'));
            }
            else {
                Flash::set('error', __('An error occured trying to save the settings.'));
            }
        }
        else {
            Flash::set('error', __('Could not save settings, no settings found.'));
        }

        redirect(get_url('plugin/account/settings'));
    }

    public static function registerAction($name, $action=null) {
        if (null === $name || (is_array($name) && null !== $action)) {
            return false;
        }

        if (is_array($name)) {
            foreach($name as $key => $value) {
                self::$actions[$key] = $value;
            }
        }
        else {
            self::$actions[$name] = $value;
        }

        return true;
    }
}
