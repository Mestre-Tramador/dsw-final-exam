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
         * @var string EXT
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
        final private function __construct()
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
        final private function loadAll(string $class) : void
        {
            require_once (__DIR__ . "\\" . $class . spl_autoload_extensions());
        }

        /**
         * To prevent the creation of objects, this static
         * method simply calls the constructor.
         *
         * @return void
         * @static
         * @final
         */
        final public static function load() : void
        {
            new Autoload();
        }

        /**
         * Verify if the file is being included or loaded.
         * On the last case, redirect to the index.
         *
         * @param string $file **[optional]** The path of the file.
         * @return void
         * @static
         * @final
         */
        final public static function unload($file = __FILE__) : void
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