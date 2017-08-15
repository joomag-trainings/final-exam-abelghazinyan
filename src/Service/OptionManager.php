<?php

    namespace Service;


    use Model\OptionModel;

    class OptionManager
    {
        private static $instance;
        private $connection;
        const OPTION_LOAD_SIZE = 12;

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

        public function addOption($question_id,$text)
        {

            $statement = $this->connection->prepare(
                "INSERT INTO options (id, question_id, text, count) VALUES (NULL, :question_id, :text, 0)"
            );

            $statement->bindParam('question_id',$question_id);
            $statement->bindParam('text',$text);

            $res = $statement->execute();
            if ($res == false) {
                throw new \Exception('INSERTION ERROR');
            }
        }

        public function  getOptions($id)
        {
            $statement=$this->connection->prepare("SELECT * FROM options WHERE question_id='{$id}'");
            $statement->execute();
            $res = $statement->fetchAll(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $options = null;
                foreach ($res as $row) {
                    $option = new OptionModel();
                    $option->setId($row['id']);
                    $option->setQuestionId($row['question_id']);
                    $option->setText($row['text']);
                    $option->setCount($row['count']);
                    $options[] = $option;
                }
                return $options;
            } else {
                return null;
            }
        }

        public function getOptionById($id)
        {
            $statement=$this->connection->prepare("SELECT * FROM options WHERE id='{$id}'");
            $statement->execute();
            $res = $statement->fetch(\PDO::FETCH_ASSOC);

            if ( isset($res) ) {
                $option = new OptionModel();
                $option->setId($res['id']);
                $option->setQuestionId($res['question_id']);
                $option->setText($res['text']);
                $option->setCount($res['count']);
                return $option;
            } else {
                return null;
            }
        }
    }