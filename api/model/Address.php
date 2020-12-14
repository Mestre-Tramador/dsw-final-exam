<?php
    namespace model;

    require_once "../load.php";

    use \controller\AddressController;

    /**
     * The Model representantion of the \``address`\` table.
     */
    class Address extends Model
    {
        /**
         * The \``zip_code`\` field.
         * 
         * @var string $zip_code
         */
        public string $zip_code;
        
        /**
         * The \``street`\` field.
         * 
         * @var string $street
         */
        public string $street;
        
        /**
         * The \``number`\` field.
         * 
         * @var int $number
         */
        public int $number;
        
        /**
         * The \``complement`\` field.
         * 
         * @var string|null $complement
         */
        public ?string $complement;
        
        /**
         * The \``reference`\` field.
         * 
         * @var string|null $reference
         */
        public ?string $reference;
        
        /**
         * The \``district`\` field.
         * 
         * @var string $district
         */
        public string $district;
        
        /**
         * The \``city`\` field.
         * 
         * @var string $city
         */
        public string $city;
        
        /**
         * The \``state`\` field.
         * 
         * @var string $state
         */
        public string $state;
        
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
         * The Address can be started with an ID or not.
         *
         * @param int|null $id If an ID is passed, then it's loaded.
         * @return $this
         */
        public function __construct(?int $id = null)
        {
            parent::__construct($id);

            if(isset($this->id))
            {
                $this->find();
            }
        }

        /**
         * Execute a Controller read action to set the Address data.
         *
         * @return void
         */
        protected function find(): void
        {
            /**
             * The controller for the operation.
             * 
             * @var \controller\AddressController $controller
             */
            $controller = new AddressController();

            /**
             * The readed model already fetch.
             * 
             * @var array $model
             */
            $model = $controller->read($this->id);

            $this->zip_code   = $model["zip_code"];
            $this->street     = $model["street"];
            $this->number     = (int) $model["number"];
            $this->complement = $model["complement"];
            $this->reference  = $model["reference"];
            $this->district   = $model["district"];
            $this->city       = $model["city"];
            $this->state      = $model["state"];
            $this->created_at = $model["created_at"];
            $this->updated_at = $model["updated_at"];
            $this->deleted_at = $model["deleted_at"];
        }

        /**
         * Get the current object as an array with the following keys:
         * * id
         * * zip_code
         * * street
         * * number 
         * * complement
         * * reference
         * * district
         * * city
         * * state
         *
         * @return array The returned array is associative.
         */
        public function asArray() : array
        {
            return [
                "id"         => $this->id,
                "zip_code"   => $this->zip_code,
                "street"     => $this->street,
                "number"     => $this->number,
                "complement" => $this->complement,
                "reference"  => $this->reference,
                "district"   => $this->district,
                "city"       => $this->city,
                "state"      => $this->state
            ];
        }
    }
?>