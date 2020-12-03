<?php
    namespace model;

    use PDO;

    use database\Connection;

    abstract class Model
    {
        private PDO $conn;
        private string $table_name;

        protected function __construct(string $table_name)
        {
            $this->conn = new Connection();

            $this->table_name = $table_name;
        }

        abstract static function asArray();
    }
    
?>