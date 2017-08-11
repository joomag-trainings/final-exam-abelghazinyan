<?php

    $app->get('/admin', \Controller\AdminController::class . ':showPage')->setName("admin");
    $app->get('/admin={page}', \Controller\AdminController::class . ':getPage')->setName("admin");

    $app->get('/survey_form', \Controller\SurveyFormController::class . ':showPage')->setName("survey_form");
    $app->post('/survey_form', \Controller\SurveyFormController::class . ':showPage')->setName("survey_form");

    $app->get('/pages', \Controller\PagesController::class . ':showPages')->setName("pages");
    $app->get('/page_form', \Controller\PageFormController::class . ':showPage')->setName("page_form");
    $app->post('/page_form', \Controller\PageFormController::class . ':showPage')->setName("page_form");

    $app->get('/page', \Controller\PagesController::class . ':showPage')->setName("page");

    $app->get('/question_form', \Controller\QuestionFormController::class . ':showPage')->setName("question_form");
    $app->post('/question_form', \Controller\QuestionFormController::class . ':showPage')->setName("question_form");
