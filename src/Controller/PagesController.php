<?php

    namespace Controller;

    use Service\PageManager;
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

            $survey = SurveyManager::getInstance()->getSurveyById($id);

            if (isset($survey)) {
                $this->name = $survey->getName();
                $this->subject = $survey->getSubject();
                $this->startDate = $survey->getStartDate();
                $this->expirationDate = $survey->getExpirationDate();
            }

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/pages.phtml",
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

            $page = PageManager::getInstance()->getPageById($id);

            if (isset($page)) {
                $this->name = $page->getName();
                $this->subject = $page->getSubject();
            }

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/page_questions.phtml",
                [
                    'id' => $id,
                    'name' => $this->name,
                    'subject' => $this->subject,
                ]
            );

            return $response;
        }

    }