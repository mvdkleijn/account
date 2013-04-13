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

/**
 * Account
 *
 * @todo finish phpdoc
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 */
class AccountSetting extends Record {
    const TABLE_NAME = 'account_setting';

    public $id;
    public $user_id;
    public $name;
    public $value;
    
    private static $fieldname_map;
    private static $fieldtype_map;
    private static $fieldvalid_map;

    public static function registerAccountSetting($id, $name, $type, $valid='[^a-zA-Z0-9_]') {
        if (eregi('[^a-zA-Z0-9 -_]', $id) || eregi('[^a-zA-Z0-9 -_]', $name) || eregi('[^a-z]', $type)) {
            return false;
        }
    
        self::$fieldname_map[$id] = $name;
        self::$fieldtype_map[$id] = $type;
        self::$fieldvalid_map[$id] = $valid;
        
        return true;
    }
    
    public static function accountSettingName($id) {
        return self::$fieldname_map[$id];
    }
/*
    public static function accountSettingType($id) {
        return self::$fieldtype_map[$id];
    }
*/
    public static function validAccountSetting($id, $value) {
        return (!eregi(self::$fieldvalid_map[$id], $value));
    }

/*
    public function __toString() {
        return $this->value;
    }
*/
    public static function find($id, $name) {
        return self::findByUserIdAndName($id, $name);
    }

    public static function findByUserId($id) {
        $where = 'user_id=?';
        $values = array($id);

        return self::findAllFrom('AccountSetting', $where, $values);
    }

    public static function findByUserIdAndName($id, $name) {
        $where = 'user_id=? AND name=?';
        $values = array($id, $name);

        return self::findOneFrom('AccountSetting', $where, $values);
    }

    public static function findByName($name) {
        $where = 'name=?';
        $values = array($name);

        return self::findAllFrom('AccountSetting', $where, $values);
    }

    public function beforeSave() {
        //if (!ctype_alnum($this->name))
          //  return false;
            
        return true;
    }
}