<?php

    namespace Service;

    use Model\FrameworkPageModel;

    class SurveyDrawer
    {
        public static function drawSurveyPage(FrameworkPageModel $page, $options, $errors)
        {

            echo
            "<div class=\"panel\">
                <div class=\"panel-heading clearfix\">
                    <h2 class='pull-left'>{$page->getName()}</h2>
                    <h2 class='pull-right'>{$page->getPageNumber()} / {$page->getPageCount()}</h2>
                </div>
                <hr>
                <div class=\"panel-body\">
                    <blockquote>{$page->getSubject()}</blockquote>
                    <form class=\"form-horizontal\" method=\"post\">";

            if ($page->getNextPage()) {
                echo "<input type='hidden' name='action' value='next'>";
            } else {
                echo "<input type='hidden' name='action' value='finish'>";
            }
            echo "<div class=\"list-group\">";

            $position = 1;
            foreach ($page->getQuestions() as $question) {
                echo  "<div class=\"panel\" id='{$question->getId()}'>
                            <div class=\"panel-heading clearfix\"><h4 class=\"pull-left";
                if (!is_null($errors)) {
                    if (in_array($question->getId(), $errors)) {
                        echo " text-danger";
                    }
                }
                echo "\"><strong>";

                if ($question->getMandatory() == 1) {
                    echo "<span class=\"text-danger glyphicon glyphicon-asterisk\"></span>";

                }
                echo "{$position}) </strong>{$question->getSubject()}</h4>";

                echo "</div><div class=\"panel-body\"><ul class=\"list-group\">";

                $pos = 1;
                foreach ($question->getOptions() as $option) {
                    echo  "<li class=\"list-group-item\"><label><h5>";
                    if ($question->getType() == 'single') {
                        if (!is_null($options)) {
                            if (key_exists($question->getId(), $options)
                                && $option->getId() == $options[$question->getId()]){
                                echo "<input type=\"radio\" name=\"q-{$question->getId()}\" value=\"{$option->getId()}\" checked>";
                            } else {
                                echo "<input type=\"radio\" name=\"q-{$question->getId()}\" value=\"{$option->getId()}\">";
                            }
                        } else {
                            echo "<input type=\"radio\" name=\"q-{$question->getId()}\" value=\"{$option->getId()}\">";
                        }
                    } else {
                        if (!is_null($options)) {
                            if (key_exists($question->getId() . "-" . $option->getId(), $options)
                                && $option->getId() == $options[$question->getId() . "-" . $option->getId()]) {
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
                echo "<button type='submit' class='btn btn-primary btn-md text-center pull-right'>Next
                        <span class=\"glyphicon glyphicon-chevron-right\"></span>
                        </button>";
            } else {
                echo "<button type='submit' class='btn btn-success btn-md text-center pull-right'>
                        <span class=\"glyphicon glyphicon-ok\"></span>
                        Finish
                        </button>";
            }

            echo "</form></div>";
            echo "</div>";
        }

        public static function drawPageStats(FrameworkPageModel $page)
        {
            $next = $page->getPageNumber()+1;
            $prev = $page->getPageNumber()-1;

            $position = 1;
            foreach ($page->getQuestions() as $question) {
                echo  "<div class=\"panel\">
                            <div class=\"panel-heading clearfix\">
                            <h4 class=\"pull-left\"> <strong>";

                if ($question->getMandatory() == 1) {
                    echo "<span class=\"text-danger glyphicon glyphicon-asterisk\"></span>";

                }
                echo "{$position}) </strong>{$question->getSubject()}</h4>";

                echo "</div><div class=\"panel-body\">";
                $array = null;

                foreach ($question->getOptions() as $option) {
                    $array[$option->getText()] = $option->getCount();
                }
                self::drawChart($array, $question->getId());

                echo "</div></div>";
                $position++;
            }

            if ($page->getNextPage()) {
                echo "<a type='submit' class='btn btn-primary btn-md text-center pull-right' 
                         href='/survey_generator/public/index.php/stats?id={$page->getSurvey()->getId()}&pg={$next}'>
                        Next
                        <span class=\"glyphicon glyphicon-chevron-right\"></span>
                        </a>";
            }
            if ($page->getPrevPage()) {
                echo "<a type='submit' class='btn btn-primary btn-md text-center pull-left' 
                         href='/survey_generator/public/index.php/stats?id={$page->getSurvey()->getId()}&pg={$prev}'>
                        <span class=\"glyphicon glyphicon-chevron-left\"></span>
                        Previous
                        </a>";
            }

            echo "</form></div>";
            echo "</div>";
        }

        private static function drawChart($array, $id)
        {
            $string = '';
            $count = 0;
            $total= 0;
            foreach ($array as $key => $value) {
                $count++;
                $total += $value;
                $string .= "['{$key}',{$value}],";
            }

            $height = $count * 30;
            $height += 100;
            echo "
            <script type=\"text/javascript\">

                google.charts.load('current', {'packages':['corechart']});

                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'word');
                    data.addColumn('number', 'Select');
                    data.addRows([{$string}]);
                    var options = {'title':\"Total number of Answers: {$total}\",
                               'width':\"100%\",
                               'height':\"{$height}\",
                               'backgroundColor': { fill:'transparent' }
                               };
          
                    var chart = new google.visualization.BarChart(document.getElementById('{$id}'));
                    chart.draw(data, options);
                }
            </script>";

            echo "<div id='{$id}' ></div>";
        }
    }