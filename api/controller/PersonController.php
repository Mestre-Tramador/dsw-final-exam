<?php
    namespace controller;

    require_once "../load.php";

    use \PDO;

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
         * @return void
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
         * If is setted and ID on the model, then it's updated.
         * 
         * @param \model\Person $model The Person model with setted data.
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

        /**
         * Get all valid Persons on the Database.
         *
         * @param int|null $id Pass an ID to return the indexed Person.
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
                `{$this->getTableName()}` AS `p`
            LEFT JOIN `address` AS `a`
            ON
                `a`.`id` = `p`.`address_id`
            WHERE
                `p`.`deleted_at` IS NULL
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
            $fetch = $this->handleReadResult($stmt->fetchAll(PDO::FETCH_NAMED));

            return $fetch;
        }

        /**
         * Retrieve a specific Person by its ID.
         *
         * @param int $id The Person ID.
         * @return array The Person as a Model Array.
         */
        protected function readById(int $id) : array
        {
            /**
             * Select query.
             * 
             * @var string $q
             */
            $q = "SELECT
                *
            FROM
                `{$this->getTableName()}` AS `p`
            LEFT JOIN `address` AS `a`
            ON
                `a`.`id` = `p`.`address_id`
            WHERE
                `p`.`deleted_at` IS NULL AND `p`.`id` = :id
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
            $fetch = $this->formatFetchResult($stmt->fetch(PDO::FETCH_NAMED));

            return $fetch;
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

        /**
         * Format the readed result list to a better array.
         *
         * @param array $result The array list with the retrievied models.
         * @return array Still an array but with better key value pairs.
         */
        private function handleReadResult(array $result) : array
        {
            for($i = 0; $i < count($result); $i++)
            {                 
                $result[$i] = $this->formatFetchResult($result[$i]);
            }
    
            return $result;
        }

        /**
         * Format a readed result to a better array.
         *
         * @param array $result The array fetched with the retrievied model.
         * @return array Still an array but with better key value pairs.
         */
        private function formatFetchResult(array $result) : array
        {
            // ? Create a new subarray to hold the address data.
            $result["address"] = [];

            // ? Pass every address data to this new array.
            $result["address"]["id"]         = $result["id"][1];
            $result["address"]["zip_code"]   = $result["zip_code"];
            $result["address"]["street"]     = $result["street"];
            $result["address"]["number"]     = $result["number"];
            $result["address"]["complement"] = $result["complement"];
            $result["address"]["reference"]  = $result["reference"];
            $result["address"]["district"]   = $result["district"];
            $result["address"]["city"]       = $result["city"];
            $result["address"]["state"]      = $result["state"];
            $result["address"]["created_at"] = $result["created_at"][1];
            $result["address"]["updated_at"] = $result["updated_at"][1];
            $result["address"]["deleted_at"] = $result["deleted_at"][1];

            // ? Clear address spare data.
            $result["id"]         = $result["id"][0];
            $result["created_at"] = $result["created_at"][0];
            $result["updated_at"] = $result["updated_at"][0];
            $result["deleted_at"] = $result["deleted_at"][0];

            // ? Unset now unused address key values.
            unset($result["address_id"]);
            unset($result["zip_code"]);
            unset($result["street"]);
            unset($result["number"]);
            unset($result["complement"]);
            unset($result["reference"]);
            unset($result["district"]);
            unset($result["city"]);
            unset($result["state"]);

            // ? Cast numeric address values.
            if(isset($result["address"]["id"]))
            {
                $result["address"]["id"]     = (int) $result["address"]["id"];
                $result["address"]["number"] = (int) $result["address"]["number"];
            }

            // ? Cast numeric person values.
            $result["id"] = (int) $result["id"];

            return $result;
        }
    }

    Autoload::unload(__FILE__);
?>