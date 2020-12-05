<?php
    namespace manager;

    require_once "../load.php";

    use PDO;

    use database\Connection;
    
    use helper\Env;
    use helper\Response;

final class DatabaseManager
    {
        private PDO $root;

        public function __construct()
        {
            $this->root = (new Connection(true))->conn;
        }

        public function createDatabase(string $name)
        {
            $builder = file_get_contents("../resources/{$name}.sql");
            
            $builder = $this->root->prepare($builder);

            $statement = $builder->execute();

            if($statement)
            {
                Env::setActualDatabase($name);
                
                return true;
            }

            return false;
        }
    }
?>