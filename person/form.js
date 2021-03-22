/**
 * Compares to see if both forms are valid.
 * 
 * @param {Boolean} personForm  The validation result for the Person Form.
 * @param {Boolean} addressForm The validation result for the Address Form.
 * @returns {Boolean} **TRUE** if the form is valid.
 */
const isValid = (personForm, addressForm) => (personForm === true && addressForm === true);

/**
 * Unmask an input value.
 * 
 * @param {String} value The masked value.
 * @returns {String} The value corrected
 */
const unmask = (value) =>value.replace(/[\(\)\.\-\/\ ]/gm, "");

/**
 * Handle if the feedback of a Form Control will be shown or hided.
 * 
 * @param {Boolean} display ***TRUE** to display and **FALSE** to hide.
 * @param {"name"|"surname"|"document"|"birth_date"|"gender"|"phone"|"cellphone"|"street"|"number"|"district"|"zip_code"|"city"|"state"} id The ID of the element.
 */
function displayControlFeedback(display, id)
{    
    /**
     * The Form Control HTML Element.
     * 
     * @type {HTMLInputElement|HTMLSelectElement}
     */
    const control = document.getElementById(id);
    
    /**
     * The Feedback of the above HTML Element.
     * 
     * @type {HTMLDivElement}
     */
    const feedback = document.getElementById(`${id}_feedback`);

    if(display)
    {
        control.classList.add("is-invalid");

        feedback.classList.add("d-block");
        
        return;
    }

    control.classList.remove("is-invalid");

    feedback.classList.remove("d-block");
}

/**
 * Gather all data from the form and URI encodes it to pass by POST.
 * 
 * @param {String} [id]          Pass if there is an ID to include on the data.
 * @param {?String} [address_id] Pass if there is an Address ID to include on the data.
 * @returns {String} The URI encoded.
 */
function gatherData(id = "", address_id = null)
{
    address_id = (address_id === "null" ? null : address_id);
    
    /**
     * The form controls wich need to be unmasked.
     * 
     * @type {["cellphone", "document", "phone", "zip_code"]}
     */
    const toUnmask = ["cellphone", "document", "phone", "zip_code"];

    /**
     * The data string uncoded.
     * 
     * @type {String}
     */
    let data = `id=${id}${(address_id !== null ? `&address_id=${address_id}` : ``)}`;

    /**
     * A special string to handle the type.
     * 
     * @type {String}
     */
    let type = "";

    getFullForm().forEach((control) => {
        if(control.id == "type_physical" || control.id == "type_legal")
        {
            /**
             * The checkbox for the Physical Person Type.
             * 
             * @type {HTMLInputElement}
             */
            let physical = document.getElementById("type_physical");

            /**
             * The checkbox for the Legal Person Type.
             * 
             * @type {HTMLInputElement}
             */
            let legal = document.getElementById("type_legal");

            if(type == "")
            {
                type += `&type=${(physical.checked ? physical.value : legal.value)}`;
            }

            return;
        }                    

        /**
         * The param value to append to the data.
         * 
         * @type {String}
         */
        let value = ((toUnmask.includes(control.id) || control.id == "surname" &&  isLegal(ENV["type"])) ? unmask(control.value.trim()) : control.value.trim());

        data += `&${control.id}=${value}`;
    });

    data += type;

    return encodeURI(data);
}

/**
 * Validate the form and, if valid, do a Request to save the Person on the Database.
 * When success, then it redirects to the Index, else display the error.
 *  
 * @param {MouseEvent} event The click mouse event.
 */
function savePerson(event)
{
    validateForm()
    .then((validation) => {
        if(isValid(validation[0], validation[1]))
        {            
            $.ajax({
                url     : "/store/api/person/new.php",
                type    : "POST",
                data    : gatherData(),
                success : (data, status, xhr) => goToIndex(),
                error   : (xhr, status, error) => onError(xhr, status, error)
            });           

            /**
             * Print on the console the error.
             * 
             * @param {jqXHR} xhr             jQuery XHR object.
             * @param {String} status         HTTP Status.
             * @param {{reason:String}} error Returns the reason.
             */
            function onError(xhr, status, error)
            {
                console.log(xhr, status, error);
            }
        }
    });
}

/**
 * When there is a Person data, then the form controls values are setted.
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
 * }|{}} person It can be an empty object or a full version for all form.
 */
function setFormData(person)
{
    if(Object.keys(person).length == 0)
    {
        return;
    }

    document.getElementById(`type_${person.type}`).click();

    getFullForm()
    .forEach((control) => {
        if(control.id == "type_physical" || control.id == "type_legal")
        {
            return;
        }

        if(getFullForm(true).includes(control))
        {
            if(person.address[control.id] !== null)
            {
                control.value = formMask(control.id, person.address[control.id]);                
            }

            return;
        }

        if(person[control.id] !== null)
        {
            control.value = formMask(control.id, person[control.id]);             
        }
    });

    ENV["id"] = person.id;
    ENV["address_id"] = person.address.id;

    convertFormButtons();
}

