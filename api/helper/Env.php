<?php
    namespace helper;

    /**
     * Helper class with variables of ENV.
     * 
     * @final
     */
    final class Env
    {
        /**
         * The valid names for Databases.
         * 
         * @var string[]
         */
        private const VALID_NAMES = ["store", "loja"];

        /**
         * Get on the Env Session the actual Database name.
         *
         * @return string
         * @static
         * @final
         */
        public static final function getActualDatabase()
        {
            self::startSessionIfNotStarted();

            return @$_SESSION["db_name"];
        }

        /**
         * Set on the Env Session a Database name.
         *
         * @param string $db_name The name for the Database.
         * @return void
         * @static
         * @final
         */
        public static final function setActualDatabase(string $db_name)
        {
            self::startSessionIfNotStarted();
            
            if(isset($_SESSION["db_name"]))
            {
                unset($_SESSION["db_name"]);
            }

            $_SESSION["db_name"] = $db_name;
        }

        /**
         * Clear of the Env Session the Database name by unsetting it.
         *
         * @return void
         * @static
         * @final
         */
        public static final function clearActualDatabase()
        {
            self::startSessionIfNotStarted();

            unset($_SESSION["db_name"]);
        }

        /**
         * Getter of the Database Valid Names.
         *
         * @return string[]
         * @static
         * @final
         */
        public static final function getDatabaseValidNames()
        {
            return self::VALID_NAMES;
        }

        /**
         * Checks if an Env Session is not started, to start it in this case.
         *
         * @return void
         * @static
         * @final
         */
        private static final function startSessionIfNotStarted()
        {
            if(session_status() != PHP_SESSION_ACTIVE)
            {
                session_start();
            }
        }
    }
?>