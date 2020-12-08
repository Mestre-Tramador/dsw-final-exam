<?php
    namespace database;

    require_once "../load.php";

    use PDO;
    use PDOException;
    
    use helper\Env;

    /**
     * This class represents an Connection with the Database.
     */
    class Connection
    {
        /**
         * The Database Host.
         * 
         * @var string $host
         */
        private string $host = "localhost";

        /**
         * The Database Name, nullable to access the root privileges.
         * 
         * @var string|null $db_name
         */
        private ?string $db_name = null;

        /**
         * The username of the Database server.
         * 
         * @var string $username
         */
        private string $username = "root";
        
        /**
         * The password of the Database server.
         * 
         * @var string $passwd
         */
        private string $passwd = "";

        /**
         * The Connection PDO object.
         * * It can be null if occur an Exception.
         * 
         * @var PDO|null $conn
         */
        public ?PDO $conn;

        /**
         * The Exception of a fail Connection.
         * * It is null when the Connection is successfull.
         * 
         * @var PDOException|null $err
         */
        public ?PDOException $err;

        /**
         * When instanciated, the class try to connect with the Database Server.
         *
         * @param boolean $root **TRUE** to access with root privileges.
         * @param string $db_name It can be used a custom name for the Database.
         * @return $this
         */
        public function __construct(bool $root = false, string $db_name = "")
        {
            $this->conn = null;
            $this->err = null;

            try
            {
                $dsn = "mysql:host={$this->host}";

                if(!$root)
                {
                    $this->db_name = Env::getActualDatabase();

                    if((!isset($this->db_name) || empty($this->db_name)) || !empty($db_name))
                    {
                        $this->db_name = $db_name;
                    }
                    
                    $dsn .= ";dbname={$this->db_name}";
                }

                $this->conn = new PDO($dsn, $this->username, $this->passwd);
            }
            catch(PDOException $exception)
            {
                $this->err = $exception;
            }
        }
    }
?>