/**
 * Key mask for Cellphone.
 * 
 * @param {KeyboardEvent} event The event of the keyboard.
 */
function cellphoneMask(event)
{
    /**
     * Currently Cellphone.
     * 
     * @type {HTMLInputElement}
     */
    const cellphone = document.getElementById("cellphone");

    if(event.keyCode != 8 && event.keyCode != 46)
    {
        if(cellphone.value.length === 0)
        {
            cellphone.value += "("
        }
        else if(cellphone.value.length === 3)
        {
            cellphone.value += ") "
        }
        else if(cellphone.value.length === 10)
        {
            cellphone.value += "-";
        }
    }
}

/**
 * Key mask for CNPJ.
 * 
 * @param {KeyboardEvent} event The event of the keyboard.
 */
function cnpjMask(event)
{
    /**
     * Currently CNPJ.
     * 
     * @type {HTMLInputElement}
     */
    const cnpj = document.getElementById("document");

    if(event.keyCode != 8 && event.keyCode != 46)
    {
        if(cnpj.value.length === 2 || cnpj.value.length === 6)
        {
            cnpj.value += ".";
        }
        else if(cnpj.value.length === 10)
        {
            cnpj.value += "/";
        }
        else if(cnpj.value.length === 15)
        {
            cnpj.value += "-";
        }
    }
}

/**
 * Key mask for the CPF.
 * 
 * @param {KeyboardEvent} event The event of the keyboard.
 */
function cpfMask(event)
{
    /**
     * Currently CPF.
     * 
     * @type {HTMLInputElement}
     */
    const cpf = document.getElementById("document");

    if(event.keyCode != 8 && event.keyCode != 46)
    {
        if(cpf.value.length === 3 || cpf.value.length === 7)
        {
            cpf.value += ".";
        }
        else if(cpf.value.length === 11)
        {
            cpf.value += "-";
        }
    }
}

/**
 * Digit filter to match only numeric characters.
 * 
 * @param {InputEvent} event The event of the input.
 */
function documentNumberDigits(event)
{    
    /**
     * Get the actual digit of the input.
     * 
     * @param {String} input The input value.
     * @returns {String} The digit.
     */
    const getDigit = (input) => input.charAt((input.length - 1));

    /**
     * Remove the current digit of the value.
     * 
     * @param {String} input The input value.
     * @returns {String} The value without the digit.
     */
    const removeDigit = (input) => input.substr(0, (input.length - 1));

    /**
     * The target input.
     * 
     * @type {HTMLInputElement}
     */
    const input = document.getElementById(event.target.id);

    if(isNaN(Number(getDigit(input.value))))    
    {
        input.value = removeDigit(input.value);
    }    
}

/**
 * Digit filter to match only letters and accents.
 * 
 * @param {InputEvent} event The event of the input.
 */
function documentTextDigits(event)
{
    /**
     * Get the actual digit of the input.
     * 
     * @param {String} input The input value.
     * @returns {String} The digit.
     */
    const getDigit = (input) => input.charAt((input.length - 1));

    /**
     * Check if the predecessor digit is a space, making it doubled.
     * 
     * @param {String} input The input value.
     * @returns {Boolean} **TRUE** if it's a space.
     */
    const isDoubleSpace = (input) => (input.charAt((input.length - 2)) === " " && event.data === " ");

    /**
     * Remove the current digit of the value.
     * 
     * @param {String} input The input value.
     * @returns {String} The value without the digit.
     */
    const removeDigit = (input) => input.substr(0, (input.length - 1));

    /**
     * The target input.
     * 
     * @type {HTMLInputElement}
     */
    const input = document.getElementById(event.target.id);

    /**
     * The RegExp. It includes numbers if is an address input.
     * 
     * @type {RegExp}
     */
    const regex = (!(getFullForm(true).includes(input)) ? /[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ_ ]/gm : /[a-zA-ZÀ-ÖÙ-öù-ÿĀ-žḀ-ỿ0-9_ ]/gm);

    if(!(regex).test(getDigit(input.value)) || isDoubleSpace(input.value))    
    {
        input.value = removeDigit(input.value);
    }    
}

