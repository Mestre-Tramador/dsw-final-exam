<?php
    const VALID_NAMES = ["store", "loja"];
    
    final class Autoload
    {
        private const EXT = ".php";

        private final function __construct()
        {
            spl_autoload_extensions(self::EXT);
            spl_autoload_register([$this, "loadAll"]);
        }

        private final function loadAll(string $class)
        {
            require_once (__DIR__ . "\\" . $class . spl_autoload_extensions());
        }

        public static final function load()
        {
            new Autoload();
        }
    }    

    Autoload::load();
?>