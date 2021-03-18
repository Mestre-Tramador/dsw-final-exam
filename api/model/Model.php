<?php
    namespace model;
    
    require_once "../load.php";

    use \Exception;

    use \api\Autoload;

    /**
     * A Model of a Database table.
     * 
     * @abstract
     */
    abstract class Model
    {        
        /**
         * Pure models cannot be created.
         *
         * @return void
         */
        protected function __construct(
            private ?int $id = null
        )
        { }              

        /**
         * Find and set the data of the model.
         *
         * @return Model
         */
        abstract public static function find(int $id) : Model;

        /**
         * Instantiate a new model.
         *
         * @return Model
         */
        abstract public static function instantiate() : Model;

        /**
         * Return all the data of the Model as an Array.
         *
         * @return array The array is associative.
         * @abstract
         */
        abstract public function asArray() : array;

        /**
         * Get the current ID of the model.
         *
         * @return int
         */
        final public function id() : ?int
        {
            return $this->id;
        }
        
        /**
         * Set a new ID to the model.
         *
         * @param int $id The new ID.
         * @return void
         */
        final public function newId(int $id) : void
        {
            if(!isset($this->id))
            {
                $this->id = $id;

                return;
            }

            throw new Exception("Defining already existing ID!", 401);            
        }
    }
    
    Autoload::unload(__FILE__);
?>