/**
 * Get an array with all the form controls.
 * 
 * @param {Boolean} [address] Pass *TRUE* for getting only the controls of the address form.
 * @returns {(HTMLInputElement|HTMLSelectElement)[]} The respective array.
 */
function getFullForm(address = false)
{
    const form = [
        document.getElementById("name"),
        document.getElementById("surname"),
        document.getElementById("type_physical"),
        document.getElementById("type_legal"),
        document.getElementById("document"),
        document.getElementById("birth_date"),
        document.getElementById("gender"),
        document.getElementById("phone"),
        document.getElementById("cellphone"),
        document.getElementById("street"),
        document.getElementById("number"),
        document.getElementById("district"),
        document.getElementById("zip_code"),
        document.getElementById("complement"),
        document.getElementById("reference"),
        document.getElementById("city"),
        document.getElementById("state")
    ];

    return (!address ? form : form.slice(9));
}

/**
 * Handle when the type of person is changed.
 * 
 * @param {Event} event 
 */
function handleTypeChange(event)
{
    /**
     * Label for `name` input.
     * 
     * @type {"Nome"|"Razão Social"}
     */
    let nameLabel;

    /**
     * Placeholder for `name` input.
     * 
     * @type {"Nome"|"Razão Social"}
     */
    let namePlaceholder;

    /**
     * Label for `surname` input.
     * 
     * @type {"Sobrenome"|"CPF"}
     */
    let surnameLabel;

    /**
     * Placeholder for `surname` input.
     * 
     * @type {"Sobrenome"|"___.___.___-__"}
     */
    let surnamePlaceholder;
    
    /**
     * Digits filter for `surname` input.
     * 
     * @type {documentTextDigits|documentNumberDigits}
     */
    let surnameDigits;

    /**
     * Max Length for `surname` input.
     * 
     * @type {""|"11"}
     */
    let surnameMaxLength;

    /**
     * Label for `document` input.
     * 
     * @type {"CPF"|"CNPJ"}
     */
    let documentLabel;

    /**
     * Placeholder for `document` input.
     * 
     * @type {"___.___.___-__"|"__.___.___/____-__"}
     */
    let documentPlaceholder;

    /**
     * Key mask for `document` input.
     * 
     * @type {cpfMask|cnpjMask}
     */
    let documentMask;

    /**
     * Max Length for `document` input.
     * 
     * @type {"14"|"18"}
     */
    let documentMaxLength;

    /**
     * Label for `birth_date` input.
     * 
     * @type {"Data de Nascimento"|"Data de Abertura"}
     */
    let birthDateLabel;

    /**
     * The type of the person.
     * 
     * @type {"physical"|"legal"}
     */
    const type = event.target.value;
    
    ENV["type"] = type;

    switch(type)
    {
        case "physical":
            nameLabel           = "Nome";
            namePlaceholder     = "Nome";
            surnameLabel        = "Sobrenome";
            surnamePlaceholder  = "Sobrenome";
            surnameDigits       = documentTextDigits;
            surnameMaxLength    = "";
            documentLabel       = "CPF";
            documentPlaceholder = "___.___.___-__";
            documentMask        = cpfMask;
            documentMaxLength   = "14";
            birthDateLabel      = "Data de Nascimento";
        break;

        case "legal":
            nameLabel           = "Razão Social";
            namePlaceholder     = "Razão Social";
            surnameLabel        = "CPF";
            surnamePlaceholder  = "___.___.___-__";
            surnameDigits       = documentNumberDigits;
            surnameMaxLength    = "11";
            documentLabel       = "CNPJ";
            documentPlaceholder = "__.___.___/____-__";
            documentMask        = cnpjMask;
            documentMaxLength   = "18";
            birthDateLabel      = "Data de Abertura";
        break;
    }

    /**
     * The `name` form input.
     * 
     * @type {HTMLInputElement}
     */
    const name = document.getElementById("name");
    
    /**
     * The `surname` form input.
     * 
     * @type {HTMLInputElement}
     */
    const surname = document.getElementById("surname");

    /**
     * The `document` form input.
     * 
     * @type {HTMLInputElement}
     */
    const doc = document.getElementById("document");

    /**
     * The `birth_date` form input.
     * 
     * @type {HTMLInputElement}
     */
    const birthDate = document.getElementById("birth_date");

    /**
     * The `gender` form input.
     * 
     * @type {HTMLSelectElement}
     */
    const gender = document.getElementById("gender");

    /**
     * The `phone` form input.
     * 
     * @type {HTMLInputElement}
     */
    const phone = document.getElementById("phone");

    /**
     * The `cellphone` form input.
     * 
     * @type {HTMLInputElement}
     */
    const cellphone = document.getElementById("cellphone");

    labelText(name, nameLabel);
    placeholder(name, namePlaceholder);

    labelText(surname, surnameLabel);
    placeholder(surname, surnamePlaceholder);
    handleMaxLength(surname, surnameMaxLength);
    removeDigits(surname);
    eventListener(surname, "input", surnameDigits);

    labelText(doc, documentLabel);
    placeholder(doc, documentPlaceholder);
    handleMaxLength(doc, documentMaxLength);
    removeMasks(doc);
    eventListener(doc, "keydown", documentMask);

    labelText(birthDate, birthDateLabel);

    handleGender(gender, type);

    clear(name);
    clear(surname);
    clear(doc);
    clear(birthDate);
    clear(phone);
    clear(cellphone);
    
    displayControlFeedback(false, name.id);
    displayControlFeedback(false, surname.id);
    displayControlFeedback(false, doc.id);
    displayControlFeedback(false, birthDate.id);
    displayControlFeedback(false, gender.id);
    displayControlFeedback(false, phone.id);
    displayControlFeedback(false, cellphone.id);

    /**
     * Completly clear all the values from an input.
     * 
     * @param {HTMLInputElement} input An input from the form.
     */
    function clear(input)
    {
        input.value = "";
    }

    /**
     * Add a determined Event to an input.
     * 
     * @param {HTMLInputElement} input The Input Element.
     * @param {String} type            The type of the event.
     * @param {Function} listener      The listener for the event.
     */
    function eventListener(input, type, listener)
    {
        input.addEventListener(type, listener);
    }

    /**
     * Exclusive handler for the "Gênero" form input.
     * 
     * @param {HTMLSelectElement} gender "Gênero" form input.
     * @param {"physical"|"legal"} type The selected type.
     */
    function handleGender(gender, type)
    {
        /**
         * `"O"` value option.
         * 
         * @type {HTMLOptionElement}
         */
        const optionO = gender.lastElementChild;
        
        if(type === "legal")
        {          
            optionO.innerText = "Não aplicável";
            optionO.selected = true;

            gender.disabled = true;

            return;
        }

        optionO.innerText = "Outro";
        gender.disabled = false;

        for(let option of gender.children)
        {
            option.selected = false;
        }
    }

    /**
     * Handle if the given input will have a max length.
     * 
     * @param {HTMLInputElement} input An input from the form.
     * @param {String} maxLength       A string with a valid number, or empty to remove.
     */
    function handleMaxLength(input, maxLength)
    {
        if(maxLength.length > 0)
        {
            input.setAttribute("maxlength", maxLength);

            return;
        }

        input.removeAttribute("maxlength");
    }

    /**
     * Set the text of the unique label of the input.
     * 
     * @param {HTMLInputElement} input An input from the form.
     * @param {String} text The label text.
     */
    function labelText(input, text)
    {
        /**
         * Getter for the label.
         * 
         * @param {HTMLInputElement} input An input from the form.
         * @returns {HTMLLabelElement} The Label Element.
         */
        const label = (input) => input.labels.item(0);

        label(input).innerText = text;        
    }

    /**
     * Set the text of the input placeholder.
     * 
     * @param {HTMLInputElement} input An input from the form.
     * @param {String} text            The placeholder text.
     */
    function placeholder(input, text)
    {
        input.placeholder = text;
    }

    /**
     * Remove all Digit filter masks from an input.
     * 
     * @param {HTMLInputElement} input An input from the form.
     */
    function removeDigits(input)
    {
        input.removeEventListener("input", documentNumberDigits);
        input.removeEventListener("input", documentTextDigits);
    }

    /**
     * Remove all CPF and CNPJ masks from an input.
     * 
     * @param {HTMLInputElement} input An input from the form.
     */
    function removeMasks(input)
    {
        input.removeEventListener("keydown", cpfMask);
        input.removeEventListener("keydown", cnpjMask);
    }
}

