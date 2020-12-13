/**
 * Execute a Request to create a Database on the server.
 * 
 * @param {"store"|"loja"} name The name of the Database.
 */
function createDatabase(name)
{
    $.ajax({
        url     : "/store/api/database/create.php",
        type    : "POST",
        data    : encodeURI(`db_name=${name}`),
        success : (data, status, xhr) => onSuccess(data, status, xhr),
        error   : (xhr, status, error) => onError(xhr, status, error)
    }); 

    /**
     * If the Database was created, then the Success Callback is runned.
     * 
     * @param {{database:"store"|"loja"}} data Returns the same name.
     * @param {String} status HTTP Status.
     * @param {jqXHR} xhr jQuery XHR object.
     */
    function onSuccess(data, status, xhr)
    {
        document.getElementById("database").remove();

        ENV["database"] = data["database"];
        
        printActualDatabase();
        
        setCardMenus(menu);
    }
    
    /**
     * If the Database wasn't created, then the Error Callback is runned.
     * 
     * @param {jqXHR} xhr jQuery XHR object.
     * @param {String} status HTTP Status.
     * @param {{reason:String}} error Returns the reason.
     */
    function onError(xhr, status, error)
    {
        /** @type {HTMLDivElement} */
        const feedback = document.getElementById("database_feedback");
        
        feedback.classList.add("d-block");
    }
}

/**
 * Execute a Request to get the Person List Data and then print it.
 */
function getPersonListData()
{
    $.ajax({
        url     : "/store/api/person/",
        type    : "GET",
        success : (data, status, xhr) => printPersonList(data),
    });
}

/**
 * Initialize event for the index,
 * wich search for the actual Database and handle every case,
 * printing the data list or display the Database Creation. 
 */
function init()
{
    /**
     * The Menu and Listage card body.
     * 
     * @type {HTMLDivElement}
     */
    const menu = document.getElementById("menu");

    /**
     * The Database Selector card body.
     * 
     * @type {HTMLDivElement}
     */
    const database = document.getElementById("database");

    getActualDatabase()
    .then((success) => {
        database.remove();

        ENV["database"] = success["data"]["database"];

        printActualDatabase();

        getPersonListData();
    })
    .catch((rejection) => {
        setCardMenus(database, menu);
    });
}

/**
 * Simply put on the screen the actual Database of the ENV.
 */
function printActualDatabase()
{
    document.getElementById("database_actual").innerHTML = `Usando Banco de Dados: <code class="text-info">${ENV["database"].toUpperCase()}</code>`;
}

/**
 * Execute a Request to eliminate the Database from the ENV.
 */
function refreshEnvironment()
{
    $.ajax({
        url     : "/store/api/database/reset.php",
        type    : "GET",
        success : (data, status, xhr) => onSuccess(data, status, xhr)
    }); 

    /**
     * If the Database was dropped, then the Success Callback is runned.
     * 
     * @param {{message:"OK"}} data Returns the message.
     * @param {String} status HTTP Status.
     * @param {jqXHR} xhr jQuery XHR object.
     */
    function onSuccess(data, status, xhr)
    {        
        goToIndex();
    }
}

/**
 * Set the visibility between the two Card Bodies.
 * 
 * @param {HTMLDivElement} toShow The card body to show.
 * @param {HTMLDivElement} [toHide] The opitional card body to hide.
 */
function setCardMenus(toShow, toHide = null)
{
    if(toHide !== null)
    {
        toHide.classList.remove("d-block");
        toHide.classList.add("d-none");
    }
    
    toShow.classList.remove("d-none");
    toShow.classList.add("d-block");
}

/**
 * Set a text informing that the Database will be deleted.
 * 
 * @param {Boolean} display ***TRUE** to display and **FALSE** to hide.
 */
function setDatabaseDeleteText(display)
{
    /**
     * The actual Database Text.
     * 
     * @type {HTMLSpanElement}
     */
    const database = document.getElementById("database_actual");
    
    if(display)
    {
        database.classList.add("text-danger");
        database.innerHTML = "Excluir Bando de Dados!"

        return;
    }

    database.classList.remove("text-danger");
    
    printActualDatabase();
}

/**
 * Set the display on screen of a flavor text for a Database.
 * 
 * @param {Boolean} display ***TRUE** to display and **FALSE** to hide.
 * @param {"S"|"L"} [database] If passed, handle wich text will be shown.
 */
function setDatabaseFlavorText(display, database = "")
{
    const flavorText = document.getElementById("database_flavor");

    if(!display)
    {
        flavorText.classList.add("d-none");
    }

    flavorText.classList.remove("d-none");
    flavorText.classList.add("d-block");

    let text = "";

    switch(database)
    {
        case "S":
            text = "O Banco de Dados <code class=\"text-info\">store</code> é uma versão melhorada do banco de dados <code class=\"text-info\">loja</code>.";
        break;
        case "L":
            text = "O Banco de Dados <code class=\"text-info\">loja</code> é a primeira versão, já sinalizada como <code class=\"text-info\">deprecated</code>.";
        break;
    }

    flavorText.innerHTML = text;
}

/**
 * Create a list item and print it for every registered person
 * 
 * @param {{
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
 * }[]} data A list with a full set for every registered Person.
 */
