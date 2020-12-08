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
        window.location.replace("/store/");
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

function printPersonList()
{
    const persons = document.getElementById("persons");

    const item = document.createElement("a");
    item.href = "#";
    item.classList.add("list-group-item", "list-group-item-action", "flex-column", "align-items-start");

    const title = document.createElement("div");
    title.classList.add("d-flex", "w-100", "justify-content-between");

    const name = document.createElement("h5");
    name.classList.add("mb-1");
    name.innerText = `List group item heading`;

    const date = document.createElement("small");
    date.innerHTML = `3 days ago`;

    title.appendChild(name);
    title.appendChild(name);

    item.appendChild(title);

    const text = document.createElement("p");
    text.classList.add("mb-1");
    text.innerText = `Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.`;

    const subtext = document.createElement("small");
    subtext.innerText = `Donec id elit non mi porta.`;

    item.appendChild(text);
    item.appendChild(subtext);

    persons.appendChild(item);
}

// ? Document load event.
document.addEventListener("load", init());