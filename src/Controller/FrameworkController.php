<?php

    namespace Controller;

    use \Service\SurveyGroupListDrawer;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class FrameworkController extends AbstractController
    {
        public function showPage(Request $request, Response $response, $args)
        {
            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/framework/framework.phtml",
                [

                ]
            );

            return $response;
        }

        public function getPage(Request $request, Response $response, $args)
        {
            $page = $args['page'];
            SurveyGroupListDrawer::drawFrameworkList($page,false);

            return $response;
        }
    }