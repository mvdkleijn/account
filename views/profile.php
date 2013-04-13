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
    <h1><?php echo __('Public profile for :username', array(':username' => $user->username)); ?></h1>
    <table>
        <tr>
            <td><?php echo __('Username'); ?></td>
            <td><?php echo $user->username; ?></td>
        </tr>
        <tr>
            <td><?php echo __('Full name'); ?></td>
            <td><?php echo $user->name; ?></td>
        </tr>
        <?php foreach($profile as $entryName => $entryValue) { ?>
        <tr>
            <td><?php echo $entryName; ?></td>
            <td><?php echo $entryValue; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
