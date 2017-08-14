<?php

    namespace Service;


    use Model\PageModel;

    class PageManager
    {
        private static $instance;
        private $connection;
        const PAGE_STATE_IN_PROGRESS = 0;
        const PAGE_STATE_CREATED = 1;
        const PAGE_LOAD_SIZE = 12;

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

        public function addPage($survey_id, $name, $subject)
        {

            $state = self::PAGE_STATE_IN_PROGRESS;
            $statement = $this->connection->prepare(
                "INSERT INTO pages (id, survey_id, name, subject, state) VALUES (NULL, :survey_id, :name, :subject, :state)"
            );

            $statement->bindParam('survey_id',$survey_id);
            $statement->bindParam('name',$name);
            $statement->bindParam('subject',$subject);
            $statement->bindParam('state', $state);

            $res = $statement->execute();
            if ($res == false) {
                throw new \Exception('INSERTION ERROR');
            }
        }

        public function  getPages($id, $page)
        {
            $start = ($page - 1) * self::PAGE_LOAD_SIZE;
            $limit = self::PAGE_LOAD_SIZE;

            $statement=$this->connection->prepare("SELECT * FROM pages WHERE survey_id='{$id}' LIMIT {$limit} OFFSET {$start}");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $pages = null;
                foreach ($res as $row) {
                    $page = new PageModel();
                    $page->setId($row['id']);
                    $page->setSurveyId($row['survey_id']);
                    $page->setName($row['name']);
                    $page->setSubject($row['subject']);
                    $page->setState($row['state']);
                    $pages[] = $page;
                }
                return $pages;
            } else {
                return null;
            }
        }

        public function getPageById($id)
        {
            $statement=$this->connection->prepare("SELECT * FROM pages WHERE id='{$id}'");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $page = new PageModel();
                $page->setId($res['id']);
                $page->setId($res['survey_id']);
                $page->setName($res['name']);
                $page->setSubject($res['subject']);
                $page->setState($res['state']);
                return $page;
            } else {
                return null;
            }
        }

        public function getPageSurveyId($id)
        {
            $statement=$this->connection->prepare("SELECT survey_id FROM pages WHERE id='{$id}'");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                return $res['survey_id'];
            } else {
                return null;
            }
        }

        public function setPageState($id, $state)
        {
            $statement = $this->connection->prepare("
                          UPDATE pages SET state='{$state}' WHERE id='{$id}'
            ");

            $res = $statement->execute();

            if (empty($res)) {
                throw new \Exception("Update Error");
            }
        }

        public function getPagesQuantity($surveyId)
        {
            $statement=$this->connection->prepare("SELECT COUNT(*) FROM pages WHERE survey_id='{$surveyId}'");
            $statement->execute();
            $quantity = $statement->fetch(\PDO::FETCH_ASSOC);

            $quantity = $quantity['COUNT(*)'];

            return $quantity;
        }

        public function deletePage($id)
        {
            $statement = $this->connection->prepare("SELECT * FROM pages where id= '{$id}'");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($res)) {
                throw new \Exception("Invalid question id");
            }

            $statement=$this->connection->prepare("DELETE FROM pages where id='{$id}'");
            $res = $statement->execute();

            if ($res == false) {
                throw new \Exception("Deleting gone wrong");
            }

        }
    }