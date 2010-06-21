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
<p class="button">
    <a href="<?php echo get_url('plugin/account/documentation'); ?>">
        <img src="<?php echo URL_PUBLIC; ?>wolf/plugins/account/images/documentation.png" align="middle" alt="documentation icon" />
        <?php echo __('Documentation'); ?>
    </a>
</p>
<p class="button">
    <a href="<?php echo get_url('plugin/account/settings'); ?>">
        <img src="<?php echo URL_PUBLIC; ?>wolf/plugins/account/images/settings.png" align="middle" alt="settings icon" />
        <?php echo __('Settings'); ?>
    </a>
</p>

<div class="box">
    <h2><?php echo __('About Account'); ?></h2>
    <p>
        <?php echo __('The Account plugin allows you to add a My Account page to your site.'); ?>
    </p>
    <p>
        <?php echo __('Homepage'); ?>: <a href="http://www.vanderkleijn.net/wolf-cms/plugins/account.html">Wolf CMS Account plugin</a><br/>
        <?php echo __('Homepage'); ?>: <a href="http://www.wolfcms.org/">Wolf CMS</a>
    </p>
    <p>
        <?php echo __('Plugin version'); ?>: 0.0.7 (2010-06-21)
    </p>
</div>
