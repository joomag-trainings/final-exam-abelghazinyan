<?php

    namespace Controller;

    use Helper\Cleaner;
    use Service\PageManager;
    use Service\QuestionManager;
    use Service\OptionManager;
    use Service\SurveyManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class QuestionFormController extends AbstractController
    {
        public $questionSubject;
        public $questionSubjectError;
        public $type;
        public $mandatory;
        public $isSubmit;
        public $options;
        public $optionsErrors;
        public $optionBoxes;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->questionSubject = '';
            $this->type = '';
            $this->optionBoxes = null;
            $this->mandatory = 0;
            $this->options['option-1'] = '';
            $this->options['option-2'] = '';
            $this->questionSubjectError = false;
            $this->isSubmit = false;
            $this->optionsErrors[0] = false;
            $this->optionsErrors[1] = false;
        }

        public function showPage(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if (!is_numeric($id)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $page = PageManager::getInstance()->getPageById($id);

            if (is_null($page)) {
                throw new \Slim\Exception\NotFoundException($request, $response);
            }

            $survey = SurveyManager::getInstance()->getSurveyById($page->getSurveyId());

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
                    $questionId = QuestionManager::getInstance()->addQuestion($id,$this->questionSubject,$this->type,$this->mandatory);
                    foreach ($this->options as $option) {
                        OptionManager::getInstance()->addOption($questionId, $option);
                    }
                    header("Location:/survey_generator/public/index.php/page?id={$id}");
                    exit;
                } catch (\Exception $exception) {
                    $this->questionSubject = '';
                    $this->type = '';
                    $this->optionBoxes = null;
                    $this->mandatory = 0;
                    $this->options['option-1'] = '';
                    $this->options['option-2'] = '';
                    $this->questionSubjectError = false;
                    $this->isSubmit = false;
                    $this->optionsErrors[0] = false;
                    $this->optionsErrors[1] = false;
                }
            }

            return $response;
        }

        private function verifyForm(Request $request)
        {
            if ($request->getParam('form') == 'form') {
                $this->isSubmit = true;
                $this->questionSubject = Cleaner::clean($request->getParam('subject'));

                if (empty($this->questionSubject)) {
                    $this->questionSubjectError = true;
                } else {
                    if (strlen($this->questionSubject) > 200) {
                        $this->questionSubjectError = true;
                        $this->questionSubject = '';
                    }
                }

                $this->type = Cleaner::clean($request->getParam('type'));

                $this->mandatory = Cleaner::clean($request->getParam('mandatory'));

                if (!isset($this->mandatory)) {
                    $this->mandatory = 0;
                }

                $params = $request->getParams();
                unset($params['id']);
                unset($params['form']);
                unset($params['subject']);
                unset($params['type']);
                unset($params['mandatory']);

                foreach ($params as $key => $param) {
                    $this->options[$key] = Cleaner::clean($param);
                }

                $this->optionsErrors = null;

                foreach ($this->options as $option) {
                    if (empty($option)) {
                        $this->optionsErrors[] = true;
                    } elseif (strlen($option) > 100) {
                        $this->optionsErrors[] = true;
                    } else {
                        $this->optionsErrors[] = false;
                    }
                }

                if (sizeof($this->options) > 2) {
                    for ($i = 2; $i < sizeof($this->options); $i++) {
                        $this->optionBoxes .= $this->drawOptionBox($i);
                    }
                }

                $optionError = false;

                foreach ($this->optionsErrors as $error) {
                    if ($error) {
                        $optionError = true;
                    }
                }

                if ($this->questionSubjectError != '' || $optionError) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }

        private function drawOptionBox($index)
        {

            $box = " <div class='form-group ";

            if ($this->optionsErrors[$index]) {
                $box .= "has-error";
            } else {
                $box .= "has-success";
            } 
            $index++;
            $box .=" has-feedback' id='option{$index}' ><div class='col-sm-12'><input class='form-control' placeholder='Option {$index}' name='option-{$index}' value='";

            $box .= $this->options["option-{$index}"];
            $box .= "'/>";
            $index--;
            if ($this->optionsErrors[$index]) {
                $box .= "<span class='glyphicon glyphicon-remove form-control-feedback'></span>";
            } else {
                $box .= "<span class='glyphicon glyphicon-ok form-control-feedback'></span>";
            }
            $box .="</div></div>";

            return $box;
        }
    }