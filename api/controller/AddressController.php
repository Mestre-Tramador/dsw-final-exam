<?php
    namespace controller;

    require_once "../load.php";

    use \PDO;
    
    use \api\Autoload;

    use \database\Connection;

    use \model\Model;

    /**
     * This Controller handle the \``address`\` table.
     * 
     * @final
     */
    class AddressController extends Controller
    {
        /**
         * Only the Controller can instantiate itself.
         * 
         * @return void
         */
        private function __construct()
        {
            parent::__construct(Connection::new(), "address");
        }

        /**
         * Create the Address with all passed data.
         * 
         * If is setted and ID on the model, then it's updated.
         * 
         * @param \model\Address $model The Address Model with setted data.
         * @return array The array returned contains a **result** `boolean` key with the query result,
         * and another **model** `array` key with the created model as an array.
         */
        public static function create(Model $model) : array
        {
            if(self::containsData($model))
            {
                return self::update($model->id(), $model);
            }

            /**
             * Intern controller to execute functions.
             * 
             * @var \controller\AddressController $controller
             */
            $controller = new AddressController();
            
            /**
             * Insert query.
             * 
             * @var string $q
             */
            $q = "INSERT INTO `{$controller->table()}`(
                `zip_code`,
                `street`,
                `number`,
                `complement`,
                `reference`,
                `district`,
                `city`,
                `state`,
                `created_at`,
                `updated_at`
            )
            VALUES(
                :zip_code,
                :street,
                :number,
                :complement,
                :reference,
                :district,
                :city,
                :state,
                NOW(),
                NOW()
            )";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $controller->connection()->prepare($q);

            $stmt->bindValue(":zip_code",   self::convertField($model->zip_code));
            $stmt->bindValue(":street",     self::convertField($model->street));
            $stmt->bindValue(":number",     self::convertField($model->number));
            $stmt->bindValue(":complement", self::convertField($model->complement));
            $stmt->bindValue(":reference",  self::convertField($model->reference));
            $stmt->bindValue(":district",   self::convertField($model->district));
            $stmt->bindValue(":city",       self::convertField($model->city));
            $stmt->bindValue(":state",      self::convertField($model->state));

            /**
             * The result of the query execution.
             * 
             * @var bool $result
             */
            $result = $stmt->execute();

            $model->newId((int) $controller->connection()->lastInsertId());

            /**
             * Final array for return.
             * 
             * Keys:
             * * **result** `bool` - The query result.
             * * **model** `array` - The same model as array.
             * 
             * @var array $response
             */
            $response = [
                "result" => $result,
                "model"  => $model->asArray()
            ];

            return $response;
        }

        /**
         * Get all valid Addresses on the Database.
         *
         * @param int|null $id Pass an ID to return the indexed Address.
         * @return array The list of the retrivied models as arrays.
         */        
        public static function read(?int $id = null) : array
        {
            if(isset($id))
            {
                return self::readById($id);
            }

            /**
             * Intern controller to execute functions.
             * 
             * @var \controller\AddressController $controller
             */
            $controller = new AddressController();

            /**
             * Select query.
             * 
             * @var string $q
             */
            $q = "SELECT
                *
            FROM
                `{$controller->table()}`
            WHERE
                `deleted_at` IS NULL
            ";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $controller->connection()->prepare($q);
            
            $stmt->execute();

            /**
             * The fetched associative array list of Addresses.
             * 
             * @var array $fetch
             */
            $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $fetch;
        }

        /**
         * Retrieve a specific Address by its ID.
         *
         * @param int $id The Address ID.
         * @return array The Address as a Model Array.
         */
        protected static function readById(int $id): array
        {
            /**
             * Intern controller to execute functions.
             * 
             * @var \controller\AddressController $controller
             */
            $controller = new AddressController();

            /**
             * Select query.
             * 
             * @var string $q
             */
            $q = "SELECT
                *
            FROM
                `{$controller->table()}`
            WHERE
                `deleted_at` IS NULL AND `id` = :id
            ";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $controller->connection()->prepare($q);

            $stmt->bindValue(":id", $id);
            
            $stmt->execute();

            /**
             * The fetched associative array of the Address.
             * 
             * @var array $fetch
             */
            $fetch = $stmt->fetch(PDO::FETCH_ASSOC);

            return $fetch;
        }

        /**
         * Updates all the fields of the Address.
         *
         * @param int $id The ID of the Address to Update.
         * @param \model\Address $model The Address Model with the data to Update
         * @return array The returned array is the same as the Model, already updated.
         */
        public static function update(int $id, object $model) : array
        {
            /**
             * Intern controller to execute functions.
             * 
             * @var \controller\AddressController $controller
             */
            $controller = new AddressController();

            /**
             * Update query.
             * 
             * @var string $q
             */    
            $q = "UPDATE
                `{$controller->table()}`
            SET             
                `zip_code` = :zip_code,   
                `street` = :street,
                `number` = :number,
                `complement` = :complement,
                `reference` = :reference,
                `district` = :district,
                `city` = :city,
                `state` = :state,
                `updated_at` = NOW()
            WHERE
                `id` = :id
            ";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $controller->connection()->prepare($q);

            $stmt->bindValue(":id", $id);

            $stmt->bindValue(":zip_code",   self::convertField($model->zip_code));
            $stmt->bindValue(":street",     self::convertField($model->street));
            $stmt->bindValue(":number",     self::convertField($model->number));
            $stmt->bindValue(":complement", self::convertField($model->complement));
            $stmt->bindValue(":reference",  self::convertField($model->reference));
            $stmt->bindValue(":district",   self::convertField($model->district));
            $stmt->bindValue(":city",       self::convertField($model->city));
            $stmt->bindValue(":state",      self::convertField($model->state));

            $stmt->execute();

            return $model->asArray();
        }

        /**
         * Set the deletion date of the Address indexed.
         * 
         * If the Safe Deletion mode is disabled, then the
         * entry is fully removed from the Database.
         *
         * @param int $id The ID of the Address to delete.
         * @return bool The result of the deletion.
         */
        public static function delete(int $id) : bool
        {
            /**
             * Intern controller to execute functions.
             * 
             * @var \controller\AddressController $controller
             */
            $controller = new AddressController();

            /**
             * Update (as Delete) query.
             * 
             * @var string $q
             */
            $q = "UPDATE
                `{$controller->table()}`
            SET
                `deleted_at` = NOW()
            WHERE
                `id` = :id
            ";
            
            if(!self::isSafeDeletion())
            {
                /**
                 * Delete query.
                 * 
                 * @var string $q
                 */
                $q = "DELETE
                FROM
                    `{$controller->table()}`
                WHERE
                    `id` = :id
                ";
            }

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $controller->connection()->prepare($q);

            $stmt->bindValue(":id", $id);

            return $stmt->execute();
        }    
    }
    
    Autoload::unload(__FILE__);
?>