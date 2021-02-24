<?php
    namespace helper;

    require_once "../load.php";
    
    use \api\Autoload;

    /**
     * Class to manage headers, redirects and routes types.
     * 
     * @final
     */
    final class Route
    {
        /**
         * Redirect to the Index.
         *
         * @return void
         * @static
         * @final
         */
        final public static function INDEX() : void
        {
            header("Location: /store/");
            die;
        }

        /**
         * Redirect to the Docs.
         *
         * @return void
         * @static
         * @final
         */
        final public static function DOCS() : void
        {
            header("Location: https://github.com/Mestre-Tramador/dsw-final-exam/blob/master/docs/API.md");
            die;
        }

        /**
         * Put all the headers and turn the route to `GET`.
         *
         * @return void
         * @static
         * @final
         */
        final public static function GET() : void
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: GET");
        }

        /**
         * Put all the headers and turn the route to `POST`.
         *
         * @return void
         * @static
         * @final
         */
        final public static function POST() : void
        {
            self::HEADER();

            header("Access-Control-Allow-Methods: POST");
        }

        /**
         * Put all the headers and turn the route to `PUT`.
         *
         * @return void
         * @static
         * @final
         */
        final public static function PUT() : void
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: PUT");
        }

        /**
         * Put all the headers and turn the route to `DELETE`.
         *
         * @return void
         * @static
         * @final
         */
        final public static function DELETE() : void
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: DELETE");
        }

        /**
         * Put a series of headers on the Route to improve it.
         *
         * @return void
         * @static
         */
        private static function HEADER() : void
        {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            header("Acept: application/x-www-form-urlencoded; charset=UTF-8");
        }

        /**
         * Verify if the address `POST` data is not empty and valid.
         * 
         * @param array $post The `POST` array.
         * @return boolean Returns **TRUE** if the address is valid and correctly filled.
         */
        final public static function isAddressPostData(array $post) : bool
        {
            /**
             * All the possible address data sended by post.
             * 
             * @var string $zip_code
             * @var string $street
             * @var string $number
             * @var string $complement
             * @var string $reference
             * @var string $district
             * @var string $city
             * @var string $state
             */
            [
                "zip_code"   => $zip_code,
                "street"     => $street,
                "number"     => $number,
                "complement" => $complement,
                "reference"  => $reference,
                "district"   => $district,
                "city"       => $city,
                "state"      => $state
            ] = $post;

            return (!self::isAddressPostDataEmpty($zip_code, $street, $number, $district, $city, $state));
        }

        /**
         * Iterate between all the fields and verify if none is empty.
         * 
         * @param string ...$fields The fields of the Address.
         * @return boolean Return **TRUE** if at least one is empty.
         * @static
         */
        private static function isAddressPostDataEmpty(string ...$fields) : bool
        {
            $isEmpty = false;

            foreach($fields as $field)
            {
                if(empty($field))
                {
                    $isEmpty = true;
                }
            }

            return $isEmpty;
        }
    }

    Autoload::unload(__FILE__);
?>