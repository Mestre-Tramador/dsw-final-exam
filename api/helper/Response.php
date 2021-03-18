<?php
    namespace helper;

    require_once "../load.php";

    use \api\Autoload;

    /**
     * Class to manage Responses and JSONs.
     * 
     * @final
     */
    final class Response
    {
        /**
         * Code for "OK" responses.
         * @var int
         */
        private const OK = 200;

        /**
         * Code for "ERROR" responses.
         * @var int
         */
        private const ERROR = 400;

        /**
         * Code for "UNPROCESSABLE ENTITY" responses.
         * @var int
         */
        private const UNPROCESSABLE = 422;

        /**
         * Finalize the route operation with OK result.
         * If no data are sended, it only response with a OK string message.
         *
         * @param array|null $data Can contain a mixed array with data.
         * @return void
         * @static
         * @final
         */
        public static function responseOK(?array $data = null) : void
        {
            self::response(self::OK);

            if(!isset($data))
            {
                $data = ["message" => "OK"];
            }
            
            self::responseJSON($data);
        }

        /**
         * Finalize the route operation with ERROR result.
         * If none message are passed, then a default message for untreated errors is returned with the response.
         *
         * @param string $reason The reason of the error.
         * @return void
         * @static
         * @final
         */
        public static function responseError(string $reason = "Untreated Error") : void
        {
            self::response(self::ERROR);

            $data = ["reason" => $reason];

            self::responseJSON($data);
        }

        /**
         * Finalize the route operation with UNPROCESSABLE result.
         * If not both parameters are passed, then a simple message of error is returned.
         *
         * @param array|null $fields An array of incorrect fields.
         * @param string $reason The reason of the error.
         * @return void
         * @static
         * @final
         */
        public static function responseUnprocessable(?array $fields = null, string $reason = "Untreated Error") : void
        {
            self::response(self::UNPROCESSABLE);

            if(isset($fields) || !empty($fields))
            {
                $reason = "Incorrect fields ";

                foreach ($fields as $key => $value)
                {
                    $reason .= $value;
                    
                    if(isset($fields[$key + 1]))
                    {
                        $reason .= ", ";
                    }
                }
            }
            
            $data = ["reason" => $reason];

            self::responseJSON($data);
        }
        
        /**
         * Set the responde header to be JSON MIME type and the HTTP code.
         *
         * @param integer $code HTTP Response Code.
         * @return void
         * @static
         */
        private static function response(int $code) : void
        {
            header("Content-Type: application/json; charset=UTF-8");
            
            http_response_code($code);
        }

        /**
         * Echoes the data on the page as a JSON and finalize all the less operations.
         *
         * @param array $data The array to be encoded.
         * @return void
         * @static
         */
        private static function responseJSON(array $data) : void
        {
            echo json_encode($data);
            die;
        }
    }

    Autoload::unload(__FILE__);
?>