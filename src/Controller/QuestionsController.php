<?php

    namespace Controller;

    use Service\FrameworkManager;
    use Service\PageManager;
    use Service\QuestionManager;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class QuestionsController extends QuestionFormController
    {
        public function showPage(Request $request, Response $response, $args)
        {

            parent::showPage($request, $response, $args);

            $id = $request->getParam('id');

            $page = PageManager::getInstance()->getPageById($id);

            $name = $page->getName();
            $subject = $page->getSubject();

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/page_questions.phtml",
                [
                    'id' => $id,
                    'name' => $name,
                    'pageSubject' => $subject,
                    'subject' => $this->questionSubject,
                    'subjectError' => $this->questionSubjectError,
                    'type' => $this->type,
                    'mandatory' => $this->mandatory,
                    'isSubmit' => $this->isSubmit,
                    'options' => $this->options,
                    'optionsErrors' => $this->optionsErrors,
                    'optionBoxes' => $this->optionBoxes
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