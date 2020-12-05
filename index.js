function init()
{
    /** @type {HTMLDivElement} */
    const menu = document.getElementById("menu");
    /** @type {HTMLDivElement} */
    const database = document.getElementById("database");

    $.ajax({
        url     : "/store/api/database/start.php",
        type    :"GET",
        success : (data, status, xhr) => onSuccess(data, status, xhr),
        error   : (xhr, status, error) => onError(xhr, status, error)
    }); 

    /**
     * 
     * @param {JSON} data 
     * @param {String} status 
     * @param {jqXHR} xhr 
     */
    function onSuccess(data, status, xhr)
    {
        database.remove();
    }
    
    /**
     * 
     * @param {jqXHR} xhr 
     * @param {String} status 
     * @param {JSON} error 
     */
    function onError(xhr, status, error)
    {
        setCardMenus(database, menu);
    }
}

/**
 * 
 * @param {HTMLDivElement} toShow 
 * @param {HTMLDivElement} [toHide] 
 */
function setCardMenus(toShow, toHide = null)
{
    if(toHide !== null)
    {
        toHide.classList.remove(["d-block"]);
        toHide.classList.add(["d-none"]);
    }
    
    toShow.classList.remove(["d-none"]);
    toShow.classList.add(["d-block"]);
}

function setDatabaseFlavorText(display, database = "")
{
    const flavorText = document.getElementById("database_flavor");

    if(!display)
    {
        flavorText.classList.add(["d-none"]);
    }

    flavorText.classList.remove(["d-none"]);
    flavorText.classList.add(["d-block"]);

    let text = "";

    switch(database)
    {
        case "S":
            text = "O Banco de Dados <code>store</code> é uma versão melhorada do banco de dados <code>loja</code>.";
        break;
        case "L":
            text = "O Banco de Dados <code>loja</code> é a primeira versão, já sinalizada como <code>deprecated</code>.";
        break;
    }

    flavorText.innerHTML = text;
}

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
     * 
     * @param {JSON} data 
     * @param {String} status 
     * @param {jqXHR} xhr 
     */
    function onSuccess(data, status, xhr)
    {
        document.getElementById("database").remove();
        setCardMenus(menu);
    }
    
    /**
     * 
     * @param {jqXHR} xhr 
     * @param {String} status 
     * @param {JSON} error 
     */
    function onError(xhr, status, error)
    {
        console.error(xhr, status, error);
    }
}

document.addEventListener("load", init());