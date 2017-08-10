<?php

    namespace Database;

    class Connection
    {
        private static $instance;
        private $connection;

        private function __construct()
        {
            $config = include ('../config/database.php');

            $this->connection = new \PDO("mysql:host=localhost;dbname={$config['dbname']}",$config['username'],$config['password']);
        }

        public static function getInstance()
        {
            if (self::$instance === null) {
                self::$instance = new Connection();
            }
            return self::$instance;
        }

        public function getConnection()
        {
            return $this->connection;
        }
    }