<?php

    namespace Controller;

    use Service\SurveyGroupListDrawer;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;
    use \Service\PageManager;

    class AdminController extends AbstractController
    {

        public function showPage(Request $request, Response $response, $args)
        {
            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "admin/admin.phtml",
                [

                ]
            );

            return $response;
        }

        public function getPage(Request $request, Response $response, $args)
        {
            $page = $args['page'];
            SurveyGroupListDrawer::drawGroupList($page,false);

            return $response;
        }

        public function saveSurvey(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            $pages = PageManager::getInstance()->getPages($id, 1);

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