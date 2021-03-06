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

<h2 class="title">Actions...</h2>
<div class="account-plugin-sidebar">
    <ul>
        <?php if (count($actions) == 0) { echo '<li>'.__('No actions available').'</li>'; } ?>
        <?php foreach($actions as $name => $link) { ?>
        <li><a href="<?php echo $link; ?>"><?php echo $name; ?></a></li>
        <?php } ?>
    </ul>
</div>