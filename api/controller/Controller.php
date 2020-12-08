<?php
    namespace controller;

    require_once "../load.php";

    use PDO;
    
    use api\Autoload;
    
    use model\Model;

    /**
     * Controllers to handle the Database tables.
     * 
     * @abstract
     */
    abstract class Controller
    {
        /**
         * A connection with the Database.
         * 
         * @var PDO $conn
         */
        private PDO $conn;

        /**
         * The table name wich will be used.
         * 
         * @var string $table_name
         */
        private string $table_name;

        /**
         * When creating a Controller, there is need to pass
         * a valid Connection and the table name.
         *
         * @param PDO $conn The Connection already setted.
         * @param string $table_name The exact name.
         * @return $this
         */
        protected function __construct(PDO $conn, string $table_name)
        {
            $this->conn = $conn;
            $this->table_name = $table_name;
        }

        /**
         * Create a register of the Model on the Database.
         *
         * @param Model $model The Model of this Controller.
         * @return void
         * @abstract
         * @static
         */
        protected abstract static function create(Model $model);

        /**
         * Get all registers of the Model on the Database, of simply of the given ID.
         *
         * @param integer|null $id An ID of the Model.
         * @return void
         * @abstract
         * @static
         */
        protected abstract static function read(?int $id = null);
        
        /**
         * Update an specific register of the Model on the Database.
         *
         * @param integer $id An ID of the Model.
         * @param Model $model The same Model with all the spare data.
         * @return void
         * @abstract
         * @static
         */
        protected abstract static function update(int $id, Model $model);
        
        /**
         * Delete an specific register of the Model on the Database.
         *
         * @param integer $id An ID of the Model.
         * @return void
         * @abstract
         * @static
         */
        protected abstract static function delete(int $id);
    }

    Autoload::unload(__FILE__);
?>