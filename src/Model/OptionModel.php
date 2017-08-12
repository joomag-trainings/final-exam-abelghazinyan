<?php

    namespace Model;


    class OptionModel
    {
        private $id;
        private $question_id;
        private $text;
        private $count;

        /**
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * @param mixed $id
         */
        public function setId($id)
        {
            $this->id = $id;
        }

        /**
         * @return mixed
         */
        public function getQuestionId()
        {
            return $this->question_id;
        }

        /**
         * @param mixed $question_id
         */
        public function setQuestionId($question_id)
        {
            $this->question_id = $question_id;
        }

        /**
         * @return mixed
         */
        public function getText()
        {
            return $this->text;
        }

        /**
         * @param mixed $text
         */
        public function setText($text)
        {
            $this->text = $text;
        }

        /**
         * @return mixed
         */
        public function getCount()
        {
            return $this->count;
        }

        /**
         * @param mixed $count
         */
        public function setCount($count)
        {
            $this->count = $count;
        }


    }