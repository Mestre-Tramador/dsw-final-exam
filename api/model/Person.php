<?php
    namespace model;

    require_once "../load.php";

    use \api\Autoload;
    
    use \controller\PersonController;

    class Person extends Model
    {
        /**
         * The \``address_id`\` field.
         * 
         * @var int|null $address_id
         */
        public ?int $address_id;
        
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
         * Used to relate to the Address.
         * 
         * @var Address|null $address
         */
        private ?Address $address;

        /**
         * The Person can be started with an ID or not.
         * Also an Address Foreing ID can be setted.
         *
         * @param int|null $id The Person ID, if exists.
         * @param int|null $address_id To already set an Address, then its ID must be passed along the Person's.
         * @return $this
         */
        public function __construct(?int $id = null, ?int $address_id = null)
        {
            parent::__construct($id);

            $this->address_id = $address_id;

            $this->address = new Address($this->address_id);

            if(isset($this->id))
            {
                $this->find();
            }
        }

        /**
         * A setter for the Address, determined by its ID or **NULL**.
         *
         * @param int $address_id The ID of the Foreign Address entry or **NULL** to remove.
         * @return void
         */
        public function setAddress(?int $address_id) : void
        {
            $this->address_id = $address_id;

            $this->address = new Address($this->address_id);
        }

        /**
         * Execute a Controller read funtion to set the Person (and Address, if) data.
         *
         * @return void
         */
        protected function find(): void
        {
            $controller = new PersonController();

            $model = $controller->read($this->id);

            $this->type = $model["type"];
            $this->name = $model["name"];
            $this->surname = $model["surname"];
            $this->gender = $model["gender"];
            $this->document = $model["document"];
            $this->phone = $model["phone"];
            $this->cellphone = $model["cellphone"];
            $this->birth_date = $model["birth_date"];
            $this->created_at = $model["created_at"];
            $this->updated_at = $model["updated_at"];
            $this->deleted_at = $model["deleted_at"];

            if(isset($model["address"]["id"]))
            {
                $this->setAddress($model["address"]["id"]);
            }
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
        public function asArray() : array
        {
            /**
             * The address representation.
             * 
             * @var null $address
             */
            $address = null;
            
            if(isset($this->address->id))
            {
                /**
                 * If there is an Address, then it gains its data.
                 * 
                 * @var array $address
                 */
                $address = $this->address->asArray();
            }

            return [
                "id"         => $this->id,
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
    }

    Autoload::unload(__FILE__);
?>