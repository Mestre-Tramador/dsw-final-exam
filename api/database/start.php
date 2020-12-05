<?php
    namespace database;

    require_once "../load.php";

    use helper\Env;
    use helper\Response;
    use helper\Route;

    Route::GET();
   
    if(Env::getActualDatabase() !== null)
    {
        $connection = new Connection();

        if($connection->conn !== null)
        {
            Response::responseOK(["database" => Env::getActualDatabase()]);
        }

        Env::clearActualDatabase();
    }

    $db_name = "";

    foreach(VALID_NAMES as $name)
    {
        $connection = new Connection(false, $name);

        if($connection->conn !== null)
        {
            $db_name = $name;
            break;
        }
    }

    if(!empty($db_name))
    {
        Env::setActualDatabase($db_name);

        Response::responseOK(["message" => "Using database `{$db_name}`"]);
    }
    
    Response::responseError("There is no Database!");
?>