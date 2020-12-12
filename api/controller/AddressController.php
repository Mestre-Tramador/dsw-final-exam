<?php
    namespace controller;

    require_once "../load.php";
    
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
         * @param \model\Address $model The Address Model with setted data.
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

                
        public function read(?int $id = null) : array
        {
            return [];
        }

        public function update(int $id, object $model) : array
        {
            return $model->asArray();
        }

        /**
         * Set the deletion date of the Address indexed.
         * 
         * If the Safe Deletion mode is disabled, then the
         * entry is fully removed from the Database.
         *
         * @param int $id The ID of the Address to delete.
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

            $this->cascadeDeleteWithPersons($id);

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
         * Execute an Cascade Deletion with the \``person`\` table.
         *
         * @param int $id The deleted Address ID.
         * @return void
         * @final
         */
        final private function cascadeDeleteWithPersons(int $id) : void
        {
            /**
             * A controller for Persons.
             * 
             * @var \controller\PersonController $person
             */
            $person = new PersonController();

            $person->deleteAddress($id);

            unset($person);
        }
    }
    
    Autoload::unload(__FILE__);
?>