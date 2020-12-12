<?php
    namespace model;

    require_once "../load.php";

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
        }

        /**
         * A setter for the Address, determined by its ID.
         *
         * @param int $address_id The ID of the Foreign Address entry.
         * @return void
         */
        public function setAddress(int $address_id) : void
        {
            $this->address_id = $address_id;

            $this->address = new Address($this->address_id);
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
            return [
                "id"         => $this->id,
                "address"    => $this->address->asArray(),
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
?>