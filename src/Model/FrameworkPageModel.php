<?php

    namespace Model;

    class FrameworkPageModel extends PageModel
    {
        /**
         * @var SurveyModel
         */
        private $survey;
        private $pageNumber;
        private $nextPage;
        private $prevPage;
        private $pageCount;
        /**
         * @var array
         */
        private $questions;

        /**
         * @return SurveyModel
         */
        public function getSurvey()
        {
            return $this->survey;
        }

        /**
         * @param SurveyModel $survey
         */
        public function setSurvey($survey)
        {
            $this->survey = $survey;
        }

        /**
         * @return mixed
         */
        public function getPageNumber()
        {
            return $this->pageNumber;
        }

        /**
         * @param mixed $pageNumber
         */
        public function setPageNumber($pageNumber)
        {
            $this->pageNumber = $pageNumber;
        }

        /**
         * @return mixed
         */
        public function getNextPage()
        {
            return $this->nextPage;
        }

        /**
         * @param mixed $nextPage
         */
        public function setNextPage($nextPage)
        {
            $this->nextPage = $nextPage;
        }

        /**
         * @return array
         */
        public function getQuestions()
        {
            return $this->questions;
        }

        /**
         * @param array $questions
         */
        public function setQuestions($questions)
        {
            $this->questions = $questions;
        }

        /**
         * @return mixed
         */
        public function getPageCount()
        {
            return $this->pageCount;
        }

        /**
         * @param mixed $pageCount
         */
        public function setPageCount($pageCount)
        {
            $this->pageCount = $pageCount;
        }

        /**
         * @return mixed
         */
        public function getPrevPage()
        {
            return $this->prevPage;
        }

        /**
         * @param mixed $prevPage
         */
        public function setPrevPage($prevPage)
        {
            $this->prevPage = $prevPage;
        }

    }