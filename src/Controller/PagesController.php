<?php

    namespace Controller;

    use Service\PageManager;
    use Service\QuestionManager;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class PagesController extends PageFormController
    {

        private $pageName;
        private $pageSubject;
        private $startDate;
        private $expirationDate;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->pageName = '';
            $this->pageSubject = '';
            $this->startDate = '';
            $this->expirationDate = '';
        }

        public function showPages(Request $request, Response $response, $args)
        {
            parent::showPage($request, $response, $args);

            $id = $request->getParam('id');

            $survey = SurveyManager::getInstance()->getSurveyById($id);

            $this->pageName = $survey->getName();
            $this->pageSubject = $survey->getSubject();
            $this->startDate = $survey->getStartDate();
            $this->expirationDate = $survey->getExpirationDate();


            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/pages.phtml",
                [
                    'id' => $id,
                    'pageName' => $this->pageName,
                    'pageSubject' => $this->pageSubject,
                    'startDate' => $this->startDate,
                    'expirationDate' => $this->expirationDate,
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'nameError' => $this->nameError,
                    'subjectError' => $this->subjectError,
                    'isSubmit' => $this->isSubmit
                ]
            );

            return $response;
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

    }