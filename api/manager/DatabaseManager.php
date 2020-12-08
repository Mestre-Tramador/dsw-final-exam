<?php
    namespace manager;

    require_once "../load.php";

    use PDO;

    use database\Connection;
    
    use helper\Env;

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
         * The manager at the beginning create the Connection with root privileges.
         * 
         * @return $this
         */
        public function __construct()
        {
            $this->root = (new Connection(true))->conn;
        }

        /**
         * With the given name, search on the resources and create a Database.
         * Also set on the ENV.
         *
         * @param string $name The Database name.
         * @return bool The result of the creation
         */
        public function createDatabase(string $name)
        {
            $builder = file_get_contents("../resources/{$name}.sql");
            
            $builder = $this->root->prepare($builder);

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
         */
        public function destroyDatabase()
        {
            $db_name = Env::getActualDatabase();

            $builder = "DROP DATABASE `{$db_name}`";

            $builder = $this->root->prepare($builder);

            return $builder->execute();
        }
    }
?>