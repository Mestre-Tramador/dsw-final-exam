<?php
    namespace person;

    require_once "../load.php";

    use \controller\AddressController;
    use \controller\PersonController;

    use \helper\Response;
    use \helper\Route;

    use \model\Address;
    use \model\Person;

    Route::PUT();

    /**
     * The update can only occurr when there is an ID.
     */
    if(empty($_PUT["id"]))
    {
        Response::responseError("ID not informed!");
    }

    /**
     * To prevent errors, if the Address ID is empty, then is correctly null typed.
     */
    if(!isset($_PUT["address_id"]) || empty($_PUT["address_id"]))
    {
        $_PUT["address_id"] = null;
    }

    /**
     * The model for the updated Person.
     * 
     * @var \model\Person $model
     */
    $model = Person::find($_PUT["id"]);

    /**
     * ? For Documenting purposes, the types of the Model's Attributes are setted.
     */
    /** @var string $type */
    $model->type = $_PUT["type"];
    
    /** @var string $name */
    $model->name = $_PUT["name"];
    
    /** @var string $surname */
    $model->surname = $_PUT["surname"];
    
    /** @var string $gender */
    $model->gender = $_PUT["gender"];
    
    /** @var string $document */
    $model->document = $_PUT["document"];
    
    /** @var string|null $phone */
    $model->phone = $_PUT["phone"];
    
    /** @var string|null $cellphone */
    $model->cellphone = $_PUT["cellphone"];
    
    /** @var string $birth_date */
    $model->birth_date = $_PUT["birth_date"];

    /**
     * If is the Data for an Address, then it's updated first to run in cascade mode.
     * On the case the form is empty but there is an ID, then it consider as a Address Deletion.
     */
    if(Route::isAddressPostData($_PUT))
    {
        /**
         * The model for the created/updated Address.
         * 
         * @var \model\Address $submodel
         */
        $submodel = Address::instantiate();

        /**
         * If there is an Address ID, then the submodel is reloaded with data.
         */
        if($model->address->id() !== null)
        {
            /**
             * This model starts with data.
             * 
             * @var \model\Address $submodel
             */
            $submodel = Address::find($model->address->id());
        }

        /**
         * ? For Documenting purposes, the types of the SubModel's Attributes are setted.
         */
        /** @var string $zip_code */
        $submodel->zip_code = $_PUT["zip_code"];
        
        /** @var string $street */
        $submodel->street = $_PUT["street"];
        
        /** @var int $number */
        $submodel->number = $_PUT["number"];
        
        /** @var string|null $complement */
        $submodel->complement = $_PUT["complement"];
        
        /** @var string|null $reference */
        $submodel->reference = $_PUT["reference"];
        
        /** @var string $district */
        $submodel->district = $_PUT["district"];
        
        /** @var string $city */
        $submodel->city = $_PUT["city"];
        
        /** @var string $state */
        $submodel->state = $_PUT["state"];

        AddressController::create($submodel);

        $model->joinAddress($submodel->id());
    }
    else if($model->address->id() !== null)
    {
        /**
         * The controller for the deleted Address.
         * 
         * @var \controller\AddressController $subcontroller
         */
        $subcontroller = new AddressController();

        AddressController::delete($model->address->id());

        PersonController::deleteAddress($model->address->id());

        $model = Person::find($model->id());
    }

    /**
     * The final and new array with the Person update to Response.
     * 
     * @var array $person
     */
    $person = PersonController::update($model->id(), $model);

    Response::responseOK($person);
?>