<?php
    namespace controller;

    use PDO;

    use model\Model;

    abstract class Controller
    {
        private PDO $conn;
        private string $table_name;

        protected abstract static function create(Model $model);
        protected abstract static function read(?int $id = null);
        protected abstract static function update(int $id, Model $model);
        protected abstract static function delete(int $id);

        protected function __construct($conn, $table_name)
        {
            $this->conn = $conn;
            $this->table_name = $table_name;
        }
    }
?>