<?php

    namespace Controller;

    use Slim\Http\Request;
    use Slim\Http\Response;

    class AdminController extends AbstractController
    {

        public function showPage(Request $request, Response $response, $args) {

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/admin.phtml",
                [

                ]
            );

            return $response;
        }

    }