function printPersonList(data)
{
    /**
     * The element for the list.
     * 
     * @type {HTMLDivElement}
     */
    const persons = document.getElementById("persons");
    
    persons.innerHTML = ``;

    data.forEach((person) => {
        persons.innerHTML+=`<!-- Start of the ${person["name"]}'s item. -->`;
        
        persons.appendChild(createPersonListItem(person));

        persons.innerHTML+=`<!-- End of the ${person["name"]}'s item. -->`;
    });

    /**
     * Using the person data, create a item for the list.
     * 
     * @param {{
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
     * }} person 
     * @returns {HTMLAnchorElement}
     */
    function createPersonListItem(person)
    {
        /**
         * The item element itself.
         * 
         * @type {HTMLAnchorElement}
         */
        const item = document.createElement("a");

        /**
         * The title of the item.
         * 
         * @type {HTMLDivElement}
         */
        const title = document.createElement("div");

        /**
         * The name in the title.
         * 
         * @type {HTMLHeadingElement}
         */
        const name = document.createElement("h5");        

        /**
         * The date in the title.
         * 
         * @type {HTMLElement}
         */
        const date = document.createElement("small");

        /**
         * The text containing main data.
         * 
         * @type {HTMLParagraphElement}
         */
        const text = document.createElement("p");

        /**
         * The text containgin address info.
         * 
         * @type {HTMLElement}
         */
        const subtext = document.createElement("small");

        // ? Start of class list definition.
            item.classList.add("list-group-item", "list-group-item-action", "flex-column", "align-items-start");

            title.classList.add("d-flex", "w-100", "justify-content-between");

            name.classList.add("mb-1");
            
            text.classList.add("mb-1");
        // ? End of class list definition.

        // ? Start of attributes definition.
            item.setAttribute("href", `/store/person/?id=${person["id"]}`);
        // ? End of attributes definition.

        // ? Start of text appending.
            name.append(buildName(person["name"], person["surname"]))

            date.append(buildDate(person["type"], person["gender"], person["birth_date"]));        

            text.append(buildText(person["type"], person["document"], person["gender"]));

            subtext.append(buildSubtext(person["address"]["id"]));
        // ? End of text appending.

        // ? Start of child appending.
            title.appendChild(name);
            title.appendChild(date);

            item.appendChild(title);

            item.appendChild(text);
            item.appendChild(subtext);
        // ? End of child appending.

        return item;
    }

    /**
     * Build the person name.
     * 
     * @param {String} name 
     * @param {String} surname 
     * @returns {String}
     */
    function buildName(name, surname)
    {
        return `${name} ${surname}`;
    }

    /**
     * Build the person birth date. 
     * 
     * @param {"physical"|"legal"} type 
     * @param {"F"|"M"|"O"} gender 
     * @param {String} birth_date 
     * @returns {String}
     */
    function buildDate(type, gender, birth_date)
    {
        return `${(isPhysical(type) ? `Nascid${handleGenderCase(gender)}` : "Aberta")} em ${formatBirthDate(birth_date)}`
    }

    /**
     * Build the person address info.
     * 
     * @param {Number|null} address_id 
     * @returns {String}
     */
    function buildSubtext(address_id)
    {
        return `${address_id !== null ? "P" : "Não p"}ossui endereço cadastrado.`;
    }

    /**
     * Build the person data text.
     * 
     * @param {"physical"|"legal"} type 
     * @param {String} document 
     * @param {"F"|"M"|"O"} gender 
     * @returns {String}
     */
    function buildText(type, document, gender)
    {
        return `Cadastrad${(isPhysical(type) ? `${handleGenderCase(gender)}` : "a")} sob documento ${mask(type, document)}`
    }

    /**
     * Format the birth date.
     * 
     * @param {String} birth_date A date string in the `YYYY-MM-DD` format.
     * @returns {String} A date formatted to `DD/MM/YYYY` format.
     */
    function formatBirthDate(birth_date)
    {
        birth_date+=" ";

        /**
         * Date object to handle.
         * 
         * @type {Date}
         */
        const date = new Date(birth_date);

        /**
         * The Day.
         * 
         * @type {String}
         */
        const day = String((date.getDate() < 10 ? `0${date.getDate()}` : date.getDate()));
        
        /**
         * The Month.
         * 
         * @type {String}
         */
        const month = String(((date.getMonth() + 1) < 10 ? `0${(date.getMonth() + 1)}` : (date.getMonth() + 1)));
        
        /**
         * The Year.
         * 
         * @type {String}
         */
        const year = String(date.getFullYear());

        return `${day}/${month}/${year}`;
    }
    
    /**
     * Handle the final letter of a word based on the gender.
     * 
     * @param {"F"|"M"|"O"} gender The person gender.
     * @param {Boolean} [toUpper] Pass **TRUE** to return it in UPPERCASE.
     * @returns {"a"|"A"|"o"|"O"|"e"|"E"} Is *a* for *F*, *o* for *M*, and *e* for *O*.
     */
    function handleGenderCase(gender, toUpper = false)
    {
        /**
         * Will hold the letter based on the gender.
         * 
         * @type {String}
         */
        let letter = "";

        switch(gender)
        {
            case "F":
                letter = "a";
            break;
            case "M":
                letter = "o";
            break;
            case "O":
                letter = "e";
            break;
        }

        return (toUpper ? letter.toUpperCase() : letter);
    }

    /**
     * Mask a person document.
     * 
     * @param {"physical"|"legal"} type The type of the person, to differ the document mask
     * @param {String} document The document number-only string.
     * @returns {String} The masked document string.
     */
    function mask(type, document)
    {
        if(isPhysical(type))
        {
            return `${document.slice(0, 3)}.${document.slice(3, 6)}.${document.slice(6, 9)}-${document.slice(9, 11)}`;
        }

        if(isLegal(type))
        {
            return `${document.slice(0, 2)}.${document.slice(2, 5)}.${document.slice(5, 8)}/${document.slice(8, 12)}-${document.slice(12, 14)}`;
        }
    }
}

// ? Document load event.
document.addEventListener("load", init());