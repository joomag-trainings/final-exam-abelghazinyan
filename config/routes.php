<?php

    $app->get('/admin', \Controller\AdminController::class . ':showPage')->setName("admin");
    $app->get('/wizard', \Controller\WizardController::class . ':showPage')->setName("wizard");
    $app->post('/wizard', \Controller\WizardController::class . ':showPage')->setName("wizard");
