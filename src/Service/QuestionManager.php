<?php

    namespace Service;


    use Model\QuestionModel;

    class QuestionManager
    {
        private static $instance;
        private $connection;
        const QUESTION_LOAD_SIZE = 12;

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

        public function addQuestion($page_id,$subject,$type,$mandatory)
        {

            $statement = $this->connection->prepare(
                "INSERT INTO questions (id, page_id, subject, type, mandatory) VALUES (NULL, :page_id, :subject, :type, :mandatory)"
            );

            $statement->bindParam('page_id',$page_id);
            $statement->bindParam('subject',$subject);
            $statement->bindParam('type',$type);
            $statement->bindParam('mandatory', $mandatory);

            $res = $statement->execute();
            if ($res == false) {
                throw new \Exception('INSERTION ERROR');
            } else {
                return $this->connection->lastInsertId();
            }
        }

        public function  getQuestion($page)
        {
            $start = ($page - 1) * self::QUESTION_LOAD_SIZE;
            $limit = self::QUESTION_LOAD_SIZE;

            $statement=$this->connection->prepare("SELECT * FROM questions LIMIT {$limit} OFFSET {$start}");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $questions = null;
                foreach ($res as $row) {
                    $question = new QuestionModel();
                    $question->setId($row['id']);
                    $question->setPageId($row['page_id']);
                    $question->setSubject($row['subject']);
                    $question->setType($row['type']);
                    $question->setMandatory($row['mandatory']);
                    $question->setPosition($row['position']);
                    $questions[] = $question;
                }
                return $questions;
            } else {
                return null;
            }
        }

        public function getQuestionById($id)
        {
            $statement=$this->connection->prepare("SELECT * FROM questions WHERE id='{$id}'");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $question = new QuestionModel();
                $question->setId($res['id']);
                $question->setPageId($res['page_id']);
                $question->setSubject($res['subject']);
                $question->setType($res['type']);
                $question->setMandatory($res['mandatory']);
                $question->setPosition($res['position']);
                return $question;
            } else {
                return null;
            }
        }
    }