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
    If we assume that you have installed your Wolf CMS in a subdirectory called "wolf", you
    would normally access your homepage by going to:
</p>
<p>http://www.example.com/wolf/</p>
<p>
    Now, make sure you have enabled the plugin. If you want to access the "My account" page and
    have left the "uri" setting to its default, you should be able to access the page through:
</p>
<p>
    http://www.example.com/wolf/?account/<br/>
    &mdash; or &mdash;<br/>
    http://www.example.com/wolf/account/
</p>