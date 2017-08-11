<?php

    namespace Service;


    use Model\PageModel;

    class PageGroupListDrawer
    {
        public static function drawGroupList($pg, $info)
        {
            $pages = PageManager::getInstance()->getPages($pg);
            if ( isset($pages) ) {
                foreach ($pages as $page) {
                    if ($page->getState() == '0') {
                        self::drawInProgressPage($page);
                    } else {
                        self::drawCreatedPage($page);
                    }
                }
            } elseif ($info) {
                echo "<h1>Currently there are no pages</h1>";
            }
        }

        private static function drawInProgressPage(PageModel $page)
        {
            echo "<a href='/survey_generator/public/index.php/page?id={$page->getId()}' class='list-group-item list-group-item-warning clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$page->getName()}</h4>
                        <span class='pull-right'>
                             <span class='btn btn-md btn-danger' onclick=\"location.href = ''; event.stopPropagation();\">
                                 <span class='glyphicon glyphicon-trash'></span>
                             </span>
                        </span>
                    </a>";
        }

        private static function drawCreatedPage(PageModel $page)
        {
            echo "<a href='/survey_generator/public/index.php/page?id={$page->getId()}' class='list-group-item list-group-item-success clearfix'>
                        <h4 class='list-group-item-heading pull-left'>{$page->getName()}</h4>
                        <span class='pull-right'>
                             <span class='btn btn-md btn-danger' onclick=\"location.href = ''; event.stopPropagation();\">
                                 <span class='glyphicon glyphicon-trash'></span>
                             </span>
                        </span>
                    </a>";
        }
    }