/**
 * Initialization event.
 */
function init()
{
    /**
     * This relates the form controls wich must have an initial Mask.
     * 
     * @type {{"document":cpfMask, "phone":phoneMask, "cellphone":cellphoneMask, "zip_code":zipCodeMask}}
     */
    const keydownMasks = {
        "document"  : cpfMask,
        "phone"     : phoneMask,
        "cellphone" : cellphoneMask,
        "zip_code"  : zipCodeMask
    };

    /**
     * This array holds the form controls wich does not require any Mask or Digit Filter.
     * 
     * @type {["type_physical", "type_legal", "birth_date", "number"]}
     */
    const noControls = [
        "type_physical",
        "type_legal",
        "birth_date",
        "number"
    ];

    getFullForm()
    .forEach((control) => {
        /**
         * The ID of the control.
         * 
         * @type {String}
         */
        const ID = control.id;

        if(noControls.includes(ID))
        {
            return;
        }

        if(Object.keys(keydownMasks).includes(ID))
        {
            control.addEventListener("input", documentNumberDigits);

            control.addEventListener("keydown", keydownMasks[ID]);

            return;
        }

        control.addEventListener("input", documentTextDigits);
    });    

    setActualDatabase();

    // ! As it begin selected, defines it.
    ENV["type"] = "physical";

    getDataToUpdate()
    .then((person) => setFormData(person));
}

