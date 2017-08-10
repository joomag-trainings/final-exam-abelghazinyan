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

    $app->run();
