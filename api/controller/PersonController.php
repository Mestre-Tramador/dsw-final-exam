<?php
    namespace controller;

    require_once "../load.php";

    use \api\Autoload;

    use \database\Connection;

    /**
     * This Controller handle the \``person`\` table.
     */
    class PersonController extends Controller
    {
        /**
         * When creating this Controller, the necessary data is already setted.
         * 
         * @return $this
         */
        public function __construct()
        {
            parent::__construct((new Connection()), "person");
        }

        /**
         * When creating a Person, the only field that
         * is not filled is the Address ID, since there is
         * need to create an Address before a Person.
         *
         * @param \model\Person $model The Person model with setted data.
         * @return array The array returned contains a **result** `boolean` key with the query result,
         * and another **model** `array` key withe the created model as an array.
         */
        public function create(object $model) : array
        {         
            /**
             * Insert query.
             * 
             * @var string $q
             */   
            $q = "INSERT INTO `{$this->getTableName()}`(
                `type`,
                `name`,
                `surname`,
                `gender`,
                `document`,
                `phone`,
                `cellphone`,
                `birth_date`,
                `created_at`,
                `updated_at`
            )
            VALUES(
                :type,
                :name,
                :surname,
                :gender,
                :document,
                :phone,
                :cellphone,
                :birth_date,
                NOW(),
                NOW()
            )";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $this->getConnection()->prepare($q);

            $stmt->bindValue(":type", self::convertField($model->type));
            $stmt->bindValue(":name", self::convertField($model->name));
            $stmt->bindValue(":surname", self::convertField($model->surname));
            $stmt->bindValue(":gender", self::convertField($model->gender));
            $stmt->bindValue(":document", self::convertField($model->document));
            $stmt->bindValue(":phone", self::convertField($model->phone));
            $stmt->bindValue(":cellphone", self::convertField($model->cellphone));
            $stmt->bindValue(":birth_date", self::convertField($model->birth_date));
          
            /**
             * The result of the query execution.
             * 
             * @var bool $result
             */
            $result = $stmt->execute();

            $model->id = $this->getConnection()->lastInsertId();      
            
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

        public function read(?int $id = null) : array
        {
            return [];
        }

        /**
         * Updates all the fields of the Person, includind the Address ID.         
         *
         * @param int $id The ID of the Person to Update.
         * @param \model\Person $model The Person Model with the data to Update.
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
                `address_id` = :address_id,   
                `type` = :type,
                `name` = :name,
                `surname` = :surname,
                `gender` = :gender,
                `document` = :document,
                `phone` = :phone,
                `cellphone` = :cellphone,
                `birth_date` = :birth_date,
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

            $stmt->bindValue(":address_id", self::convertField($model->address_id));
            $stmt->bindValue(":type", self::convertField($model->type));
            $stmt->bindValue(":name", self::convertField($model->name));
            $stmt->bindValue(":surname", self::convertField($model->surname));
            $stmt->bindValue(":gender", self::convertField($model->gender));
            $stmt->bindValue(":document", self::convertField($model->document));
            $stmt->bindValue(":phone", self::convertField($model->phone));
            $stmt->bindValue(":cellphone", self::convertField($model->cellphone));
            $stmt->bindValue(":birth_date", self::convertField($model->birth_date));

            $stmt->execute();

            return $model->asArray();
        }

        /**
         * Set the deletion date of the Person indexed.
         * 
         * If the Safe Deletion mode is disabled, then the
         * entry is fully removed from the Database.
         *
         * @param int $id The ID of the Person to delete.
         * @return void
         */
        public function delete(int $id) : void
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

            $stmt->execute();
        }

        /**
         * Cascade Deletion to unset all deleted Addresses IDs in Persons.
         *
         * @param int $address_id The ID of the deleted Address.
         * @return void
         */
        public function deleteAddress(int $address_id) : void
        {
            /**
             * Update (as deletion) query to set the Addresses IDs to `NULL`.
             * 
             * @var string $q
             */
            $q = "UPDATE
                `{$this->getTableName()}`
            SET
                `address_id` = NULL
            WHERE
                `address_id` = :id
            ";

            /**
             * Statement to prepare and bind the values.
             * 
             * @var \PDOStatement $stmt
             */
            $stmt = $this->getConnection()->prepare($q);

            $stmt->bindValue(":id", $address_id);

            $stmt->execute();
        }
    }

    Autoload::unload(__FILE__);
?>