<?php
    namespace model;

    use PDO;

    use database\Connection;

    /**
     * A Model of a Database table.
     * @abstract
     */
    abstract class Model
    {
        /**
         * Return all the data of the Model as an Array.
         *
         * @return array
         */
        abstract static function asArray();
    }
    
?>