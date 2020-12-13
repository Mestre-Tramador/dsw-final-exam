<?php
    namespace model;

    /**
     * A Model of a Database table.
     * @abstract
     */
    abstract class Model
    {
        /**
         * The ID of the Model.
         * 
         * @var int|null $id
         */
        public ?int $id;

        /**
         * When creating a Model from the Database, its ID are required.
         *
         * @param int|null $id If passed, then the required model ID is loaded.
         * @return $this
         */
        public function __construct(?int $id = null)
        {
            $this->id = $id;
        }

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
    
?>