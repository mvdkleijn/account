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

<div id="account">
    <h1>My Account</h1>
    <p>
        Welcome, <?php echo $user->name; ?>. This is an overview of your personal account on the wolfcms.org website.
        This overview will be changed &amp; expanded upon in the future.
    </p>
    <p>
        Username: <?php echo $user->username; ?><br/>
        Full name: <?php echo $user->name; ?><br/>
        Email: <?php echo $user->email; ?><br/>
    </p>
    <h2>Actions</h2>
    <ul>
        <li><a href="<?php echo BASE_URL.'account/password' ?>">Change password</a></li>
        <li><a href="http://www.wolfcms.org/users/reset.html">Reset password</a> (generates a password)</li>
        <li><a href="http://www.wolfcms.org/users/logout.html">Logout</a></li>
    </ul>
</div>
