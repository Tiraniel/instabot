<?php

namespace Core {

    require_once ROOTDIR . '\libs\db.php';

    use MeekroDB as db;

    class Database {

        private $_user = 'root';
        private $_password = '';
        private $_dbName = 'instabot';
        private $_host = '127.0.0.1'; //defaults to localhost if omitted
        private $_port = '3306'; // defaults to 3306 if omitted
        private $_encoding = 'utf8'; // defaults to latin1 if omitted            
        private $_connection;
        private static $_instance = null;

        function __construct() {
            $this->_connection = new db($this->_host, $this->_user, $this->_password, $this->_dbName, $this->_port, $this->_encoding);
        }

        static public function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        public function import() {
            
        }

        public function get() {
            
        }
        
        public function getConnection() {
            return $this->_connection;
        }        

    }

}
