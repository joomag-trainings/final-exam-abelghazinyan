<?php

    $app->get('/error', \Controller\ErrorController::class . ':notFound')->setName("404");
    $app->get('/success', \Controller\SurveyController::class . ':showSuccess')->setName("success");

    $app->get('/admin', \Controller\AdminController::class . ':showPage')->setName("admin");
    $app->post('/admin', \Controller\AdminController::class . ':showPage')->setName("admin");
    $app->get('/admin={pageNumber}', \Controller\AdminController::class . ':getPage')->setName("admin");
    $app->post('/survey_save', \Controller\AdminController::class . ':saveSurvey')->setName("admin");
    $app->post('/survey_delete', \Controller\AdminController::class . ':deleteSurvey')->setName("admin");

    $app->get('/pages', \Controller\PagesController::class . ':showPages')->setName("pages");
    $app->post('/pages', \Controller\PagesController::class . ':showPages')->setName("pages");

    $app->post('/page_save', \Controller\PagesController::class . ':savePage')->setName("page");
    $app->post('/page_delete', \Controller\PagesController::class . ':deletePage')->setName("page");

    $app->get('/page', \Controller\QuestionsController::class . ':showPage')->setName("questions");
    $app->post('/page', \Controller\QuestionsController::class . ':showPage')->setName("questions");
    $app->get('/stats', \Controller\QuestionsController::class . ':showStats')->setName("questions");
    $app->post('/question_delete', \Controller\QuestionsController::class . ':deleteQuestion')->setName("questions");
    $app->post('/question_arrange', \Controller\QuestionsController::class . ':arrangeQuestion')->setName("questions");

    $app->get('/', \Controller\FrameworkController::class . ':showPage')->setName("framework");
    $app->get('/{page}', \Controller\FrameworkController::class . ':getPage')->setName("framework");

    $app->get('/survey/{hash}&{pageNumber}', \Controller\SurveyController::class . ':showPage')->setName("survey");
    $app->post('/survey/{hash}&{pageNumber}', \Controller\SurveyController::class . ':showPage')->setName("survey");
    $app->get('/survey/{hash}', \Controller\SurveyController::class . ':show')->setName("survey");