/**
 * Key mask for Phone.
 * 
 * @param {KeyboardEvent} event The event of the keyboard.
 */
function phoneMask(event)
{
    /**
     * Currently Phone.
     * 
     * @type {HTMLInputElement}
     */
    const phone = document.getElementById("phone");

    if(event.keyCode != 8 && event.keyCode != 46)
    {
        if(phone.value.length === 0)
        {
            phone.value += "("
        }
        else if(phone.value.length === 3)
        {
            phone.value += ") "
        }
        else if(phone.value.length === 9)
        {
            phone.value += "-";
        }
    }
}

/**
 * Check if there is no Database on the ENV to
 * Execute a Request for it in this case.
 */
function setActualDatabase()
{
    if(ENV["database"] === null)
    {
        getActualDatabase()
        .then((success) => { ENV["database"] = success["data"]["database"]; })
        .catch((rejection) => { goToIndex(); });
    }
}

/**
 * Key mask for CEP.
 * 
 * @param {KeyboardEvent} event The event of the keyboard.
 */
function zipCodeMask(event)
{
    /**
     * Currently CEP.
     * 
     * @type {HTMLInputElement}
     */
    const zipCode = document.getElementById("zip_code");

    if(event.keyCode != 8 && event.keyCode != 46)
    {
        if(zipCode.value.length === 5)
        {
            zipCode.value += "-"
        }
    }
}

// ? Document load event.
document.addEventListener("load", init());