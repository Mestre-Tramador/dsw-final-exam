<?php
    namespace database;

    require_once "../load.php";

    use helper\Env;
    use helper\Response;
    use helper\Route;

    Route::GET();

    /**
     * Will hold the name of the database.
     * @var string $db_name
     */
    $db_name = "";
   

    /**
     *  First it checks if there is a Database on the ENV,
     * if it still exists on the server, then an Connection is tested.
     * 
     * May the Connection fail the ENV is cleared, otherwise the Database is returned.
     */
    if(Env::getActualDatabase() !== null)
    {
        $connection = new Connection();

        if($connection->conn !== null)
        {
            $db_name = Env::getActualDatabase();

            Response::responseOK(["database" => $db_name]);
        }

        Env::clearActualDatabase();
    }

    /**
     *  On the case there is not a Database on the ENV,
     * both valid names are tested to search for a Database on the server.
     * 
     *  When a Connection is succeed, then the name is set.
     */
    foreach(Env::getDatabaseValidNames() as $name)
    {
        $connection = new Connection(false, $name);

        if($connection->conn !== null)
        {
            $db_name = $name;
            break;
        }
    }

    /**
     *  Finally the ENV is filled with the name and the responde is printed,
     * or an error is expressed informing there is no Database.
     */
    if(!empty($db_name))
    {
        Env::setActualDatabase($db_name);

        Response::responseOK(["database" => $db_name]);
    }
    
    Response::responseError("There is no Database!");
?>