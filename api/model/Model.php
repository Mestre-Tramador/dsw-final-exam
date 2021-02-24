<?php
    namespace model;
    
    require_once "../load.php";

    use \api\Autoload;

    /**
     * A Model of a Database table.
     * @abstract
     */
    abstract class Model
    {        
        /**
         * When creating a Model from the Database, its ID are required.
         *
         * @param int|null $id The ID of the Model.
         * @return void
         */
        public function __construct(
            public ?int $id = null
        )
        { }

        /**
         * Find and set the data of the model.
         *
         * @return void
         */
        abstract protected function find() : void;
        
        /**
         * Return all the data of the Model as an Array.
         *
         * @return array The array is associative.
         * @abstract
         */
        abstract public function asArray() : array;
    }
    
    Autoload::unload(__FILE__);
?>