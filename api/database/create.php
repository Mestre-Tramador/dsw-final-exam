<?php
    namespace database;

    require_once "../load.php";

    use helper\Env;
    use helper\Response;
    use helper\Route;

    use manager\DatabaseManager;

    Route::POST();

    if(isset($_POST["db_name"]) && !empty($_POST["db_name"]))
    {
        $db_name = $_POST["db_name"];

        if(!in_array($db_name, VALID_NAMES))
        {
            Response::responseError("Invalid Database name!");
        }

        $manager = new DatabaseManager();     

        if($manager->createDatabase($db_name))
        {
            Response::responseOK(["message" => "Successfully created Database {$db_name}"]);
        }

        Response::responseError("Database could not be created!");
    }
    
    Response::responseError("Database name not informed!");
?>