<?php
    namespace helper;

    final class Env
    {
        public static final function getActualDatabase()
        {
            self::startSessionIfNotStarted();

            return $_SESSION["db_name"];
        }

        public static final function setActualDatabase($db_name)
        {
            self::startSessionIfNotStarted();
            
            if(isset($_SESSION["db_name"]))
            {
                unset($_SESSION["db_name"]);
            }

            $_SESSION["db_name"] = $db_name;
        }

        public static final function clearActualDatabase()
        {
            self::startSessionIfNotStarted();

            unset($_SESSION["db_name"]);
        }

        private static final function startSessionIfNotStarted()
        {
            if(session_status() != PHP_SESSION_ACTIVE)
            {
                session_start();
            }
        }
    }
?>