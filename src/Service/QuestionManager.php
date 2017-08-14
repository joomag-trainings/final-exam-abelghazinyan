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

            $statement=$this->connection->prepare("SELECT * FROM questions WHERE page_id='{$page_id}' ORDER BY position DESC LIMIT 1");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ($res == null || $res['position'] == null) {
                $position = 1;
            } else {
                $position = $res['position'];
                $position ++;
            }

            $statement = $this->connection->prepare(
                "INSERT INTO questions (id, page_id, subject, type, mandatory, position) VALUES (NULL, :page_id, :subject, :type, :mandatory, :position)"
            );

            $statement->bindParam('page_id',$page_id);
            $statement->bindParam('subject',$subject);
            $statement->bindParam('type',$type);
            $statement->bindParam('mandatory',$mandatory);
            $statement->bindParam('position', $position);

            $res = $statement->execute();
            if ($res == false) {
                throw new \Exception('INSERTION ERROR');
            } else {
                return $this->connection->lastInsertId();
            }
        }

        public function  getQuestions($id,$page)
        {
            $start = ($page - 1) * self::QUESTION_LOAD_SIZE;
            $limit = self::QUESTION_LOAD_SIZE;

            $statement=$this->connection->prepare("SELECT * FROM questions WHERE page_id='{$id}' ORDER BY position ASC LIMIT {$limit} OFFSET {$start}");
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

        public function getQuestionsQuantity($pageId)
        {
            $statement=$this->connection->prepare("SELECT COUNT(*) FROM questions WHERE page_id='{$pageId}'");
            $statement->execute();
            $quantity = $statement->fetch(\PDO::FETCH_ASSOC);

            $quantity = $quantity['COUNT(*)'];

            return $quantity;
        }

        public function deleteQuestion($id)
        {
            $statement = $this->connection->prepare("SELECT * FROM questions where id= '{$id}'");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if (empty($res)) {
                throw new \Exception("Invalid question id");
            }

            $statement=$this->connection->prepare("DELETE FROM questions where id='{$id}'");
            $res = $statement->execute();

            if ($res == false) {
                throw new \Exception("Deleting gone wrong");
            }

        }

        public function arrangeQuestion($id, $dir)
        {
            $position = $this->getQuestionById($id)->getPosition();

            if ($dir == 'up') {
                $statement = $this->connection->prepare("
                                                    SELECT * FROM questions 
                                                    WHERE position < {$position}
                                                    GROUP BY id 
                                                    ORDER BY id DESC 
                                                    LIMIT 1");
                $statement->execute();
                $res = $statement->fetch(\PDO::FETCH_ASSOC);

                if (empty($res)) {
                    throw new \Exception("Invalid Select");
                }

            } else {
                $statement = $this->connection->prepare("
                                                    SELECT * FROM questions 
                                                    WHERE position > {$position}
                                                    GROUP BY id 
                                                    ORDER BY id ASC 
                                                    LIMIT 1");
                $statement->execute();
                $res = $statement->fetch(\PDO::FETCH_ASSOC);

                if (empty($res)) {
                    throw new \Exception("Invalid Select");
                }
            }

            $statement = $this->connection->prepare("
                          UPDATE questions SET position='{$res['position']}' WHERE id='{$id}';
                          UPDATE questions SET position='{$position}' WHERE id='{$res['id']}'
            ");

            $res = $statement->execute();

            if (empty($res)) {
                throw new \Exception("Update Error 2");
            }
        }
    }