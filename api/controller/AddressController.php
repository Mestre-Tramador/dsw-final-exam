<?php
    namespace controller;

    require_once "../load.php";

    use \PDO;
    
    use \api\Autoload;

    use \database\Connection;

    /**
     * This Controller handle the \``address`\` table.
     */
    class AddressController extends Controller
    {
        /**
         * When creating this Controller, the necessary data is already setted.
         * 
         * @return $this
         */
        public function __construct()
        {
            parent::__construct((new Connection()), "address");
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
        public function create(object $model) : array
        {
            if(isset($model->id))
            {
                return $this->update($model->id, $model);
            }
            
            /**
             * Insert query.
             * 
             * @var string $q
             */
            $q = "INSERT INTO `{$this->getTableName()}`(
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
            $stmt = $this->getConnection()->prepare($q);

            $stmt->bindValue(":zip_code", self::convertField($model->zip_code));
            $stmt->bindValue(":street", self::convertField($model->street));
            $stmt->bindValue(":number", self::convertField($model->number));
            $stmt->bindValue(":complement", self::convertField($model->complement));
            $stmt->bindValue(":reference", self::convertField($model->reference));
            $stmt->bindValue(":district", self::convertField($model->district));
            $stmt->bindValue(":city", self::convertField($model->city));
            $stmt->bindValue(":state", self::convertField($model->state));

            /**
             * The result of the query execution.
             * 
             * @var bool $result
             */
            $result = $stmt->execute();

            $model->id = (int) $this->getConnection()->lastInsertId();      

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
        public function read(?int $id = null) : array
        {
            if(isset($id))
            {
                return $this->readById($id);
            }

            /**
             * Select query.
             * 
             * @var string $q
             */
            $q = "SELECT
                *
            FROM
                `{$this->getTableName()}`
            WHERE
                `deleted_at` IS NULL
            ";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $this->getConnection()->prepare($q);
            
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
        protected function readById(int $id): array
        {
            /**
             * Select query.
             * 
             * @var string $q
             */
            $q = "SELECT
                *
            FROM
                `{$this->getTableName()}`
            WHERE
                `deleted_at` IS NULL AND `id` = :id
            ";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $this->getConnection()->prepare($q);

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
        public function update(int $id, object $model) : array
        {
            /**
             * Update query.
             * 
             * @var string $q
             */    
            $q = "UPDATE
                `{$this->getTableName()}`
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
            $stmt = $this->getConnection()->prepare($q);

            $stmt->bindValue(":id", $id);

            $stmt->bindValue(":zip_code", self::convertField($model->zip_code));
            $stmt->bindValue(":street", self::convertField($model->street));
            $stmt->bindValue(":number", self::convertField($model->number));
            $stmt->bindValue(":complement", self::convertField($model->complement));
            $stmt->bindValue(":reference", self::convertField($model->reference));
            $stmt->bindValue(":district", self::convertField($model->district));
            $stmt->bindValue(":city", self::convertField($model->city));
            $stmt->bindValue(":state", self::convertField($model->state));

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
        public function delete(int $id) : bool
        {
            /**
             * Update (as Delete) query.
             * 
             * @var string $q
             */
            $q = "UPDATE
                `{$this->getTableName()}`
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
                    `{$this->getTableName()}`
                WHERE
                    `id` = :id
                ";
            }

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $this->getConnection()->prepare($q);

            $stmt->bindValue(":id", $id);

            return $stmt->execute();
        }    
    }
    
    Autoload::unload(__FILE__);
?>