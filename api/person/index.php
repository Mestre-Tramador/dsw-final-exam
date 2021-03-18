<?php
    namespace person;

    require_once "../load.php";

    use \controller\PersonController;

    use \helper\Response;
    use \helper\Route;


    Route::GET();

    /**
     * The query search.
     * 
     * @var null $search
     */
    $search = null;

    /**
     *  By first the query is verified to check if there is a ID
     * for search, and if so, it is saved.
     */
    if(!empty($_GET["id"]))
    {
        /**
         * If an ID is passed by the route,
         * then the search becomes its value.
         * 
         * @var int $search
         */
        $search = $_GET["id"];
    }

    /**
     * Contains an array list with the Person(s)
     * fetched from the Database.
     * 
     * @var array $fetch
     */
    $fetch = PersonController::read($search);

    /**
     *  The final response is allways OK, and the array
     * can contain none, one, or all valid Persons registered.
     */
    Response::responseOK($fetch);
?>