<?php
    namespace helper;

    require_once "../load.php";

    use \api\Autoload;

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
         * Determines if a Database Deletion will be softned or not.
         * 
         * @var bool
         */
        private const SAFE_DELETE = true;

        /**
         * Get on the Env Session the actual Database name.
         *
         * @return string|null The current Database name or simple null.
         * @static
         * @final
         */
        final public static function getActualDatabase() : ?string
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
        final public static function setActualDatabase(string $db_name) : void
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
        final public static function clearActualDatabase() : void
        {
            self::startSessionIfNotStarted();

            unset($_SESSION["db_name"]);
        }

        /**
         * Getter of the Database Valid Names.
         *
         * @return string[] An array of the string with the valid names.
         * @static
         * @final
         */
        final public static function getDatabaseValidNames() : array
        {
            return self::VALID_NAMES;
        }

        /**
         * Getter for the Database Deletion type.
         *
         * @return boolean **TRUE** determines Safe Deletion and `FALSE` determines Force Deletion.
         * @static
         * @final
         */
        final public static function getDeletionType() : bool
        {
            return self::SAFE_DELETE;
        }

        /**
         * Checks if an Env Session is not started, to start it in this case.
         *
         * @return void
         * @static
         * @final
         */
        final private static function startSessionIfNotStarted() : void
        {
            if(session_status() != PHP_SESSION_ACTIVE)
            {
                session_start();
            }
        }
    }

    Autoload::unload(__FILE__);
?>