<?php

    namespace Model;


    class PageModel
    {
        private $id;
        private $survey_id;
        private $name;
        private $subject;
        private $state;

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
        public function getSurveyId()
        {
            return $this->survey_id;
        }

        /**
         * @param mixed $survey_id
         */
        public function setSurveyId($survey_id)
        {
            $this->survey_id = $survey_id;
        }

        /**
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param mixed $name
         */
        public function setName($name)
        {
            $this->name = $name;
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
        public function getState()
        {
            return $this->state;
        }

        /**
         * @param mixed $state
         */
        public function setState($state)
        {
            $this->state = $state;
        }

    }