<?php

    namespace Controller;

    use Service\FrameworkManager;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class SurveyController extends AbstractController
    {
        private $options;
        private $optionsError;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->options = null;
            $this->optionsError = null;
        }

        public function show(Request $request, Response $response, $args)
        {
            session_start();
            session_unset();
            $hash = $args['hash'];
            header("Location:/survey_generator/public/index.php/survey/{$hash}&1");
            exit;
        }

        public function showPage(Request $request, Response $response, $args)
        {
            session_start();
            $hash = $args['hash'];
            $page = $args['page'];

            $prev = $page-1;
            if ($page < 1 || ($page != 1 && empty($_SESSION)) || ($page != 1 && empty($_SESSION["page-" . $prev])) || ($page >= 1 && !empty($_SESSION["page-" . $page]))) {
                return $response->withStatus(404);
            }

            $action = $request->getParam('action');

            $id = SurveyManager::getInstance()->getSurveyIdByHash($hash);

            if (!is_null($action)) {
                if ($action == 'next') {
                    if ($this->verifyInputs($request, $id, $page)) {
                        $_SESSION["page-" . $page] = $this->options;
                        $page++;
                        header("Location:/survey_generator/public/index.php/survey/{$hash}&{$page}");
                        exit;
                    }
                } else {
                    if ($this->verifyInputs($request, $id, $page)) {
                        $_SESSION["page-" . $page] = $this->options;
//                        echo "<pre>";
//                        echo var_dump($_SESSION);
//                        echo "</pre>";
                        try {
                            FrameworkManager::getInstance()->saveResults($_SESSION);
                        } catch (\Exception $exception) {
                            die($exception);
                        }
                        session_destroy();
                        header("Location:/survey_generator/public/index.php/");
                        exit;
                    }
                }
            }

            if (isset($id)) {
                $this->showSurveyPage($id,$page,$response);
            } else {
                return $response->withStatus(404);
            }
        }

        public function showSurveyPage($id, $page, $response)
        {
            $viewRenderer = $this->container->get('view');

            $pageModel = FrameworkManager::getInstance()->getFrameworkPage($id, $page);

            $response = $viewRenderer->render(
                $response,
                "/framework/survey.phtml",
                [
                    "page" => $pageModel,
                    "options" => $this->options,
                    "optionsError" => $this->optionsError
                ]
            );

            return $response;
        }

        public function verifyInputs(\Slim\Http\Request $request, $id, $page)
        {

            $params = $request->getParams();

            unset($params['action']);

            $questions = FrameworkManager::getInstance()->getFrameworkQuestions($id, $page);

            foreach ($questions as $question) {
                if ($question->getType() == "single") {
                    if (key_exists("q-" . $question->getId(), $params)) {
                        $this->options[$question->getId()] = $params["q-" . $question->getId()];
                    } elseif ($question->getMandatory() == 1) {
                        $this->optionsError[] = $question->getId();
                    }
                } else {
                    $error = true;
                    foreach ($question->getOptions() as $option) {
                        if (key_exists("q-" . $question->getId() . "-" . $option->getId(), $params)) {
                            $this->options[$question->getId() . "-" . $option->getId()] = $params["q-" . $question->getId() . "-" . $option->getId()];
                            $error = false;
                        }
                    }

                    if ($question->getMandatory() == 1 && $error) {
                            $this->optionsError[] = $question->getId();
                    }
                }
            }
            if (is_null($this->optionsError)) {
                return true;
            } else {
                return false;
            }
        }
    }