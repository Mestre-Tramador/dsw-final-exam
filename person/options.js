/**
 * Execute a Request to delete from the Database the Person.
 * 
 * @param {MouseEvent} event The click mouse event.
 */
function deletePerson(event)
{
    /**
     * The Person ID.
     * 
     * @type {Number}
     */
    const id = event.target.getAttribute("id");

    $.ajax({
        url     : "/store/api/person/delete.php",
        type    : "DELETE",
        data    : encodeURI(`id=${id}`),
        success : (data, status, xhr) => goToIndex(),
        error   : (xhr, status, error) => onError(xhr, status, error)
    });           

    /**
     * Print on the console the error.
     * 
     * @param {jqXHR} xhr jQuery XHR object.
     * @param {String} status HTTP Status.
     * @param {{reason:String}} error Returns the reason.
     */
    function onError(xhr, status, error)
    {
        console.log(xhr, status, error);
    }
}

/**
 * Do a Request to get the Person data from the Database.
 * 
 * @returns {Promise<{
 *  id:Number,
 *  address:{
 *      id:?Number,
 *      zip_code:?String,
 *      street:?String,
 *      number:?Number,
 *      complement:?String,
 *      reference:?String,
 *      district:?String,
 *      city:?String,
 *      state:?"AC"|"AL"|"AP"|"AM"|"BA"|"CE"|"ES"|"GO"|"MA"|"MT"|"MS"|"MG"|"PA"|"PB"|"PR"|"PE"|"PI"|"RJ"|"RN"|"RS"|"RO"|"RR"|"SC"|"SP"|"SE"|"TO"|"DF",
 *      created_at:?String,
 *      updated_at:?String,
 *      deleted_at:null
 *  },
 *  type:"physical"|"legal",
 *  name:String,
 *  surname:String,
 *  gender:"F"|"M"|"O",
 *  document:String,
 *  phone:?String,
 *  cellphone:?String,
 *  birth_date:String,
 *  created_at:String,
 *  updated_at:String,
 *  deleted_at:null
 * }|{}>} It returns an empty object if there is no **id** on the URL's `GET`, else the Person Data.
 */
function getDataToUpdate()
{
    return new Promise((resolve) => {
        /**
         * The current URL.
         * 
         * @type {URL}
         */
        const url = new URL(window.location.href);

        if(url.searchParams.get("id") === null)
        {
            resolve({});

            return
        }

        /**
         * The given Person ID.
         * 
         * @type {Number}
         */
        const id = Number(url.searchParams.get("id"));

        $.ajax({
            url     : "/store/api/person/",
            type    : "GET",
            data    : `id=${id}`,
            success : (data, status, xhr) => resolve(data),
        });
    });
}

/**
 * Mask a value to put on the form based on its control ID.
 * 
 * @param {"name"|"surname"|"document"|"birth_date"|"gender"|"phone"|"cellphone"|"street"|"number"|"district"|"zip_code"|"complement"|"reference"|"city"|"state"} control The ID of the Control HTML Element.
 * @param {String} value The value to be masked.
 * @returns {String} The value correctly masked.
 */
function formMask(control, value)
{
    switch(control)
    {
        case "document":
            if(isPhysical(ENV["type"]))
            {
                value = `${value.slice(0, 3)}.${value.slice(3, 6)}.${value.slice(6, 9)}-${value.slice(9, 11)}`;
            }

            if(isLegal(ENV["type"]))
            {
                value = `${value.slice(0, 2)}.${value.slice(2, 5)}.${value.slice(5, 8)}/${value.slice(8, 12)}-${value.slice(12, 14)}`;
            }
        break;

        case "phone":
            value = `(${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6, 10)}`;
        break;

        case "cellphone":
            value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7, 11)}`;
        break;

        case "zip_code":
            value = `${value.slice(0, 5)}-${value.slice(5, 8)}`;
        break;
    }

    return value;
}

/**
 * Convert the Save Button into an Uptade and Delete buttons div.
 */
function convertFormButtons()
{
    /**
     * The row of the buttons.
     * 
     * @type {HTMLDivElement}
     */
    const buttons = document.getElementById("btn_row");

    
    // ? Clearing the actual div.
    buttons.innerHTML = ``;


    // ? Appending the configured new buttons.
    buttons.appendChild(getUpdateButton());
    buttons.appendChild(getDeleteButton());

    /**
     * Create an Update button.
     * 
     * @returns {HTMLDivElement} The column with the button.
     */
    function getUpdateButton()
    {
        /**
         * A Column base for each new button.
         * 
         * @type {HTMLDivElement}
         */
        const column = document.createElement("div");

        /**
         * A Button base for each new.
         * 
         * @type {HTMLButtonElement}
         */
        const button = document.createElement("button");


        // ? Adding classes for style.
        column.classList.add("col-6", "mb-3");

        button.classList.add("btn", "btn-block", "btn-primary", "mt-4");


        // ? Adding Attributes.
        button.setAttribute("id", ENV["id"]);
        button.setAttribute("address_id", ENV["address_id"]);


        // ? Adding the click Event.
        button.addEventListener("click", (event) => updatePerson(event));


        // ? Adding the text.
        button.innerText = "Atualizar Dados";


        // ? Final appending.
        column.appendChild(button);

        
        return column;
    }

    /**
     * Create a Delete button.
     * 
     * @returns {HTMLDivElement} The column with the button.
     */
    function getDeleteButton()
    {        
        /**
         * A Column base for each new button.
         * 
         * @type {HTMLDivElement}
         */
        const column = document.createElement("div");

        /**
         * A Button base for each new.
         * 
         * @type {HTMLButtonElement}
         */
        const button = document.createElement("button");


        // ? Adding classes for style.
        column.classList.add("col-6", "mb-3");

        button.classList.add("btn", "btn-block", "btn-danger", "mt-4");

        // ? Adding Attributes.
        button.setAttribute("id", ENV["id"]);


        // ? Adding the click Event.
        button.addEventListener("click", (event) => deletePerson(event));

        
        // ? Adding the text.
        button.innerText = "Excluir";


        // ? Final appending.
        column.appendChild(button);

        
        return column;
    }
}

/**
 * Execute a Request to Update the selected person data.
 * 
 * @param {MouseEvent} event The click event.
 */
function updatePerson(event)
{
    /**
     * The Person ID.
     * 
     * @type {Number}
     */
    const id = event.target.getAttribute("id");

    /**
     * The Person Address ID.
     * 
     * @type {Number|null}
     */
    const address_id = event.target.getAttribute("address_id");

    validateForm()
    .then((validation) => {
        if(isValid(validation[0], validation[1]))
        {            
            $.ajax({
                url     : "/store/api/person/update.php",
                type    : "PUT",
                data    : gatherData(id, address_id),
                success : (data, status, xhr) => goToIndex(),
                error   : (xhr, status, error) => onError(xhr, status, error)
            });           

            /**
             * Print on the console the error.
             * 
             * @param {jqXHR} xhr jQuery XHR object.
             * @param {String} status HTTP Status.
             * @param {{reason:String}} error Returns the reason.
             */
            function onError(xhr, status, error)
            {
                console.log(xhr, status, error);
            }
        }
    });
}