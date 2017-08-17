<?php

    namespace Service;


    use Model\QuestionModel;
    use Model\OptionModel;

    class QuestionGroupListDrawer
    {
        public static function drawGroupList($id, $info)
        {
            $questions = QuestionManager::getInstance()->getQuestions($id);
            if ( isset($questions) ) {
                $position = 1;
                foreach ($questions as $question) {
                    self::drawQuestion($id, $position, $question);
                    $position ++;
                }
            } elseif ($info) {
                echo "<h4 class='text-info' align='center'>Currently there are no questions</h4>";
            }
        }

        private static function drawQuestion($pageId, $position, QuestionModel $question)
        {
            $options = OptionManager::getInstance()->getOptions($question->getId(), 1);

            $optionQuantity = QuestionManager::getInstance()->getQuestionsQuantity($pageId);

            echo  "<div class=\"panel\" id='{$question->getId()}'>
                   <div class=\"panel-heading clearfix\">
                       <h4 class=\"pull-left\"> <strong>";

            if ($question->getMandatory() == 1) {
                echo "<span class=\"text-danger glyphicon glyphicon-asterisk\"></span>";
            }

            echo "{$position}) </strong>{$question->getSubject()}</h4>
                        <span class=\"pull-right\">
                             <form method='post' class='pull-right form-control-static' action='/survey_generator/public/index.php/question_delete?id={$question->getId()}&page_id={$pageId}'>
                                 <button type='submit' class=\"btn btn-md\"><span class=\"glyphicon glyphicon-trash text-danger\"></span></button>
                             </form>
                             <form method='post' class='pull-right form-control-static' action='/survey_generator/public/index.php/question_arrange?id={$question->getId()}&page_id={$pageId}'>
                                <input type='hidden' name='anchor' value='{$question->getId()}'>
                                <div class=\"btn-group btn-group-vertical\">";

            if ($position == 1 && $optionQuantity != 1) {
                echo "<button class=\"btn btn-xs\" disabled>
                        <span style=\"color:black;\" class=\"glyphicon glyphicon-triangle-top\"></span>
                      </button>";
                echo "<button type='submit' class=\"btn btn-xs\" name='dir' value='down'>
                        <span style=\"color:black;\" class=\"glyphicon glyphicon-triangle-bottom\"></span>
                      </button>";
            }

            if ($position > 1 && $position < $optionQuantity && $optionQuantity != 1) {
                echo "<button type='submit' class=\"btn btn-xs\" name='dir' value='up'>
                         <span style=\"color:black;\" class=\"glyphicon glyphicon-triangle-top\"></span>
                      </button>";
                echo "<button type='submit' class=\"btn btn-xs\" name='dir' value='down'>
                        <span style=\"color:black;\" class=\"glyphicon glyphicon-triangle-bottom\"></span>
                      </button>";
            }

            if ($position == $optionQuantity && $optionQuantity != 1) {
                echo "<button type='submit' class=\"btn btn-xs\" name='dir' value='up'>
                         <span style=\"color:black;\" class=\"glyphicon glyphicon-triangle-top\"></span>
                      </button>";
                echo "<button class=\"btn btn-xs\" disabled>
                        <span style=\"color:black;\" class=\"glyphicon glyphicon-triangle-bottom\"></span>
                      </button>";
            }

            echo "</form></div></span></div><div class=\"panel-body\"><ul class=\"list-group\">";
            echo "<h5 class='text-danger text-uppercase'>{$question->getType()}-select </h5>";

            $pos = 1;
            foreach ($options as $option) {
                echo  "<li class=\"list-group-item\"><strong>{$pos})</strong> {$option->getText()}</li>";
                $pos ++;
            }
                           
                           
            echo "</ul></div></div>";
        }
    }