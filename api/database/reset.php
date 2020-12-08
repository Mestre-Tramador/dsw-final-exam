<?php
    namespace database;

    require_once "../load.php";

    use helper\Env;
    use helper\Response;
    use helper\Route;
    
    use manager\DatabaseManager;

    Route::GET();

    /**
     *  It tests to only be able to reset when
     * there is a Database on the ENV, else it return an error.
     */
    if(Env::getActualDatabase() !== null)
    {
        /**
         * The Database Manager.
         * 
         * @var \manager\DatabaseManager
         */
        $manager = new DatabaseManager();

        /**
         * With the manager, destroy the Database and clear the ENV.
         * The response is the OK procedure.
         */
        if($manager->destroyDatabase())
        {
            Env::clearActualDatabase();
            
            Response::responseOK();
        }
    }

    Response::responseError();
?>