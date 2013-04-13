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
?>

<div id="account">
    <h2><?php echo __('My account'); ?></h2>
    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <th colspan="2">Account information</th>
        </tr>
        <tr>
            <td><?php echo __('Username'); ?></td>
            <td><?php echo $user->username; ?></td>
        </tr>
        <tr>
            <td><?php echo __('Full name'); ?></td>
            <td><?php echo $user->name; ?></td>
        </tr>
        <tr>
            <td><?php echo __('Email'); ?></td>
            <td><?php echo $user->email; ?></td>
        </tr>
        <?php foreach($profile as $entryName => $entryValue) { ?>
        <tr>
            <td><?php echo $entryName; ?></td>
            <td><?php echo $entryValue; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
<!--
<h2 class="title">Actions...</h2>
<div class="account-plugin-sidebar">
    <ul>
        <?php if (count($actions) == 0) { echo '<li>'.__('No actions available').'</li>'; } ?>
        <?php foreach($actions as $name => $link) { ?>
        <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
        <?php } ?>
    </ul>
</div>
-->