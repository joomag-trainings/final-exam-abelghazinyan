<?php

    namespace Model;

    class QuestionModel
    {
        private $id;
        private $page_id;
        private $subject;
        private $type;
        private $mandatory;
        private $position;

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
        public function getPageId()
        {
            return $this->page_id;
        }

        /**
         * @param mixed $page_id
         */
        public function setPageId($page_id)
        {
            $this->page_id = $page_id;
        }

        /**
         * @return mixed
         */
        public function getSubject()
        {
            return $this->subject;
        }

        /**
         * @param mixed $subject
         */
        public function setSubject($subject)
        {
            $this->subject = $subject;
        }

        /**
         * @return mixed
         */
        public function getType()
        {
            return $this->type;
        }

        /**
         * @param mixed $type
         */
        public function setType($type)
        {
            $this->type = $type;
        }

        /**
         * @return mixed
         */
        public function getMandatory()
        {
            return $this->mandatory;
        }

        /**
         * @param mixed $mandatory
         */
        public function setMandatory($mandatory)
        {
            $this->mandatory = $mandatory;
        }

        /**
         * @return mixed
         */
        public function getPosition()
        {
            return $this->position;
        }

        /**
         * @param mixed $position
         */
        public function setPosition($position)
        {
            $this->position = $position;
        }


    }