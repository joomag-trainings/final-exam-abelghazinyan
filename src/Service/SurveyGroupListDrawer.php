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
                echo "<h4 class='text-info' align='center'>Currently there are no surveys</h4>";
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
                echo "<h4 class='text-warning' align='center'>Currently there are no surveys</h4>";
            }
        }

        private static function drawActiveSurvey(SurveyModel $survey)
        {
            $link = "localhost/survey_generator/public/index.php/survey/{$survey->getHash()}";
            echo "<div class='list-group-item clearfix'>
                        <button data-toggle=\"modal\" data-target=\"#M-{$survey->getId()}\" class=\"btn btn-xs pull-right\"><span class=\"glyphicon glyphicon-link\"></span> GET URL</button>
                        <a href='/survey_generator/public/index.php/survey/{$survey->getHash()}'><h3 class='list-group-item-heading text-capitalize'><i>{$survey->getName()}</i></h3></a>
                        <small class='text-primary'>{$survey->getExpirationDate()}</small>
                        <blockquote class='text-justify text-muted'>{$survey->getSubject()}</blockquote>
                    </div>";
            echo "<div id=\"M-{$survey->getId()}\" class=\"modal fade\" role=\"dialog\">
                      <div class=\"modal-dialog\">
                        <!-- Modal content-->
                        <div class=\"modal-content\">
                          <div class=\"modal-header\">
                            <button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
                            <h4 class=\"modal-title\">{$survey->getName()}</h4>
                          </div>
                          <div class=\"modal-body\">
                            <textarea id=\"T-{$survey->getId()}\" class=\"form-control\" rows=\"1\" style=\"resize: none\" >{$link}</textarea>
                          </div>
                          <div class=\"modal-footer\">
                            <button id=\"B-{$survey->getId()}\" type=\"button\" class=\"btn btn-info copy\" data-dismiss=\"modal\">Copy To Clipboard</button>
                          </div>
                        </div>
                      </div>
                    </div>";
        }

        private static function drawInProgressSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-warning clearfix'>
                        <span class='pull-right'>  
                             <form method='post' class='pull-right' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'> 
                                    <button type='submit' class=\"btn btn-md btn-default\"><span class=\"glyphicon glyphicon-trash text-danger\"></span></button>
                             </form>                          
                        </span>
                        <h3 class='list-group-item-heading'><i>{$survey->getName()}</i></h3>
                        <small class=''>{$survey->getStartDate()} | {$survey->getExpirationDate()}</small>
                        <blockquote class='text-justify'>{$survey->getSubject()}</blockquote>                        
                        
                    </a>";
        }

        private static function drawNotStartedSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-info clearfix'>
                        <span class='pull-right'>  
                             <form method='post' class='pull-right' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'> 
                                    <button type='submit' class=\"btn btn-md btn-default\"><span class=\"glyphicon glyphicon-trash text-danger\"></span></button>
                             </form>                          
                        </span>
                        <h3 class='list-group-item-heading'><i>{$survey->getName()}</i></h3>
                        <small class=''>{$survey->getStartDate()} | {$survey->getExpirationDate()}</small>
                        <blockquote class='text-justify'>{$survey->getSubject()}</blockquote>                        
                        
                    </a>";
        }

        private static function drawStartedSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/pages?id={$survey->getId()}' class='list-group-item list-group-item-success clearfix'>
                        <span class='pull-right'>  
                             <form method='post' class='pull-right' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'> 
                                    <button type='submit' class=\"btn btn-md btn-default\"><span class=\"glyphicon glyphicon-trash text-danger\"></span></button>
                             </form> 
                             <form method='get' class='pull-right' action='/survey_generator/public/index.php/stats'>
                                    <input type='hidden' name='id' value='{$survey->getId()}'>
                                    <input type='hidden' name='pg' value='1'>
                                    <button class=\"btn btn-md btn-default\">
                                        <span class=\"glyphicon glyphicon-stats text-primary\"></span>
                                    </button> 
                             </form>                           
                        </span>
                        <h3 class='list-group-item-heading'><i>{$survey->getName()}</i></h3>
                        <small class=''>{$survey->getStartDate()} | {$survey->getExpirationDate()}</small>
                        <blockquote class='text-justify'>{$survey->getSubject()}</blockquote>                        
                        
                    </a>";
        }

        private static function drawExpiredSurvey(SurveyModel $survey)
        {
            echo "<a href='/survey_generator/public/index.php/stats?id={$survey->getId()}&pg=1' class='list-group-item list-group-item-danger clearfix'>
                        <span class='pull-right'>  
                             <form method='post' class='pull-right' action='/survey_generator/public/index.php/survey_delete?id={$survey->getId()}'> 
                                    <button type='submit' class=\"btn btn-md btn-default\"><span class=\"glyphicon glyphicon-trash text-danger\"></span></button>
                             </form> 
                             <form method='get' class='pull-right' action='/survey_generator/public/index.php/stats'>
                                    <input type='hidden' name='id' value='{$survey->getId()}'>
                                    <input type='hidden' name='pg' value='1'>
                                    <button class=\"btn btn-md btn-default\">
                                        <span class=\"glyphicon glyphicon-stats text-primary\"></span>
                                    </button> 
                             </form>                           
                        </span>
                        <h3 class='list-group-item-heading'><i>{$survey->getName()}</i></h3>
                        <small class=''>{$survey->getStartDate()} | {$survey->getExpirationDate()}</small>
                        <blockquote class='text-justify'>{$survey->getSubject()}</blockquote>                        
                        
                    </a>";
        }
    }