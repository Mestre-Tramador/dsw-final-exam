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
     * @var \model\Person $model
     */
    $model = new Person($_DELETE["id"]);

    /**
     * The controller for the deleted Person.
     * 
     * @var \controller\PersonController $controller
     */
    $controller = new PersonController();

    /**
     *  Check for an Address on the model. If it was found, then
     * it's removed firstly to maintain the cascading deletion.
     */
    if(isset($model->address_id))
    {
        /**
         * The controller for the deleted Address.
         * 
         * @var \controller\AddressController $subcontroller
         */
        $subcontroller = new AddressController();

        $subcontroller->delete($model->address_id);

        $controller->deleteAddress($model->address_id);

        $model->setAddress(null);
    }

    /**
     * The result of the Deletion.
     * 
     * @var bool $delete
     */
    $delete = $controller->delete($model->id);

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