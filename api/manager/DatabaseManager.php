<?php
    namespace manager;

    require_once "../load.php";

    use PDO;
    
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
         * @var \database\Connection $root
         */
        private Connection $root;

        /**
         * The manager at the beginning create the Connection with root privileges.
         * 
         * @return $this
         */
        public function __construct()
        {
            $this->root = new Connection(true);
        }

        /**
         * With the given name, search on the resources and create a Database.
         * Also set on the ENV.
         *
         * @param string $name The Database name.
         * @return bool The result of the creation
         */
        public function createDatabase(string $name) : bool
        {
            $builder = file_get_contents("../resources/{$name}.sql");
            
            $builder = $this->getRootConnection()->prepare($builder);

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
        public function destroyDatabase() : bool
        {
            $db_name = Env::getActualDatabase();

            $builder = "DROP DATABASE `{$db_name}`";

            $builder = $this->getRootConnection()->prepare($builder);

            return $builder->execute();
        }

        /**
         * Getter for the PDO Connection object.
         *
         * @return \PDO The Connection with root privileges.
         */
        final private function getRootConnection() : \PDO
        {
            return $this->root->conn;
        }
    }

    Autoload::unload(__FILE__);
?>