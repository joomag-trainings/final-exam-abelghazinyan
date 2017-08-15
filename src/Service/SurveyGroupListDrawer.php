<?php

    namespace Service;


    use Model\SurveyModel;

    class SurveyGroupListDrawer
    {
        public static function drawGroupList($page, $info)
        {
            $surveys = SurveyManager::getInstance()->getSurveys($page);
            if ( isset($surveys) ) {
                foreach ($surveys as $survey) {
                    if ($survey->getState() == '0') {
                        self::drawInProgressSurvey($survey);
                    } else {
                        $today = new \DateTime('now');
                        $today = $today->format('Y-m-d');

                        if (($survey->getStartDate() > $today)) {
                            self::drawNotStartedSurvey($survey);
                        }

                        if (($survey->getStartDate() <= $today) && ($survey->getExpirationDate() >= $today )) {
                            self::drawStartedSurvey($survey);
                        }

                        if (($survey->getStartDate() <= $today) && ($survey->getExpirationDate() < $today )) {
                            self::drawExpiredSurvey($survey);
                        }
                    }
                }
            } elseif ($info) {
                echo "<h1>Currently there are no surveys</h1>";
            }
        }

        public static function drawFrameworkList($page, $info)
        {
            $surveys = SurveyManager::getInstance()->getActiveSurveys($page);
            if ( isset($surveys) ) {
                foreach ($surveys as $survey) {
                    self::drawActiveSurvey($survey);
                }
            } elseif ($info) {
                echo "<h1>Currently there are no surveys</h1>";
            }
        }

        private static function drawActiveSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/survey/{$survey->getHash()}' class='list-group-item list-group-item-success clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                    </a>";
        }

        private static function drawInProgressSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-warning clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <form method='post' class='pull-right form-control-static' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'>
                                <button type='submit' class=\"btn btn-md btn-danger\"><span class=\"glyphicon glyphicon-trash\"></span></button>
                             </form>  
                        </span>
                    </a>";
        }

        private static function drawNotStartedSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-info clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <form method='post' class='pull-right form-control-static' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'>
                                <button type='submit' class=\"btn btn-md btn-danger\"><span class=\"glyphicon glyphicon-trash\"></span></button>
                             </form>  
                        </span>
                    </a>";
        }

        private static function drawStartedSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-success clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>       
                             <form method='post' class='pull-right form-control-static' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'>
                                <div class=\"btn-group\">
                                    <span class=\"btn btn-md btn-primary\" onclick=\"location.href = '/survey_generator/public/index.php/stats?id={$survey->getId()}&page=1'; event.stopPropagation();\">
                                        <span class=\"glyphicon glyphicon-stats\"></span>
                                    </span>    
                                    <button type='submit' class=\"btn btn-md btn-danger\"><span class=\"glyphicon glyphicon-trash\"></span></button>
                                </div>
                             </form>                            
                        </span>
                    </a>";
        }

        private static function drawExpiredSurvey(SurveyModel $survey)
        {
            echo "<a href='#' class='list-group-item list-group-item-danger clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <form method='post' class='pull-right form-control-static' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'>
                                <div class=\"btn-group\">
                                    <button class=\"btn btn-md btn-primary\" onclick=\"location . href = '/survey_generator/public/index.php/stats?id={$survey->getId()}&page=1'; event . stopPropagation();\">
                                        <span class=\"glyphicon glyphicon-stats\"></span>
                                    </button>    
                                    <button type='submit' class=\"btn btn-md btn-danger\"><span class=\"glyphicon glyphicon-trash\"></span></button>
                                </div>
                             </form>  
                        </span>
                    </a>";
        }
    }