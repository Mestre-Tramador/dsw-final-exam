<?php
    namespace database;

    require_once "../load.php";

    use \helper\Env;
    use \helper\Response;
    use \helper\Route;

    use \manager\DatabaseManager;

    Route::POST();

    /**
     * Test if a valid name is passed by POST, if not, print an error.
     */
    if(isset($_POST["db_name"]) && !empty($_POST["db_name"]))
    {
        /**
         * This represents the given name of the database,
         * still not validated.
         * 
         * @var string
         */
        $db_name = $_POST["db_name"];

        /**
         * If the name isn't valid, then an error is returned.
         */
        if(!in_array($db_name, Env::getDatabaseValidNames()))
        {
            Response::responseError("Invalid Database name!");
        }

        /**
         * The manager of the Database.
         * 
         * @var \manager\DatabaseManager
         */
        $manager = new DatabaseManager();     

        /**
         * With the manager, then the Database is created, otherwise inform the error.
         */
        if($manager->createDatabase($db_name))
        {
            Response::responseOK(["database" => $db_name]);
        }

        Response::responseError("Database could not be created!");
    }
    
    Response::responseError("Database name not informed!");
?>