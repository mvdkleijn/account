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
?>

<h1>Account &ndash; <?php echo __('Documentation'); ?></h1>
<p>
    The account plugin serves as a hub of sorts for user account related activities.
    It provides several functions that allow other plugin developers to:
</p>
<ul>
    <li>Display profile data</li>
    <li>Add profile elements that are plugin specific</li>
    <li>Add action links for users</li>
</ul>
<h2>Accessing the "My account" page</h2>
<p>
    This is fairly simple and the account plugin comes with a nice default "My account" page.
    If we assume that you have installed your Wolf CMS in the root of your site, you
    would normally access your homepage by going to:
</p>
<p>http://www.example.com/</p>
<p>
    Now, make sure you have enabled the plugin. If you want to access the "My account" page and
    have left the "uri" setting to its default, you should be able to access the page through:
</p>
<p>
    http://www.example.com/?account/<br/>
    &mdash; or &mdash;<br/>
    http://www.example.com/account/
</p>
<h2>Adding the actions menu to your layout</h2>
<p>
    Just add the following code to a sidebar or other area in your layout:
</p>
<pre><code>
&lt;?php
    if (isset($this->layout_vars['account_sidebar'])) {
      echo $this->layout_vars['account_sidebar'];
    }
?&gt;</code></pre>

<h2>For plugin developers</h2>
<h3>Adding actions to the menu</h3>
<p>
    As a plugin developer, you can add actions to the "my account" page very
    easily by adding code similar to the following to your plugin's index.php page:
</p>
<pre><code>
// Lets make sure the account plugin is enabled...
if (Plugin::isEnabled('account')) {

    // We make sure to observe the account plugin's list actions event
    Observer::observe('account_list_actions', 'returnMyPluginActions');

    // Our plugin's function that returns an array of actions.
    function returnMyPluginActions() {
        $actions = array();

        if (AuthUser::isLoggedIn()) {
            // Add an action; name & url to action
            $actions[__('Some sort of action')] = BASE_URL . 'my_plugin/some_action/';
        }

        return $actions;
    }
}
</code></pre>

<h3>Adding read-only profile/account entries</h3>
<p>
    Your plugin can provide informational (read-only) profile entries to the
    account plugin like this:
</p>
<pre><code>
// Lets make sure the account plugin is enabled...
if (Plugin::isEnabled('account')) {

    // Make sure we listen to the account plugin's requests to return the profile entries.
    Observer::observe('account_display_profile', 'returnMyPluginProfileEntries');

    // Function to return profile data when asked by account plugin.
    function returnMyPluginProfileEntries() {
        $prof = array();

        $prof['Karma'] = '10 karma points';

        return $prof;
    }
}
</code></pre>

<h3>Adding read-write profile/account entries</h3>
<p>
    If you want your plugin to have settings that are available for edit through the
    account plugin, you can do something like this in your plugin's index.php:
</p>
<pre><code>
// Lets make sure the account plugin is enabled...
if (Plugin::isEnabled('account')) {
    // Lets make sure the account plugin's models is enabled.
    AutoLoader::addFolder(PLUGINS_ROOT . '/account/models/');

    // Add an profile / account setting
    // Parameters: [setting id], [setting display name], [setting type], [eregi entry to validate setting upon save]
    AccountSetting::registerAccountSetting('some_setting', 'Some setting', 'text', '[^0-9]');
    // Add another account setting
    AccountSetting::registerAccountSetting('another_setting', 'Another setting', 'text', '[^0-9]');

    // Make sure we listen to the account plugin's requests to return the profile entries.
    Observer::observe('account_display_profile', 'returnMyPluginProfileEntries');

    // Function to return profile data when asked by account plugin.
    function returnMyPluginProfileEntries() {
        $prof = array();

        // Define some defaults for the settings
        $as_defaults = array('some_setting' => '6',
                             'another_setting' => '20'
                            );
        
        // Check if certain account settings exist. If not, create defaults.
        $user_id = AuthUser::getId();
        if (!AccountSetting::find($user_id, 'some_setting')) {
            foreach ($as_defaults as $as_name => $as_value) {
                // Actually create the settings
                $as = new AccountSetting();
                $as->user_id = $user_id;
                $as->name = $as_name;
                $as->value = $as_value;
                $as->save();
            }
        }

        // Get all the settings
        $ac_settings = AccountSetting::findByUserId($user_id);
        foreach ($ac_settings as $ac_setting) {
            $prof[AccountSetting::accountSettingName($ac_setting->name)] = $ac_setting->value;
        }

        // Finally return them as an array.
        return $prof;
    }
}
</code></pre>