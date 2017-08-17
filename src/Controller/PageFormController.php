<?php

    namespace Controller;

    use Helper\Cleaner;
    use Service\PageManager;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class PageFormController extends AbstractController
    {
        public $name;
        public $subject;
        public $nameError;
        public $subjectError;
        public $isSubmit;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->name = '';
            $this->subject = '';
            $this->nameError = false;
            $this->subjectError = false;
            $this->isSubmit = false;
        }

        public function showPage(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if (!is_numeric($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $survey = SurveyManager::getInstance()->getSurveyById($id);

            if (is_null($survey)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            } else {
                $today = new \DateTime('now');
                $today = $today->format('Y-m-d');

                if (($survey->getStartDate() <= $today) && ($survey->getExpirationDate() < $today )) {
                    throw new \Slim\Exception\NotFoundException($request, $response);
                }
            }

            if ($this->verifyForm($request)) {
                try {
                    $pageId = PageManager::getInstance()->addPage($id, $this->name, $this->subject);
                    header("Location:/survey_generator/public/index.php/pages?id={$id}#$pageId");
                    exit;
                } catch (\Exception $exception) {
                    $this->name = '';
                    $this->subject = '';
                    $this->nameError = true;
                    $this->subjectError = true;
                    $this->isSubmit = true;
                }
            }

            return $response;
        }

        private function verifyForm(Request $request)
        {
            if ($request->getParam('form') == 'form') {
                $this->isSubmit = true;
                $this->name = Cleaner::clean($request->getParam('name'));

                if (empty($this->name)) {
                    $this->nameError = true;
                } else {
                    if (strlen($this->name) > 100) {
                        $this->nameError = true;
                        $this->name = '';
                    }
                }

                $this->subject = Cleaner::clean($request->getParam('subject'));

                if (empty($this->subject)) {
                    $this->subjectError = true;
                }

                if ($this->nameError != '' || $this->subjectError != '') {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }