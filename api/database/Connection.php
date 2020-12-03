<?php
    namespace database;

    require "../load.php";

    use PDO;
    use PDOException;
    
    use helper\Env;

    class Connection
    {
        private string $host = "localhost";
        private string $db_name = "";
        private string $username = "root";
        private string $passwd = "";

        public PDO $conn;

        public function __construct()
        {
            $this->db_name = Env::getActualDatabase();

            $this->conn = null;

            try
            {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name}";

                $this->conn = new PDO($dsn, $this->username, $this->passwd);
            }
            catch(PDOException $exception)
            {
                echo "Connection error: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>