<?php

    namespace Service;

    use Model\FrameworkPageModel;
    use Model\FrameworkQuestionModel;

    class FrameworkManager
    {
        private static $instance;
        private $connection;

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

        public function getFrameworkPage($id, $number)
        {
            $survey = SurveyManager::getInstance()->getSurveyById($id);

            $page = PageManager::getInstance()->getPageByNumber($id, $number);

            $pageCount = PageManager::getInstance()->getPagesQuantity($id);

            $pageNumber = $number;

            $number++;
            $nextPage = PageManager::getInstance()->getPageByNumber($id, $number);

            if ($nextPage == false) {
                $nextPage = false;
            } else {
                $nextPage = true;
            }

            $number--;
            if ($number == 1) {
                $prevPage = false;
            } else {
                $prevPage = true;
            }

            $questions = QuestionManager::getInstance()->getQuestions($page->getId());

            $frameworkQuestions = null;
            foreach ($questions as $question) {
                $options = OptionManager::getInstance()->getOptions($question->getId());
                $frameworkQuestion = new FrameworkQuestionModel();
                $frameworkQuestion->setOptions($options);
                $frameworkQuestion->setId($question->getId());
                $frameworkQuestion->setSubject($question->getSubject());
                $frameworkQuestion->setPageId($question->getPageId());
                $frameworkQuestion->setType($question->getType());
                $frameworkQuestion->setPosition($question->getPosition());
                $frameworkQuestion->setMandatory($question->getMandatory());
                $frameworkQuestions[] = $frameworkQuestion;
            }

            $frameworkPageModel = new FrameworkPageModel();

            $frameworkPageModel->setSurvey($survey);
            $frameworkPageModel->setNextPage($nextPage);
            $frameworkPageModel->setPrevPage($prevPage);
            $frameworkPageModel->setPageNumber($pageNumber);
            $frameworkPageModel->setQuestions($frameworkQuestions);
            $frameworkPageModel->setName($page->getName());
            $frameworkPageModel->setId($page->getId());
            $frameworkPageModel->setSurveyId($page->getSurveyId());
            $frameworkPageModel->setSubject($page->getSubject());
            $frameworkPageModel->setState($page->getState());
            $frameworkPageModel->setPageCount($pageCount);

            return $frameworkPageModel;
        }

        public function getFrameworkQuestions($id, $number)
        {
            $page = PageManager::getInstance()->getPageByNumber($id, $number);

            $questions = QuestionManager::getInstance()->getQuestions($page->getId());

            $frameworkQuestions = null;
            foreach ($questions as $question) {
                $options = OptionManager::getInstance()->getOptions($question->getId());
                $frameworkQuestion = new FrameworkQuestionModel();
                $frameworkQuestion->setOptions($options);
                $frameworkQuestion->setId($question->getId());
                $frameworkQuestion->setSubject($question->getSubject());
                $frameworkQuestion->setPageId($question->getPageId());
                $frameworkQuestion->setType($question->getType());
                $frameworkQuestion->setPosition($question->getPosition());
                $frameworkQuestion->setMandatory($question->getMandatory());
                $frameworkQuestions[] = $frameworkQuestion;
            }

            return $frameworkQuestions;
        }

        public function saveResults($answers)
        {
            foreach ($answers as $page) {
                foreach ($page as $optionId) {
                    $statement = $this->connection->prepare("
                          UPDATE options SET count=count+1 WHERE id='{$optionId}';
                    ");
                    $res = $statement->execute();

                    if (empty($res)) {
                        throw new \Exception("Update Error");
                    }
                }
            }
        }
    }