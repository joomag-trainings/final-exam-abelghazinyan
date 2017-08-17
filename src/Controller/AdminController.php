<?php

    namespace Controller;

    use Service\SurveyGroupListDrawer;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;
    use \Service\PageManager;

    class AdminController extends SurveyFormController
    {

        public function showPage(Request $request, Response $response, $args)
        {
            parent::showPage($request,$response,$args);

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/admin.phtml",
                [
                    'name' => $this->name,
                    'subject' => $this->subject,
                    'startDate' => $this->startDate,
                    'expirationDate' => $this->expirationDate,
                    'nameError' => $this->nameError,
                    'subjectError' => $this->subjectError,
                    'startDateError' => $this->startDateError,
                    'expirationDateError' => $this->expirationDateError,
                    'isSubmit' => $this->isSubmit
                ]
            );

            return $response;
        }

        public function getPage(Request $request, Response $response, $args)
        {
            $page = $args['pageNumber'];
            SurveyGroupListDrawer::drawGroupList($page,false);

            return $response;
        }

        public function saveSurvey(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            $pages = PageManager::getInstance()->getPages($id);

            $save = true;

            if (isset($pages)) {
                foreach ($pages as $page) {
                    if ($page->getState() == PageManager::PAGE_STATE_IN_PROGRESS) {
                        $save = false;
                    }
                }
            }

            if ( PageManager::getInstance()->getPagesQuantity($id) > 0 && $save) {
                SurveyManager::getInstance()->setSurveyState($id, SurveyManager::SURVEY_STATE_CREATED);
            } else {
                SurveyManager::getInstance()->setSurveyState($id, SurveyManager::SURVEY_STATE_IN_PROGRESS);
            }

            header("Location:/survey_generator/public/index.php/admin");
            exit;
        }

        public function deleteSurvey(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            try {
                SurveyManager::getInstance()->deleteSurvey($id);
            } catch (\Exception $exception) {
                die($exception->getMessage());
            }

            header("Location:/survey_generator/public/index.php/admin");
            exit;
        }

    }