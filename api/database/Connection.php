<?php
    namespace database;

    require_once "../load.php";

    use PDO;
    use PDOException;
    
    use helper\Env;

    class Connection
    {
        private string $host = "localhost";
        private ?string $db_name = "";
        private string $username = "root";
        private string $passwd = "";

        public ?PDO $conn;
        public ?PDOException $err;

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