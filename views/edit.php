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

<h1><?php echo __('My account'); ?></h1>

<form action="<?php echo get_url(Plugin::getSetting('uri', 'account').'/edit'); ?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="label"><label for="profile[username]"><?php echo __('Username'); ?>: </label></td>
            <td class="field"><input class="textbox" id="profile[username]" name="profile[username]" maxlength="255" size="20" type="text" value="<?php echo $profile['username']; ?>" readonly="readonly"/></td>
        </tr>
        <tr>
            <td class="label"><label for="profile[name]"><?php echo __('Full name'); ?>: </label></td>
            <td class="field"><input class="textbox" id="profile[name]" name="profile[name]" maxlength="255" size="20" type="text" value="<?php echo $profile['name']; ?>" /></td>
        </tr>
        <tr>
            <td class="label"><label for="profile[email]"><?php echo __('Email'); ?>: </label></td>
            <td class="field"><input class="textbox" id="profile[email]" name="profile[email]" maxlength="255" size="20" type="text" value="<?php echo $profile['email']; ?>" /></td>
        </tr>
    </table>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
    </p>
</form>