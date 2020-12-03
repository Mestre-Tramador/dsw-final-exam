<?php
    namespace database;

    require "../load.php";

    use helper\Env;
    use helper\Response;
    use helper\Route;

    Route::POST();
    
    const VALID_NAMES = ["store", "loja"];

    if(isset($_POST["db_name"]) && !empty($_POST["db_name"]))
    {
        $db_name = $_POST["db_name"];

        if(!in_array($db_name, VALID_NAMES))
        {
            Response::responseError("Invalid Database name!");
        }

        Env::setActualDatabase($db_name);

        if(Env::getActualDatabase())
        {
            Response::responseOK();
        }
    }
    
    Response::responseError("Database name not informed!");
?>