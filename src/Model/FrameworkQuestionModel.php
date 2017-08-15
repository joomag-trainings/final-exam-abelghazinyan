<?php

    namespace Model;


    use Service\OptionManager;

    class FrameworkQuestionModel extends QuestionModel
    {
        /**
         * @var array
         */
        private $options;

        /**
         * @return mixed
         */
        public function getOptions()
        {
            return $this->options;
        }

        /**
         * @param mixed $options
         */
        public function setOptions($options)
        {
            $this->options = $options;
        }

    }