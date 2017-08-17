<?php

    namespace Controller;

    use Service\FrameworkManager;
    use Service\PageManager;
    use Service\QuestionManager;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class PagesController extends AbstractController
    {

        private $name;
        private $subject;
        private $startDate;
        private $expirationDate;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->name = '';
            $this->subject = '';
            $this->startDate = '';
            $this->expirationDate = '';
        }

        public function showPages(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if (!is_numeric($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $survey = SurveyManager::getInstance()->getSurveyById($id);

            if (is_null($survey)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            } else {
                $today = new \DateTime('now');
                $today = $today->format('Y-m-d');

                if (($survey->getStartDate() <= $today) && ($survey->getExpirationDate() < $today )) {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }

            $this->name = $survey->getName();
            $this->subject = $survey->getSubject();
            $this->startDate = $survey->getStartDate();
            $this->expirationDate = $survey->getExpirationDate();


            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/pages.phtml",
                [
                    'id' => $id,
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'startDate' => $this->startDate,
                    'expirationDate' => $this->expirationDate
                ]
            );

            return $response;
        }

        public function showPage(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if (!is_numeric($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $page = PageManager::getInstance()->getPageById($id);

            if (is_null($page)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $survey = SurveyManager::getInstance()->getSurveyById($page->getSurveyId());

            if (is_null($survey)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            } else {
                $today = new \DateTime('now');
                $today = $today->format('Y-m-d');

                if (($survey->getStartDate() <= $today) && ($survey->getExpirationDate() < $today )) {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }

            $this->name = $page->getName();
            $this->subject = $page->getSubject();

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/page_questions.phtml",
                [
                    'id' => $id,
                    'name' => $this->name,
                    'subject' => $this->subject,
                ]
            );

            return $response;
        }

        public function deleteQuestion(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');
            $page_id = $request->getParam('page_id');

            try {
                QuestionManager::getInstance()->deleteQuestion($id);
            } catch (\Exception $exception) {
                die($exception->getMessage());
            }

            header("Location:/survey_generator/public/index.php/page?id={$page_id}");
            exit;
        }

        public function arrangeQuestion(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');
            $page_id = $request->getParam('page_id');
            $dir = $request->getParam('dir');
            $anchor = $request->getParam('anchor');

            try {
                QuestionManager::getInstance()->arrangeQuestion($id, $dir);
            } catch (\Exception $exception) {
                die($exception->getMessage());
            }

            header("Location:/survey_generator/public/index.php/page?id={$page_id}#$anchor");
            exit;
        }

        public function savePage(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if ( QuestionManager::getInstance()->getQuestionsQuantity($id) > 0) {
                PageManager::getInstance()->setPageState($id, PageManager::PAGE_STATE_CREATED);
            } else {
                PageManager::getInstance()->setPageState($id, PageManager::PAGE_STATE_IN_PROGRESS);
            }

            $survey_id = PageManager::getInstance()->getPageSurveyId($id);
            header("Location:/survey_generator/public/index.php/pages?id={$survey_id}");
            exit;
        }

        public function deletePage(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');
            $survey_id = $request->getParam('survey_id');

            try {
                PageManager::getInstance()->deletePage($id);
            } catch (\Exception $exception) {
                die($exception->getMessage());
            }

            header("Location:/survey_generator/public/index.php/pages?id={$survey_id}");
            exit;
        }

        public function showStats(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if (!is_numeric($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $pageNumber = $request->getParam('pg');

            if (!is_numeric($pageNumber)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            if ($pageNumber < 1) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $survey = SurveyManager::getInstance()->getSurveyById($id);

            if (is_null($survey)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            } else {
                if ($survey->getState() == '0') {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                } else {
                    $today = new \DateTime('now');
                    $today = $today->format('Y-m-d');

                    if (($survey->getStartDate() > $today)) {
                        throw new \Slim\Exception\NotFoundException($request, $response);
                    }
                }
            }

            if ($pageNumber > PageManager::getInstance()->getPagesQuantity($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $page = FrameworkManager::getInstance()->getFrameworkPage($id, $pageNumber);

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/stats.phtml",
                [
                    'id' => $id,
                    'page' => $page
                ]
            );

            return $response;
        }

    }