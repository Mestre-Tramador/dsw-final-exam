<?php
    namespace person;    

    require_once "../load.php";

    use \controller\AddressController;
    use \controller\PersonController;
    
    use \helper\Response;
    use \helper\Route;
    
    use \model\Address;
    use \model\Person;

    Route::POST();

    /**
     * Firtly it checks if there is no ID passed by the POST, wich case returns an Error.
     * Else, it creates a Model and a Controller for the Person and set the Model's Data.
     */
    if(!empty($_POST["id"]))
    {
        Response::responseError("There is an Person with this ID!");
    }

    /**
     * The model for the created Person.
     * 
     * @var \model\Person $model
     */
    $model = Person::instantiate();  

    /**
     * ? For Documenting purposes, the types of the Model's Attributes are setted.
     */
    /** @var string $type */
    $model->type = $_POST["type"];
    
    /** @var string $name */
    $model->name = $_POST["name"];
    
    /** @var string $surname */
    $model->surname = $_POST["surname"];
    
    /** @var string $gender */
    $model->gender = $_POST["gender"];
    
    /** @var string $document */
    $model->document = $_POST["document"];
    
    /** @var string|null $phone */
    $model->phone = $_POST["phone"];
    
    /** @var string|null $cellphone */
    $model->cellphone = $_POST["cellphone"];
    
    /** @var string $birth_date */
    $model->birth_date = $_POST["birth_date"];


    /**
     * The array containing the result and the data of the Person, if created.
     * 
     * @var array $person
     */
    $person = PersonController::create($model);

    /**
     * If the result is false, then an Error is informed to the User.
     */
    if(!$person["result"])
    {
        Response::responseError("An error occured when creating the Person!");
    }

    /**
     * The model key still is an array, with the Person data.
     * 
     * @var array $person
     */
    $person = $person["model"];

    /**
     * The Route class itself can check if there is the data for creating an Address.
     */
    if(Route::isAddressPostData($_POST))
    {
        /**
         * The model for the created Address.
         * 
         * @var \model\Address $submodel
         */
        $submodel = Address::instantiate();
        
        /**
         * ? For Documenting purposes, the types of the SubModel's Attributes are setted.
         */
        /** @var string $zip_code */
        $submodel->zip_code = $_POST["zip_code"];
        
        /** @var string $street */
        $submodel->street = $_POST["street"];
        
        /** @var int $number */
        $submodel->number = $_POST["number"];
        
        /** @var string|null $complement */
        $submodel->complement = $_POST["complement"];
        
        /** @var string|null $reference */
        $submodel->reference = $_POST["reference"];
        
        /** @var string $district */
        $submodel->district = $_POST["district"];
        
        /** @var string $city */
        $submodel->city = $_POST["city"];
        
        /** @var string $state */
        $submodel->state = $_POST["state"];

        /**
         * The array containing the result and the data of the Address, if created.
         * 
         * @var array $address
         */
        $address = AddressController::create($submodel);

        /**
         * If the result is false, then an Error is informed to the User.
         * It also delete the created Person to prevent further errors.
         */
        if(!$address["result"])
        {
            PersonController::delete($model->id);

            Response::responseError("An error occured when creating the Address!");
        }

        /**
         * The model key still is an array, with the Address data.
         * 
         * @var array $address
         */
        $address = $address["model"];

        /**
         * The address of the Person Model is setted and the model is updated.
         */
        $model->joinAddress($address["id"]);

        $person = PersonController::update($model->id(), $model);
    }

    /**
     * If everything goes OK, then the created person is returned.
     */
    Response::responseOK($person);
?>