<?php

    namespace Controller;

    use Helper\Cleaner;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class SurveyFormController extends AbstractController
    {
        public $name;
        public $subject;
        public $startDate;
        public $expirationDate;
        public $nameError;
        public $subjectError;
        public $startDateError;
        public $expirationDateError;
        public $isSubmit;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->name = '';
            $this->subject = '';
            $this->startDate = '';
            $this->expirationDate = '';
            $this->nameError = false;
            $this->subjectError = false;
            $this->startDateError = false;
            $this->expirationDateError = false;
            $this->isSubmit = false;
        }

        public function showPage(Request $request, Response $response, $args) {

            if ($this->verifyForm($request)) {
                try {
                    SurveyManager::getInstance()->addSurvey($this->name, $this->subject, $this->startDate, $this->expirationDate);
                    header("Location:/survey_generator/public/index.php/admin");
                    exit;
                } catch (\Exception $exception) {
                    $this->name = '';
                    $this->subject = '';
                    $this->startDate = '';
                    $this->expirationDate = '';
                    $this->nameError = true;
                    $this->subjectError = true;
                    $this->startDateError = true;
                    $this->expirationDateError = true;
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
                    if (strlen($this->name) > 500) {
                        $this->nameError = true;
                        $this->name = '';
                    }
                }

                $this->subject = Cleaner::clean($request->getParam('subject'));

                if (empty($this->subject)) {
                    $this->subjectError = true;
                }

                $this->startDate = Cleaner::clean($request->getParam('start_date'));

                $today = new \DateTime('now');
                $today = $today->format('Y-m-d');

                if (empty($this->startDate)) {
                    $this->startDateError = true;
                } else {
                    $parts = explode('-',$this->startDate);
                    if (sizeof($parts) <= 0 && sizeof($parts) >= 3) {
                        $this->startDateError = true;
                        $this->startDate = '';
                    } elseif (!checkdate($parts[1], $parts[2], $parts[0])) {
                        $this->startDateError = true;
                        $this->startDate = '';
                    } else {
                        if ($this->startDate < $today) {
                            $this->startDateError = true;
                            $this->startDate = '';
                        }
                    }
                }

                $this->expirationDate = Cleaner::clean($request->getParam('expiration_date'));

                if (empty($this->expirationDate)) {
                    $this->expirationDateError = true;
                } else {
                    $parts = explode('-',$this->expirationDate);
                    if (sizeof($parts) <= 0 && sizeof($parts) >= 3) {
                        $this->expirationDateError = true;
                        $this->expirationDate = '';
                    } elseif (!checkdate($parts[1], $parts[2], $parts[0])) {
                        $this->expirationDateError = true;
                        $this->expirationDate = '';
                    } else {
                        if ($this->expirationDate < $today) {
                            $this->expirationDateError = true;
                            $this->expirationDate = '';
                        } elseif ($this->startDateError == false) {
                            if ($this->expirationDate <= $this->startDate) {
                                $this->expirationDateError = true;
                                $this->expirationDate = '';
                                $this->startDateError = true;
                                $this->startDate = '';
                            }
                        }
                    }
                }

                if ($this->nameError != '' || $this->subjectError != '' || $this->startDateError != '' || $this->expirationDateError != '') {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

    }