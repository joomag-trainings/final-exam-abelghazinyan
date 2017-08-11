<?php

    namespace Controller;

    use Service\SurveyGroupListDrawer;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class AdminController extends AbstractController
    {

        public function showPage(Request $request, Response $response, $args)
        {
            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/admin.phtml",
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

    }