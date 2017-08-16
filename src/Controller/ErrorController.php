<?php

    namespace Controller;

    use Slim\Http\Request;
    use Slim\Http\Response;

    class ErrorController extends AbstractController
    {
        public function notFound(Request $request, Response $response, $args)
        {
            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "error/404.phtml",
                [

                ]
            );

            return $response->withStatus(404)->withHeader('Content-Type', 'text/html');
        }
    }