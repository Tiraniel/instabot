<?php

namespace Core {

    require_once ROOTDIR . '\libs\db.php';
    
    use DB as db;
    
    class Database {

        private static $_user = 'root';
        private static $_password = '';
        private static $_dbName = 'instabot';
        private static $_host = '127.0.0.1'; //defaults to localhost if omitted
        private static $_port = '3306'; // defaults to 3306 if omitted
        private static $_encoding = 'utf8'; // defaults to latin1 if omitted            

        public static function Init() {
            
            db::$user = self::$_user;
            db::$password = self::$_password;
            db::$dbName = self::$_dbName;
            db::$host = self::$_host; //defaults to localhost if omitted
            db::$port = self::$_port; // defaults to 3306 if omitted
            db::$encoding = self::$_encoding; // defaults to latin1 if omitted 
        }

    }

}
