/**
 * Constant to act as an environment.
 * 
 * @type {{database:"store"|"loja"|null, user:Number|null, type:"physical"|"legal"|null}}
 */
const ENV = {
    database : null,
    user     : null,
    type     : null
};

/**
 * Get the Actual Database on the API.
 * 
 * @throws {xhr:jqXHR, status:String, error:String} The rejection of the Promise.
 * @returns {Promise<{data:{database:String}, status:String, xhr:jqXHR}>} The Promise with the database or the error if there is no one.
 */
function getActualDatabase()
{
    return new Promise((resolve, reject) => {
        $.ajax({
            url     : "/store/api/database/start.php",
            type    : "GET",
            success : (data, status, xhr) => resolve({data: data, status: status, xhr: xhr}),
            error   : (xhr, status, error) => reject({xhr: xhr, status: status, error: error})
        });
    })
}

/**
 * Redirect to the Index page.
 */
function goToIndex()
{
    window.location.replace("/store/");
}

/**
 * Compare if the given Person type matches the Legal Person type.
 * 
 * @param {String} type The person type.
 * @returns {Boolean} **TRUE** if is a Legal Person.
 */
function isLegal(type)
{
    return (type === "legal");
}

/**
 * Compare if the given Person type matches the Physical Person type.
 * 
 * @param {String} type The person type.
 * @returns {Boolean} **TRUE** if is a Physical Person.
 */
function isPhysical(type)
{
    return (type === "physical");
}