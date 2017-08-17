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
            $_SESSION['start'] = true;
            $hash = $args['hash'];

            $id = SurveyManager::getInstance()->getSurveyIdByHash($hash);

            if (is_null($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            } else {
                $survey = SurveyManager::getInstance()->getSurveyById($id);
                $today = new \DateTime('now');
                $today = $today->format('Y-m-d');

                if (($survey->getStartDate() <= $today) && ($survey->getExpirationDate() < $today )) {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/framework/intro.phtml",
                [
                   "name" => $survey->getName(),
                    "subject" => $survey->getSubject(),
                    "startDate" => $survey->getStartDate(),
                    "expirationDate" => $survey->getExpirationDate(),
                    "hash" => $hash
                ]
            );

            return $response;
        }

        public function showPage(Request $request, Response $response, $args)
        {
            session_start();
            $hash = $args['hash'];
            $page = $args['pageNumber'];

            if (!is_numeric($page)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $prev = $page-1;
            if (empty($_SESSION) ||
                ($page < 1) ||
                ($page != 1 && empty($_SESSION)) ||
                ($page != 1 && empty($_SESSION["page-" . $prev])) ||
                ($page >= 1 && !empty($_SESSION["page-" . $page]))) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $action = $request->getParam('action');

            $id = SurveyManager::getInstance()->getSurveyIdByHash($hash);

            if (is_null($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }
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
                        try {
                            FrameworkManager::getInstance()->saveResults($_SESSION);
                        } catch (\Exception $exception) {
                            die($exception);
                        }
                        header("Location:/survey_generator/public/index.php/success");
                        exit;
                    }
                }
            }

            $this->showSurveyPage($id,$page,$response);
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

        public function showSuccess(Request $request, Response $response, $args)
        {
            session_start();

            if (empty($_SESSION)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/framework/end.phtml",
                [

                ]
            );

            return $response;
        }
    }