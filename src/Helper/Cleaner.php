<?php

    namespace Helper;

    class Cleaner
    {
        static public function clean($data)
        {
            if (!isset($data)) {
                return null;
            } else {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        }
    }