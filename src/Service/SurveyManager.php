<?php

    namespace Service;


    class SurveyManager
    {
        private static $instance;
        private $connection;
        const SURVEY_STATE_IN_PROGRESS = 0;
        const SURVEY_STATE_CREATED = 1;

        private function __construct()
        {
            $this->connection = \Database\Connection::getInstance()->getConnection();
        }

        public static function getInstance()
        {
            if ( is_null( self::$instance ) )
            {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function addSurvey($name,$subject,$startDate,$expirationDate)
        {
            $state = self::SURVEY_STATE_IN_PROGRESS;
            $statement = $this->connection->prepare(
                "INSERT INTO surveys (id, name, subject, start_date, expiration_date, state) VALUES (NULL, :name, :subject, :startDate, :expirationDate, :state)"
            );

            $statement->bindParam('name',$name);
            $statement->bindParam('subject',$subject);
            $statement->bindParam('startDate',$startDate);
            $statement->bindParam('expirationDate', $expirationDate);
            $statement->bindParam('state', $state);

            $res = $statement->execute();
            if ($res == false) {
                throw new \Exception('PDO error');
            }
        }
    }