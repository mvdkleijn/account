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

class AccountController extends PluginController {
    static $actions = array();
    static $profile = array();

    function __construct() {
        AuthUser::load();
        if (defined('CMS_BACKEND')) {
            define('ACCOUNT_VIEWS', 'account/views');
            $this->setLayout('backend');
            $this->assignToLayout('sidebar', new View('../../plugins/account/views/sidebar'));
        }
        else {
            define('ACCOUNT_VIEWS', '../../plugins/account/views');
            $settings = Plugin::getAllSettings('account');

            $layout = Layout::findById($settings['layout']);
            $this->setLayout($layout->name);
        }
        
        // Retrieve setting
        $uri = Plugin::getSetting('uri', 'account');
        
        // Add primary actions
        if (AuthUser::isLoggedIn()) {
            self::$actions[__('Change password')] = BASE_URL.$uri.'/password';
            //self::$actions[__('Reset password')] = BASE_URL.'users/reset.html';
            self::$actions[__('Edit account settings')] = BASE_URL.$uri.'/edit';
        }
        
        // Add plugin actions
        foreach(Observer::getObserverList('account_list_actions') as $callback) {
            self::$actions = array_merge(self::$actions, call_user_func_array($callback, array()));
        }
        
        // Add secondary actions
        if (AuthUser::isLoggedIn()) {
            self::$actions[__('Logout')] = BASE_URL.$uri.'/logout/';
        }
        
        $this->assignToLayout('account_sidebar', new View('../../plugins/account/views/actions',
                                                    array('actions' => self::$actions,
                                                          'settings' => Plugin::getAllSettings('account')
                                                    )
                                                 ));
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

        // Get profile information from other plugins.
        foreach(Observer::getObserverList('account_display_profile') as $callback) {
            self::$profile = array_merge(self::$profile, call_user_func_array($callback, array()));
        }

        $this->display(ACCOUNT_VIEWS.'/index', array('settings' => Plugin::getAllSettings('account'),
                                                     'user'     => AuthUser::getRecord(),
                                                     'profile'  => self::$profile,
                                                     'actions'  => self::$actions
                                                    ));
    }

    public function profile($username) {
        // Get profile information from other plugins.
        foreach(Observer::getObserverList('account_display_profile') as $callback) {
            self::$profile = array_merge(self::$profile, call_user_func_array($callback, array()));
        }

        $this->display(ACCOUNT_VIEWS.'/profile', array('settings' => Plugin::getAllSettings('account'),
                                                       'user'     => User::findOneFrom('User', 'username=?', array($username)),
                                                       'profile'  => self::$profile,
                                                       'actions'  => self::$actions
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

        if (!AuthUser::validatePassword($user, $data['old'])) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('The old password you entered was incorrect.')));
        }

        if ($data['password'] != $data['confirm'] || strlen($data['password']) < 5) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Password and Confirm are not the same or too small!')));
        }

        $user->password = AuthUser::generateHashedPassword($data['password'], $user->salt);
        if (!$user->save()) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => array('Unable to update password!')));
        }

        $this->display(ACCOUNT_VIEWS.'/success', array('message' => 'Your password was successfully changed.'));
    }


    public function edit() {
        $this->_checkLoggedIn();
        use_helper('Validate');
        $user = AuthUser::getRecord();

        if (!isset($_POST['profile'])) {
            $profile = array();

            $profile['username'] = $user->username;
            $profile['name'] = $user->name;
            $profile['email'] = $user->email;

            $this->display(ACCOUNT_VIEWS.'/edit', array('profile' => $profile,
                                                        'settings' => AccountSetting::findByUserId(AuthUser::getId()),
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
        
        foreach ($data as $name => $value) {
            if (!AccountSetting::validAccountSetting($name, $value)) {
                Flash::setNow('error', __('Account settings could not be saved! Invalid value entered for field ":name".', array(':name' => AccountSetting::accountSettingName($name))));
                $this->index();
            }
            else {
                $as = AccountSetting::find($user->id, $name);
                if ($as) {
                    $as->value = $value;
                    $as->save();
                }
            }
        }

        if (strlen($profile['name']) < 3) {
            $errors[] = __('Your username must be at least three characters.');
        }
        else {
            // Store full name if valid
            if (eregi('[^a-zA-Z0-9 \-\.@+_]', $profile['name'])) {
                Flash::setNow('error', __('Account settings could not be saved! Invalid value entered for field ":name".', array(':name' => 'name')));
                $this->index();
            }
            else {
                $user->name = $profile['name'];
            }
        }

        if (count($errors) > 0) {
            $this->display(ACCOUNT_VIEWS.'/error', array('errors' => $errors));
        }

        // Store email address if valid
        if (!Validate::email($profile['email'])) {
            Flash::setNow('error', __('Account settings could not be saved! Invalid value entered for field ":name".', array(':name' => 'email')));
            $this->index();
        }
        else {
            $user->email = $profile['email'];
        }

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

        if (!AuthUser::hasPermission('admin_edit')) {
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
                $settings[$key] = $value; // No need to quote since Plugin::setAllSettings uses prepared statements
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
            self::$actions[$name] = $action;
        }

        return true;
    }

    /**
     * 
     * 
     * @todo Make this function part of Plugin?
     * @todo replace is_object by check if its Node or descendent of Node
     * 
     * @param Node $node
     */
    private static function __displayResult(Node $node) {
        if (is_object($node)) {
            // If the Node is in preview status, only display to logged in users
            if (Page::STATUS_PREVIEW == $node->status_id) {
                AuthUser::load();
                if (!AuthUser::isLoggedIn() || !AuthUser::hasPermission('page_view'))
                    pageNotFound();
            }

            // If Node needs login, fire login required event
            if ($node->getLoginNeeded() == Page::LOGIN_REQUIRED) {
                AuthUser::load();
                if (!AuthUser::isLoggedIn()) {
                    Observer::notify('login_required');
                    AuthUser::load();
                    if (!AuthUser::isLoggedIn()) {
                        throw new Exception('User still not logged in after login_required event fired.');
                    }
                }
            }

            Observer::notify('node_found', $node);
            $node->_executeLayout();
        }
        else {
            pageNotFound();
        }
    }
}