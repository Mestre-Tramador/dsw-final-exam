<?php
    namespace helper;

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
        public static final function INDEX()
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
        public static final function DOCS()
        {
            header("Location: /store/docs/");
            die;
        }

        /**
         * Put all the headers and turn the route to `GET`.
         *
         * @return void
         * @static
         * @final
         */
        public static final function GET()
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
        public static final function POST()
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
        public static final function PUT()
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
        public static final function DELETE()
        {
            self::HEADER();
            
            header("Access-Control-Allow-Methods: DELETE");
        }

        /**
         * Put a series of headers on the Route to improve it.
         *
         * @return void
         * @static
         * @final
         */
        private static final function HEADER()
        {
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Max-Age: 3600");
            header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
            header("Acept: application/x-www-form-urlencoded; charset=UTF-8");
        }
    }
?>