/**
 * At same time validates both forms and return the individuals results.
 * 
 * @returns {Promise<[Boolean, Boolean]>} The first key is for the Person form and the second for the Address.
 */
function validateForm()
{
    return Promise.all([
        validatePersonForm(),
        validateAddressForm()
    ]);    

    /**
     * This is the promise to validate the Address form.
     * 
     * @returns {Promise<Boolean>} The validation of the Address form.
     */
    function validateAddressForm()
    {
        return new Promise((resolve) => {
            /**
             * An array of booleans for each control.
             * 
             * @type {Boolean[]}
             */
            const isValid = [];

            /**
             * An array of HTML Elements for each control
             * 
             * @type {(HTMLInputElement|HTMLSelectElement)[]}
             */
            const addressForm = getFullForm(true);

            if(checkForIncomplete(addressForm))
            {
                return resolve(true);                
            }

            addressForm.forEach((control) => {
                /**
                 * The result of the validation of the control.
                 * 
                 * @type {Boolean}
                 */
                const validation = validateControl(control);

                if(document.getElementById(`${control.id}_feedback`) !== null)
                {
                    displayControlFeedback(!validation, control.id);
                }

                isValid.push(validation);

                if(control.id == "complement" || control.id == "reference")
                {
                    if(control.value == " ")
                    {
                        control.value = control.value.trim();
                    }
                }
            });

            return resolve(!(isValid.includes(false)));
        })

        /**
         * Check for incomplete required values on the Address form.
         * 
         * @param {(HTMLInputElement|HTMLSelectElement)[]} form The Address form.
         * @returns {Boolean} **TRUE** if the some required control is empty.
         */
        function checkForIncomplete(form)
        {
            /**
             * The result.
             * 
             * @type {Boolean}
             */
            let isEmpty = true;
            
            form.forEach((control) => {                
                switch(control.id)
                {
                    case "state":
                        if(isEmpty && control.item(control.selectedIndex).value != "")
                        {
                            isEmpty = false;
                        }
                    break;

                    case "complement":
                    case "reference":
                    return;

                    default:
                        if(isEmpty && control.value.trim() != "")
                        {
                            isEmpty = false;
                        }
                    break;                    
                }               
            });

            if(!isEmpty)
            {
                form.forEach((control) => {
                    if(document.getElementById(`${control.id}_feedback`) !== null)
                    {
                        displayControlFeedback(false, control.id);
                    }
                });
            }

            return isEmpty;
        }

        /**
         * Individually validates a control of the Address form.
         * 
         * @param {HTMLInputElement|HTMLSelectElement} control The control HTML Element.
         * @returns {Boolean} **TRUE** if is valid.
         */
        function validateControl(control)
        {
            switch(control.id)
            {
                case "street":
                case "number":
                case "district":
                case "city":
                return (control.value.trim() != "");

                case "zip_code":
                return (control.value != "" && unmask(control.value).length == 8);

                case "state":
                return (control.item(control.selectedIndex).value != "");
            }
        }
    }

    /**
     * This is the promise to validate the Person form.
     * 
     * @returns {Promise<Boolean>} The validation of the Person form.
     */
    function validatePersonForm()
    {
        return new Promise((resolve) => {
            /**
             * An array of booleans for each control.
             * 
             * @type {Boolean[]}
             */
            const isValid = [];
            
            /**
             * An array of HTML Elements for each control
             * 
             * @type {(HTMLInputElement|HTMLSelectElement)[]}
             */
            const personForm = getFullForm().slice(0, 9);            

            personForm.forEach((control) => {
                /**
                 * The result of the validation of the control.
                 * 
                 * @type {Boolean}
                 */
                const validation = validateControl(control);

                if(document.getElementById(`${control.id}_feedback`) !== null)
                {
                    displayControlFeedback(!validation, control.id);
                }                
                
                isValid.push(validation);
            })

            return resolve(!(isValid.includes(false)));
        });

        /**
         * Individually validates a control of the Person form.
         * 
         * @param {HTMLInputElement|HTMLSelectElement} control The control HTML Element.
         * @returns {Boolean} **TRUE** if is valid.
         */
        function validateControl(control)
        {
            switch(control.id)
            {
                case "name":                    
                case "surname":
                    if(control.id === "surname" && isLegal(ENV["type"]))
                    {
                        return validateDocument("physical", unmask(control.value));
                    }
                return (control.value.trim() != "");

                case "type_physical":
                case "type_legal":
                return true;

                case "document":
                return validateDocument(ENV["type"], unmask(control.value));

                case "birth_date":
                return ((new Date(control.value).getTime()) <= Date.now());

                case "gender":
                return (control.item(control.selectedIndex).value != "");

                case "phone":
                case "cellphone":
                return validatePhones(control);
            }

            /**
             * A custom validation for the CPF or CNPJ document.
             * 
             * @param {"physical"|"legal"} type The type of the Person.
             * @param {String} document The unmasked value of the document.
             * @returns {Boolean} **TRUE** if is valid.
             */
            function validateDocument(type, document)
            {
                /**
                 * The first validator digit.
                 * 
                 * @type {Number}
                 */
                let digitFirst = 0;

                /**
                 * The second validator digit.
                 * 
                 * @type {Number}
                 */
                let digitSecond = 0;

                if(isPhysical(type))
                {
                    /**
                     * The multiplier for the validation.
                     * 
                     * @type {Number}
                     */
                    let multiplier = 0;
                    
                    if(([
                        "",
                        "00000000000",
                        "11111111111",
                        "22222222222",
                        "33333333333",
                        "44444444444",
                        "55555555555",
                        "66666666666",
                        "77777777777",
                        "88888888888",
                        "99999999999"
                    ]).includes(document))
                    {
                        return false;
                    }
                    
                    multiplier = 10;

                    for(let digit = 0; (document.length - 2) > digit; digit++)
                    {
                        digitFirst += (document.charAt(digit) * multiplier); 
                        
                        multiplier--;
                    } 
                    
                    digitFirst = ((digitFirst * 10) % 11);
                    
                    if(digitFirst == 10)
                    {
                        digitFirst = 0; 
                    }
                    
                    if(digitFirst != document.charAt(9))
                    {
                        return false; 
                    } 
                    
                    mutiplier = 11;

                    for(let digit = 0; (document.length - 1) > digit; digit++)
                    {
                        digitSecond += (document.charAt(digit) * multiplier); 
                        
                        mutiplier--;
                    } 
                    
                    digitSecond = ((digitSecond * 10) % 11);
                    
                    if(digitSecond == 10)
                    {
                        digitSecond = 0; 
                    }
                    
                    if(digitSecond != document.charAt(10))
                    {
                        return false; 
                    }
                    
                    return true; 
                }

                if(isLegal(type))
                {
                    /**
                     * The final multiplier for the validation.
                     * 
                     * @type {Number}
                     */
                    let multiplier = 0;

                    /**
                     * The first multiplier for the validation.
                     * 
                     * @type {Number}
                     */
                    let multiplierFirst = 0;

                    /**
                     * The second multiplier for the validation.
                     * 
                     * @type {Number}
                     */                    
                    let multiplierSecond = 0;
                    
                    if(([
                        "",
                        "00000000000000",
                        "11111111111111",
                        "22222222222222",
                        "33333333333333",
                        "44444444444444",
                        "55555555555555",
                        "66666666666666",
                        "77777777777777",
                        "88888888888888",
                        "99999999999999"
                    ]).includes(document))
                    {
                        console.log("enotru");
                        return false;
                    }
                    
                    multiplierFirst  = 5;
                    multiplierSecond = 13;

                    for(let digit = 0; (document.length - 2) > digit; digit++)
                    {
                        multiplier = (multiplierFirst >= 2 ? multiplierFirst : multiplierSecond);

                        digitFirst += (document.charAt(digit) * multiplier);

                        multiplierFirst--;
                        multiplierSecond--;
                    } 
                    
                    digitFirst = (digitFirst % 11);
                    
                    digitFirst = (digitFirst < 2 ? 0 : (11 - digitFirst));
                                        
                    if(digitFirst != document.charAt(12))
                    {  
                        return false; 
                    } 
                    
                    multiplierFirst  = 6;
                    multiplierSecond = 14;

                    for(let digit = 0; (document.length - 1) > digit; digit++)
                    { 
                        multiplier = (multiplierFirst >= 2 ? multiplierFirst : multiplierSecond);

                        digitSecond += (document.charAt(digit) * multiplier);

                        multiplierFirst--;
                        multiplierSecond--;
                    }
                    
                    digitSecond = (digitSecond % 11); 

                    digitSecond = (digitSecond < 2 ? 0 : (11 - digitSecond));
                      
                    if(digitSecond != document.charAt(13))
                    {   
                        return false; 
                    }  
                    
                    return true; 
                }

                return false;
            }

            /**
             * Validate the phones length and if both are empty.
             * 
             * @param {HTMLInputElement} control The HTML Element of the phone.
             * @returns {Boolean} **TRUE** for a valid result.
             */
            function validatePhones(control)
            {
                /**
                 * The another control.
                 * If the control is for `phone` then it's the `cellphone`, and so.
                 * 
                 * @type {HTMLInputElement}
                 */
                const another = (control.id == "phone" ? document.getElementById("cellphone") : document.getElementById("phone"));

                /**
                 * The length according with the control.
                 * 
                 * @type {10|11}
                 */
                const length = (control.id == "phone" ? 10 : 11);

                /**
                 * The length according with the another control.
                 * 
                 * @type {11|10}
                 */
                const anotherLength = (control.id == "phone" ? 11 : 10);

                return (((control.value.trim() != "" && unmask(control.value).length == length) || (control.value.trim() == "" && another.value.trim() != "" && unmask(another.value).length == anotherLength)));
            }
        }
    }
}