<?php
    namespace manager;

    require_once "../load.php";

    use \PDO;
    
    use \api\Autoload; 

    use \database\Connection;
    
    use \helper\Env;

    /**
     * A Manager to handle Database functions.
     * 
     * @final
     */
    final class DatabaseManager
    {       
        /**
         * This is a Root Connection to execute heavy tasks.
         * 
         * @var PDO $root
         */
        private PDO $root;

        /**
         * The manager can only create itself, and also with Root privileges.
         * 
         * @return void
         */
        private function __construct()
        {
            $this->root = Connection::new(true);
        }

        /**
         * With the given name, search on the resources and create a Database.
         * Also set on the ENV.
         *
         * @param string $name The Database name.
         * @return bool The result of the creation
         * @static
         */
        public static function createDatabase(string $name) : bool
        {
            /**
             * Intern manager to execute functions.
             * 
             * @var \manager\DatabaseManager $manager
             */
            $manager = new DatabaseManager();

            /**
             * The big query for the Database.
             * 
             * @var string $builder
             */
            $builder = file_get_contents("../resources/{$name}.sql");
            
            /**
             * The query preparated.
             * 
             * @var \PDOStatement $builder
             */
            $builder = $manager->root->prepare($builder);

            /**
             * The statemente result.
             * 
             * @var bool $statement
             */
            $statement = $builder->execute();

            if($statement)
            {
                Env::setActualDatabase($name);
            }

            return $statement;
        }

        /**
         * Get the Database on the ENV and delete it.
         *
         * @return bool The result of the exclusion.
         * @static
         */
        public static function destroyDatabase() : bool
        {
            /**
             * Intern manager to execute functions.
             * 
             * @var \manager\DatabaseManager $manager
             */
            $manager = new DatabaseManager();

            /**
             * The Database name.
             * 
             * @var string
             */
            $db_name = Env::getActualDatabase();

            /**
             * The big query for the Database.
             * 
             * @var string $builder
             */
            $builder = "DROP DATABASE `{$db_name}`";

            /**
             * The query preparated.
             * 
             * @var \PDOStatement $builder
             */
            $builder = $manager->root->prepare($builder);

            return $builder->execute();
        }
    }

    Autoload::unload(__FILE__);
?>