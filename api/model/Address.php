<?php
    namespace model;

    require_once "../load.php";

    use \api\Autoload;

    use \controller\AddressController;

    /**
     * The Model representantion of the \``address`\` table.
     * 
     * @final
     */
    final class Address extends Model
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
         * @param int|null $id The Address ID.
         * @return void
         */
        private function __construct(?int $id = null)
        {
            parent::__construct($id);
        }

        /**
         * Instantiate a new Address.
         *
         * @return Address
         */
        public static function instantiate(): Address
        {
            return new Address();
        }

        /**
         * Find an Address by its ID.
         *
         * @param int $id The Address ID.
         * @return \model\Address
         */
        public static function find(int $id): Address
        {
            $address = new Address($id);

            $model = AddressController::read($id);

            $address->zip_code   = $model["zip_code"];
            $address->street     = $model["street"];
            $address->number     = (int) $model["number"];
            $address->complement = $model["complement"];
            $address->reference  = $model["reference"];
            $address->district   = $model["district"];
            $address->city       = $model["city"];
            $address->state      = $model["state"];
            $address->created_at = $model["created_at"];
            $address->updated_at = $model["updated_at"];
            $address->deleted_at = $model["deleted_at"];

            return $address;
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
                "id"         => $this->id(),
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

    Autoload::unload(__FILE__);
?>