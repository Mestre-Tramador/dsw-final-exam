<?php
    namespace model;

    require_once "../load.php";

    use \api\Autoload;
    
    use \controller\PersonController;

    /**
     * The Model representantion of the \``person`\` table.
     * 
     * @final
     */
    final class Person extends Model
    {        
        /**
         * The \``type`\` field.
         * 
         * @var string $type
         */
        public string $type;
        
        /**
         * The \``name`\` field.
         * 
         * @var string $name
         */
        public string $name;
        
        /**
         * The \``surname`\` field.
         * 
         * @var string $surname
         */
        public string $surname;
        
        /**
         * The \``gender`\` field.
         * 
         * @var string $gender
         */
        public string $gender;
        
        /**
         * The \``document`\` field.
         * 
         * @var string $document
         */
        public string $document;
        
        /**
         * The \``phone`\` field.
         * 
         * @var string|null $phone
         */
        public ?string $phone;
        
        /**
         * The \``cellphone`\` field.
         * 
         * @var string|null $cellphone
         */
        public ?string $cellphone;
        
        /**
         * The \``birth_date`\` field.
         * 
         * @var string $birth_date
         */
        public string $birth_date;
        
        /**
         * The \``created_at`\` field.
         * 
         * @var string $created_at
         */
        public string $created_at;
        
        /**
         * The \``updated_at`\` field.
         * 
         * @var string $updated_at
         */
        public string $updated_at;
        
        /**
         * The \``deleted_at`\` field.
         * 
         * @var string|null $deleted_at
         */
        public ?string $deleted_at;

        /**
         * The Address.
         * 
         * @var Address|null $address
         */
        public ?Address $address;

        /**
         * The Person can be started with an ID or not.
         * Also an Address Foreing ID can be setted.
         *
         * @param int|null $id The Person ID.
         * @param int|null $address_id The Persons's Address ID.
         * @return void
         */
        private function __construct(?int $id = null,
            private ?int $address_id = null
        )
        {
            parent::__construct($id);
            
            if($this->haveAddress())
            {
                $this->address = Address::find($this->address_id);
            }
        }   
        
        /**
         * Instantiate a new Person.
         *
         * @return \model\Person
         */
        final public static function instantiate(): Person
        {
            return new Person();
        }

        /**
         * Find a Person by its ID.
         *
         * @param int $id A Person ID.
         * @return \model\Person
         */
        final public static function find(int $id): Person
        {
            $person = new Person($id);
            
            $model = PersonController::read($id);

            if(isset($model["address"]["id"]))
            {
                $person->joinAddress($model["address"]["id"]);
            }

            $person->type       = $model["type"];
            $person->name       = $model["name"];
            $person->surname    = $model["surname"];
            $person->gender     = $model["gender"];
            $person->document   = $model["document"];
            $person->phone      = $model["phone"];
            $person->cellphone  = $model["cellphone"];
            $person->birth_date = $model["birth_date"];
            $person->created_at = $model["created_at"];
            $person->updated_at = $model["updated_at"];
            $person->deleted_at = $model["deleted_at"];

            return $person;
        }
        
        /**
         * Get the current object as an array with the following keys:
         * * id
         * * address
         * * type
         * * name
         * * surname
         * * gender
         * * document
         * * phone
         * * cellphone
         * * birth_date
         *
         * @return array The returned array is associative.
         */
        final public function asArray() : array
        {
            /**
             * The address representation.
             * 
             * @var null $address
             */
            $address = null;
            
            if($this->haveAddress())
            {
                /**
                 * If there is an Address, then it gains its data.
                 * 
                 * @var array $address
                 */
                $address = $this->address->asArray();
            }

            return [
                "id"         => $this->id(),
                "address"    => $address,
                "type"       => $this->type,
                "name"       => $this->name,
                "surname"    => $this->surname,
                "gender"     => $this->gender,
                "document"   => $this->document,
                "phone"      => $this->phone,
                "cellphone"  => $this->cellphone,
                "birth_date" => $this->birth_date
            ];
        }

        /**
         * Verify the presence of an Address.
         *
         * @return boolean `TRUE` if present.
         */
        public function haveAddress() : bool
        {
            return isset($this->address_id);
        }

        /**
         * Join a Address to a User.
         *
         * @param int $address_id The ID of the Foreign Address entry.
         * @return \model\Person
         */
        public function joinAddress(int $address_id) : Person
        {
            $this->address_id = $address_id;

            $this->address = Address::find($address_id);

            return $this;
        }
    }

    Autoload::unload(__FILE__);
?>