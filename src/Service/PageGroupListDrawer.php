<?php

    namespace Service;

    use Model\PageModel;

    class PageGroupListDrawer
    {
        public static function drawGroupList($id, $info)
        {
            $pages = PageManager::getInstance()->getPages($id);
            if ( isset($pages) ) {
                $position = 1;
                foreach ($pages as $page) {
                    if ($page->getState() == '0') {
                        self::drawInProgressPage($page, $position);
                    } else {
                        self::drawCreatedPage($page, $position);
                    }
                    $position ++;
                }
            } elseif ($info) {
                echo "<h4 class='text-info' align='center'>Currently there are no pages</h4>";
            }
        }

        private static function drawInProgressPage(PageModel $page, $position)
        {
            echo "<a href='/survey_generator/public/index.php/page?id={$page->getId()}' 
                     class='list-group-item list-group-item-warning clearfix' id='{$page->getId()}'>
                        <h4 class='list-group-item-heading pull-left'>{$position}) {$page->getName()}</h4>
                        <span class='pull-right'>
                              <form method='post' class='pull-right form-control-static' 
                                    action='/survey_generator/public/index.php/page_delete?id={$page->getId()}&survey_id={$page->getSurveyId()}'>
                                 <button type='submit' class=\"btn btn-md btn-default\">
                                    <span class=\"glyphicon glyphicon-trash text-danger\"></span>
                                 </button>
                             </form>
                        </span>
                    </a>";
        }

        private static function drawCreatedPage(PageModel $page, $position)
        {
            echo "<a href='/survey_generator/public/index.php/page?id={$page->getId()}' 
                     class='list-group-item list-group-item-success clearfix' id='{$page->getId()}'>
                        <h4 class='list-group-item-heading pull-left'>{$position}) {$page->getName()}</h4>
                        <span class='pull-right'>
                             <form method='post' class='pull-right form-control-static' 
                                   action='/survey_generator/public/index.php/page_delete?id={$page->getId()}&survey_id={$page->getSurveyId()}'>
                                 <button type='submit' class=\"btn btn-md btn-default\">
                                    <span class=\"glyphicon glyphicon-trash text-danger\"></span>
                                 </button>
                             </form>
                        </span>
                    </a>";
        }
    }