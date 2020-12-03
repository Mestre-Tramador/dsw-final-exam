<?php
    namespace helper;
    
    final class Response
    {
        private const OK = 200;
        private const ERROR = 400;
        private const UNPROCESSABLE = 422;

        public static final function responseOK(array $data = null)
        {
            self::response(self::OK);

            if(!isset($data))
            {
                $data = ["message" => "OK"];
            }
            
            self::responseJSON($data);
        }

        public static final function responseError(string $reason = "Untreated Error")
        {
            self::response(self::ERROR);

            $data = ["reason" => $reason];

            self::responseJSON($data);
        }

        public static final function responseUnprocessable(array $fields = null, string $reason = "Untreated Error")
        {
            self::response(self::UNPROCESSABLE);

            if(isset($fields) || !empty($fields))
            {
                $reason = "Incorrect fields ";

                foreach ($fields as $key => $value)
                {
                    $reason.=$value;
                    
                    if(isset($fields[$key + 1]))
                    {
                        $reason.=", ";
                    }
                }
            }
            
            $data = ["reason" => $reason];

            self::responseJSON($data);
        }
        
        private static final function response(int $code)
        {
            header("Content-Type: application/json; charset=UTF-8");
            
            http_response_code($code);
        }

        private static final function responseJSON(array $data)
        {
            echo json_encode($data);
            die;
        }

    }
?>