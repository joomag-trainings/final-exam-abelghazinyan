<?php

    use Slim\Http\Response;
    use Slim\Http\Request;

    require "../vendor/autoload.php";

    $configuration = [
        'settings' => [
            'displayErrorDetails' => true,
            'addContentLengthHeader' => false,
            'determineRouteBeforeAppMiddleware' => true,
        ],
    ];

    $container = new \Slim\Container($configuration);
    $app = new \Slim\App($container);

    require "../config/routes.php";

    $container = $app->getContainer();
    $container['view'] = new \Slim\Views\PhpRenderer("../view/");

    $container['notFoundHandler'] = function ($c) {
        return function ($request, $response) use ($c) {
            return $response->withRedirect("/survey_generator/public/index.php/error");
        };
    };

    /**
     * Middleware for not existing routes
     */
    $app->add(function (Request $request, Response $response, $next){

        $route = $request->getAttribute('route');
        if( $route == null) {
            throw new \Slim\Exception\NotFoundException($request, $response);
        } else {
            $arguments = $route->getArguments();
            if (!empty($arguments['page']) || is_null($request->getAttribute('routeInfo'))) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            } else {
                $response = $next($request, $response);
                return $response;
            }
        }
    });

    $app->run();
