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
    <h2>Change password</h2>
    <form action="<?php echo $url; ?>" method="post">
        <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
      <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td class="label"><label for="old_password"><?php echo __('Old password'); ?></label></td>
          <td class="field"><input class="textbox" id="old_password" maxlength="40" name="user[old]" size="20" type="password" value="" /></td>
        </tr>
        <tr>
          <td class="label"><label for="user_password"><?php echo __('Password'); ?></label></td>
          <td class="field"><input class="textbox" id="user_password" maxlength="40" name="user[password]" size="20" type="password" value="" /></td>
        </tr>
        <tr>
          <td class="label"><label for="user_confirm"><?php echo __('Confirm password'); ?></label></td>
          <td class="field"><input class="textbox" id="user_confirm" maxlength="40" name="user[confirm]" size="20" type="password" value="" /></td>
        </tr>
      </table>
        <p>
            <?php echo __('Password should be at least 5 characters long.'); ?>
        </p>
      <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="c" value="<?php echo __('Change password'); ?>" />
      </p>
    </form>
</div>
