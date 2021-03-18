<?php
    namespace person;

    require_once "../load.php";

    use \controller\AddressController;
    use \controller\PersonController;

    use \helper\Response;
    use \helper\Route;
    
    use \model\Person;

    Route::DELETE();

    /**
     * At first it verify for a valid ID, otherwise it return an Error.
     */
    if(empty($_DELETE["id"]))
    {
        Response::responseError("ID not informed for deletion!");
    }

    /**
     * The model for the deleted Person.
     * 
     * @var \model\Person $person
     */
    $person = Person::find($_DELETE["id"]);

    /**
     *  Check for an Address on the model. If it was found, then
     * it's removed firstly to maintain the cascading deletion.
     */
    if($person->haveAddress())
    {
        AddressController::delete($person->address->id());

        PersonController::deleteAddress($person->address->id());
    }

    /**
     * The result of the Deletion.
     * 
     * @var bool $delete
     */
    $delete = PersonController::delete($person->id());

    /**
     *  If everything goes well on the deletion, then an OK is responsed,
     * else an Error is shown.
     */
    if($delete)
    {
        Response::responseOK();
    }

    Response::responseError("Impossible to delete!");
?>