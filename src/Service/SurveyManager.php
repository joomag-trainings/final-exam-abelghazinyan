<?php

    namespace Service;


    use Model\SurveyModel;

    class SurveyManager
    {
        private static $instance;
        private $connection;
        const SURVEY_STATE_IN_PROGRESS = 0;
        const SURVEY_STATE_CREATED = 1;
        const SURVEY_LOAD_SIZE = 12;

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
                throw new \Exception('INSERTION ERROR');
            } else {
                $id = $this->connection->lastInsertId();
                $hash = hash('crc32', $id , false);
                $statement = $this->connection->prepare(
                    "UPDATE surveys SET hash='{$hash}' WHERE id='{$id}'"
                );
                $res = $statement->execute();
                if ($res == false) {
                    throw new \Exception('UPDATE ERROR');
                }
            }
        }

        public function  getSurveys($page)
        {
            $start = ($page - 1) * self::SURVEY_LOAD_SIZE;
            $limit = self::SURVEY_LOAD_SIZE;

            $statement=$this->connection->prepare("SELECT * FROM surveys LIMIT {$limit} OFFSET {$start}");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $surveys = null;
                foreach ($res as $row) {
                    $surveys[] = $this->setSurvey($row);
                }
                return $surveys;
            } else {
                return null;
            }
        }

        public function  getActiveSurveys($page)
        {
            $start = ($page - 1) * self::SURVEY_LOAD_SIZE;
            $limit = self::SURVEY_LOAD_SIZE;

            $statement=$this->connection->prepare("SELECT * FROM surveys WHERE state = 1 AND start_date <= now() AND expiration_date >= now() LIMIT {$limit} OFFSET {$start}");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $surveys = null;
                foreach ($res as $row) {
                    $surveys[] = $this->setSurvey($row);
                }
                return $surveys;
            } else {
                return null;
            }
        }

        public function getSurveyById($id)
        {
            $statement=$this->connection->prepare("SELECT * FROM surveys WHERE id='{$id}'");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ( $res != null ) {
               return $this->setSurvey($res);
            } else {
                return null;
            }
        }

        public function setSurveyState($id, $state)
        {
            $statement = $this->connection->prepare("
                          UPDATE surveys SET state='{$state}' WHERE id='{$id}'
            ");

            $res = $statement->execute();

            if (empty($res)) {
                throw new \Exception("Update Error");
            }
        }

        public function deleteSurvey($id)
        {
            $statement = $this->connection->prepare("SELECT * FROM surveys where id= '{$id}'");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($res)) {
                throw new \Exception("Invalid question id");
            }

            $statement=$this->connection->prepare("DELETE FROM surveys where id='{$id}'");
            $res = $statement->execute();

            if ($res == false) {
                throw new \Exception("Deleting gone wrong");
            }

        }

        public function getSurveyIdByHash($hash)
        {
            $statement=$this->connection->prepare("SELECT id FROM surveys WHERE hash='{$hash}'");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ( $res != null) {
                return $res['id'];
            } else {
                return null;
            }
        }

        private function setSurvey($row)
        {
            $survey = new SurveyModel();
            $survey->setId($row['id']);
            $survey->setName($row['name']);
            $survey->setSubject($row['subject']);
            $survey->setStartDate($row['start_date']);
            $survey->setExpirationDate($row['expiration_date']);
            $survey->setState($row['state']);
            $survey->setHash($row['hash']);
            return $survey;
        }
    }