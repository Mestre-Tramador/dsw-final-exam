<?php
    namespace api;
    
    /**
     * Class for the autoload of the namespaces.
     * 
     * @final
     */
    final class Autoload
    {
        /**
         * Extension of the files.
         * 
         * @property-read string EXT
         */
        private const EXT = ".php";

        /**
         * When creating the Autoloader,
         * it loads the extensions and
         * all namespaces.
         * 
         * @return $this
         * @final
         */
        private final function __construct()
        {
            spl_autoload_extensions(self::EXT);
            spl_autoload_register([$this, "loadAll"]);
        }

        /**
         * One by one, the classes of the namespaces are loaded.
         *
         * @param string $class The name of the class to load.
         * @return void
         * @final
         */
        private final function loadAll(string $class)
        {
            require_once (__DIR__ . "\\" . $class . spl_autoload_extensions());
        }

        /**
         * To prevent the creation of objects, this static
         * method simply calls the constructor.
         *
         * @return void
         * @final
         * @static
         */
        public static final function load()
        {
            new Autoload();
        }

        /**
         * Verify if the file is being included or loaded.
         * On the last case, redirect to the index.
         *
         * @param [string] $file (option) The path of the file.
         * @return void
         * @final
         * @static
         */
        public static final function unload($file = __FILE__)
        {
            if(str_replace("\\", "/", $file) == str_replace("\\", "/", ($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])))
            {
                header("Location: /store/");
                die;
            }
        }
    }    

    Autoload::load();
?>