<?php

    namespace Model;

    class SurveyModel
    {
        private $id;
        private $name;
        private $subject;
        private $startDate;
        private $expirationDate;
        private $state;
        private $hash;

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
         * @return string
         */
        public function getName()
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName($name)
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getSubject()
        {
            return $this->subject;
        }

        /**
         * @param string $subject
         */
        public function setSubject($subject)
        {
            $this->subject = $subject;
        }

        /**
         * @return string
         */
        public function getStartDate()
        {
            return $this->startDate;
        }

        /**
         * @param string $startDate
         */
        public function setStartDate($startDate)
        {
            $this->startDate = $startDate;
        }

        /**
         * @return string
         */
        public function getExpirationDate()
        {
            return $this->expirationDate;
        }

        /**
         * @param string $expirationDate
         */
        public function setExpirationDate($expirationDate)
        {
            $this->expirationDate = $expirationDate;
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

        /**
         * @return string
         */
        public function getHash()
        {
            return $this->hash;
        }

        /**
         * @param mixed $hash
         */
        public function setHash($hash)
        {
            $this->hash = $hash;
        }

    }