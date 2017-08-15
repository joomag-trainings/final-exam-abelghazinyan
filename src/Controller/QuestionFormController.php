<?php

    namespace Controller;

    use Helper\Cleaner;
    use Service\PageManager;
    use Service\QuestionManager;
    use Service\OptionManager;
    use Slim\Http\Request;
    use Slim\Http\Response;

    class QuestionFormController extends AbstractController
    {
        private $subject;
        private $subjectError;
        private $type;
        private $mandatory;
        private $isSubmit;
        private $options;
        private $optionsErrors;
        private $optionBoxes;

        public function __construct($container)
        {
            parent::__construct($container);
            $this->subject = '';
            $this->type = '';
            $this->optionBoxes = null;
            $this->mandatory = 0;
            $this->options['option-1'] = '';
            $this->options['option-2'] = '';
            $this->subjectError = false;
            $this->isSubmit = false;
            $this->optionsErrors[0] = false;
            $this->optionsErrors[1] = false;
        }

        public function showPage(Request $request, Response $response, $args)
        {
            $id = $request->getParam('id');

            if ($this->verifyForm($request)) {
                try {
                    $questionId = QuestionManager::getInstance()->addQuestion($id,$this->subject,$this->type,$this->mandatory);
                    foreach ($this->options as $option) {
                        OptionManager::getInstance()->addOption($questionId, $option);
                    }
                    header("Location:/survey_generator/public/index.php/page?id={$id}");
                    exit;
                } catch (\Exception $exception) {
                    $this->subject = '';
                    $this->type = '';
                    $this->optionBoxes = null;
                    $this->mandatory = 0;
                    $this->options['option-1'] = '';
                    $this->options['option-2'] = '';
                    $this->subjectError = false;
                    $this->isSubmit = false;
                    $this->optionsErrors[0] = false;
                    $this->optionsErrors[1] = false;
                }
            }

            $viewRenderer = $this->container->get('view');

            $response = $viewRenderer->render(
                $response,
                "/forms/question_form.phtml",
                [
                    'id' => $id,
                    'subject' => $this->subject,
                    'subjectError' => $this->subjectError,
                    'type' => $this->type,
                    'mandatory' => $this->mandatory,
                    'isSubmit' => $this->isSubmit,
                    'options' => $this->options,
                    'optionsErrors' => $this->optionsErrors,
                    'optionBoxes' => $this->optionBoxes
                ]
            );


            return $response;
        }

        private function verifyForm(Request $request)
        {
            if ($request->getParam('form') == 'form') {
                $this->isSubmit = true;
                $this->subject = Cleaner::clean($request->getParam('subject'));

                if (empty($this->subject)) {
                    $this->subjectError = true;
                } else {
                    if (strlen($this->subject) > 200) {
                        $this->subjectError = true;
                        $this->subject = '';
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

                foreach ($params as $param) {
                    $this->param = Cleaner::clean($param);
                }

                $this->options = $params;

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

                if ($this->subjectError != '' || !isset($this->optionsErrors)) {
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
            $box .=" has-feedback' id='option{$index}' ><div class='col-sm-6 col-sm-offset-3'><input class='form-control' placeholder='Option {$index}' name='option-{$index}' value='";

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