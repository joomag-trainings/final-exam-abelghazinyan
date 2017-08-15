<?php

    namespace Service;


    use Model\FrameworkPageModel;

    class SurveyDrawer
    {
        public static function draw(FrameworkPageModel $page, $options, $errors)
        {

            echo
            "<div class=\"panel\">
                <div class=\"panel-heading clearfix\">
                    <h2 class='pull-left'>{$page->getName()}</h2>
                    <h2 class='pull-right'>{$page->getPageNumber()} / {$page->getPageCount()}</h2>
                </div>
                <div class=\"panel-body\">
                    <pre>{$page->getSubject()}</pre>
                    <form class=\"form-horizontal\" method=\"post\">";

            if ($page->getNextPage()) {
                echo "<input type='hidden' name='action' value='next'>";
            } else {
                echo "<input type='hidden' name='action' value='finish'>";
            }
            echo "<div class=\"list-group\">";

            $next = $page->getPageNumber()+1;

            $position = 1;
            foreach ($page->getQuestions() as $question) {
                echo  "<div ";
                if (!is_null($errors)) {
                    if (in_array($question->getId(), $errors)) {
                        echo "style=\"background-color:#F72E45\"";
                    }
                }
                echo  "class=\"panel\" id='{$question->getId()}'>
                            <div class=\"panel-heading clearfix\">
                            <h4 class=\"pull-left\"> <strong>";

                if ($question->getMandatory() == 1) {
                    echo "<span class=\"text-danger glyphicon glyphicon-star-empty\"></span>";

                }
                echo "{$position}) </strong>{$question->getSubject()}</h4>";

                echo "</div><div class=\"panel-body\"><ul class=\"list-group\">";

                $pos = 1;
                foreach ($question->getOptions() as $option) {
                    echo  "<li class=\"list-group-item\"><label><h5>";
                    if ($question->getType() == 'single') {
                        if (!is_null($options)) {
                            if (key_exists($question->getId(), $options) && $option->getId() == $options[$question->getId()]){
                                echo "<input type=\"radio\" name=\"q-{$question->getId()}\" value=\"{$option->getId()}\" checked>";
                            } else {
                                echo "<input type=\"radio\" name=\"q-{$question->getId()}\" value=\"{$option->getId()}\">";
                            }
                        } else {
                            echo "<input type=\"radio\" name=\"q-{$question->getId()}\" value=\"{$option->getId()}\">";
                        }
                    } else {
                        if (!is_null($options)) {
                            if (key_exists($question->getId() . "-" . $option->getId(), $options) && $option->getId() == $options[$question->getId() . "-" . $option->getId()]) {
                                echo "<input type=\"checkbox\" name=\"q-{$question->getId()}-{$option->getId()}\" value=\"{$option->getId()}\" checked>";
                            } else {
                                echo "<input type=\"checkbox\" name=\"q-{$question->getId()}-{$option->getId()}\" value=\"{$option->getId()}\">";
                            }
                        } else {
                            echo "<input type=\"checkbox\" name=\"q-{$question->getId()}-{$option->getId()}\" value=\"{$option->getId()}\">";
                        }
                    }
                    echo   "<strong> {$pos})</strong>&nbsp;
                           {$option->getText()}</h5></label></li>";
                    $pos ++;
                }

                echo "</ul></div></div>";
                $position++;
            }

            if ($page->getNextPage()) {
                echo "<button type='submit' class='btn btn-primary btn-lg text-center pull-right'>Next</button>";
            } else {
                echo "<button type='submit' class='btn btn-success btn-lg text-center pull-right'>Finish</button>";
            }

            echo "</form></div>";
            echo "</div>";
        }
    }