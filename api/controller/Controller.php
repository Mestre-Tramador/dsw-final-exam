<?php
    namespace controller;

    require_once "../load.php";

    use \PDO;
    
    use \api\Autoload;

    use \database\Connection;

    use \helper\Env;

    /**
     * Controllers to handle the Database tables.
     * 
     * @abstract
     */
    abstract class Controller
    {
        /**
         * When creating a Controller, there is need to pass
         * a valid Connection and the table name.
         *
         * @param \database\Connection $conn A connection with the Database.
         * @param string $table_name The table name wich will be used.
         * @return void
         */
        protected function __construct(
            private Connection $conn,
            private string $table_name
        )
        { }        

        /**
         * Create a register of the Model on the Database.
         *
         * @param object $model The Model of this Controller.
         * @return array The created Model.
         * @abstract
         */
        abstract protected function create(object $model) : array;

        /**
         * Get all registers of the Model on the Database, of simply of the given ID.
         *
         * @param int|null $id An ID of the Model.
         * @return array The list of Models, or the indexed one.
         * @abstract
         */
        abstract protected function read(?int $id = null) : array;

        /**
         * Get the indexed registry of the Model on the Database.
         *
         * @param int $id An ID of the Model.
         * @return array The indexed Model.
         * @abstract
         */
        abstract protected function readById(int $id) : array;
        
        /**
         * Update an specific register of the Model on the Database.
         *
         * @param int $id An ID of the Model.
         * @param object $model The same Model with all the spare data.
         * @return array The updated Model. 
         * @abstract
         */
        abstract protected function update(int $id, object $model) : array;
        
        /**
         * Delete an specific register of the Model on the Database.
         *
         * @param int $id An ID of the Model.
         * @return bool The result.
         * @abstract
         */
        abstract protected function delete(int $id) : bool;

        /**
         * Convert null or empty fields to a `NULL` string for querys.
         *
         * @param string|null $field The field of the Model
         * @return string|null The field itself or **NULL**.
         * @static
         * @final
         */
        protected static final function convertField(?string $field) : ?string
        {
            if(!isset($field) || empty($field) || strtolower($field) == "null")
            {
                return null;
            }

            return $field;
        }

        /**
         * Get from the ENV if the Database Deletion type is Safe.
         *
         * @return bool **TRUE** for Safe and **FALSE** for Force.
         * @static
         * @final
         */        
        final protected static function isSafeDeletion() : bool
        {
            return Env::getDeletionType();
        }

        /**
         * Enable the Database Connection errors throwing.
         *
         * @return void
         */
        protected function enableConnectionErrors() : void
        {
            $this->getConnection()->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION); 
        }

        /**
         * Return the stablished Controller Database Connection.
         *
         * @return \PDO The Connection PDO object.
         */
        protected function getConnection() : \PDO
        {
            return $this->conn->getConnection();
        }

        /**
         * Return the Controller table name.
         *
         * @return string The specific table name.
         */
        protected function getTableName() : string
        {
            return $this->table_name;
        }        
    }

    Autoload::unload(__FILE__);
?>