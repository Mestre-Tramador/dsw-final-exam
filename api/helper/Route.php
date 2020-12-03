<?php
    namespace helper;

    final class Route
    {
        public static final function INDEX()
        {
            header("Location: /store/");
            die;
        }

        public static final function DOCS()
        {
            header("Location: /store/docs/");
            die;
        }

        public static final function GET()
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: GET");
        }

        public static final function POST()
        {
            self::HEADER();

            header("Access-Control-Allow-Methods: POST");
        }

        public static final function PUT()
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: PUT");
        }

        public static final function DELETE()
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: DELETE");
        }

        private static final function HEADER()
        {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            header("Acept: application/x-www-form-urlencoded; charset=UTF-8");
        }
    }
?>