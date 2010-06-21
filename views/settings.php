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

<h1>Account &ndash; <?php echo __('Settings'); ?></h1>

<form action="<?php echo get_url('plugin/account/save'); ?>" method="post">
    <fieldset style="padding: 0.5em;">
        <legend style="padding: 0em 0.5em 0em 0.5em; font-weight: bold;"><?php echo __('General settings'); ?></legend>
        <table class="fieldset" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td class="label"><label for="settings[uri]"><?php echo __('Base uri'); ?>: </label></td>
                <td class="field"><input class="textbox" id="settings[uri]" maxlength="255" name="settings[uri]" size="255" type="text" value="<?php echo $settings['uri']; ?>" /></td>
                <td class="help"><?php echo __('The relative uri to the account page. Do not add the subdirectory if Wolf lives in a subdirectory. <br/>Default: account'); ?></td>
            </tr>
            <tr>
                <td class="label"><label for="settings[layout]"><?php echo __('Layout'); ?>: </label></td>
                <td class="field"><select id="settings[layout]" name="settings[layout]">
                <?php foreach($layouts as $layout) { ?>
                    <option value="<?php echo $layout->id; ?>" <?php if($settings[layout] == $layout->id) echo 'selected="selected"'; ?>><?php echo $layout->name; ?></option>
                <?php } ?>
                </select></td>
                <td class="help"><?php echo __('The layout to use for the account pages.'); ?></td>
            </tr>
        </table>
    </fieldset>
    <p class="buttons">
        <input class="button" name="commit" type="submit" accesskey="s" value="<?php echo __('Save'); ?>" />
    </p>
</form>