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

                        if (($survey->getStartDate() < $today) && ($survey->getExpirationDate() > $today )) {
                            self::drawStartedSurvey($survey);
                        }

                        if (($survey->getStartDate() < $today) && ($survey->getExpirationDate() < $today )) {
                            self::drawExpiredSurvey($survey);
                        }
                    }
                }
            } elseif ($info) {
                echo "<h1>Currently there are no surveys</h1>";
            }
        }

        private static function drawInProgressSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-warning clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <span class='btn btn-md btn-danger' onclick=\"location.href = ''; event.stopPropagation();\">
                                 <span class='glyphicon glyphicon-trash'></span>
                             </span>
                        </span>
                    </a>";
        }

        private static function drawNotStartedSurvey(SurveyModel $survey)
        {
            echo "<a href='#' class='list-group-item list-group-item-info clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <span class='btn btn-md btn-danger' onclick=\"location.href = ''; event.stopPropagation();\">
                                 <span class='glyphicon glyphicon-trash'></span>
                             </span>
                        </span>
                    </a>";
        }

        private static function drawStartedSurvey(SurveyModel $survey)
        {
            echo "<a href='#' class='list-group-item list-group-item-success clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <div class=\"btn-group\">
                                 <span class=\"btn btn-md btn-default\" onclick=\"location.href = ''; event.stopPropagation();\">
                                     <span class=\"glyphicon glyphicon-stats\"></span>
                                 </span>
                                 <span class=\"btn btn-md btn-danger\" onclick=\"location.href = ''; event.stopPropagation();\">
                                     <span class=\"glyphicon glyphicon-trash\"></span>
                                 </span>
                             </div>
                        </span>
                    </a>";
        }

        private static function drawExpiredSurvey(SurveyModel $survey)
        {
            echo "<a href='#' class='list-group-item list-group-item-danger clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$survey->getName()}</h4>
                        <span class='pull-right'>
                             <div class=\"btn-group\">
                                 <span class=\"btn btn-md btn-default\" onclick=\"location.href = ''; event.stopPropagation();\">
                                     <span class=\"glyphicon glyphicon-stats\"></span>
                                 </span>
                                 <span class=\"btn btn-md btn-danger\" onclick=\"location.href = ''; event.stopPropagation();\">
                                     <span class=\"glyphicon glyphicon-trash\"></span>
                                 </span>
                             </div>
                        </span>
                    </a>";
        }
    }