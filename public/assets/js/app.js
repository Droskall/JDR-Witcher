// menu : responsive
const menuSpan = document.querySelector('span.menu');
const menuDiv = document.querySelector('div.menu');

let a = 0;

menuSpan.addEventListener('click', () => {
    if (a === 0) {
        menuDiv.style.display = 'block';
        a++
    } else if (a === 1) {
        menuDiv.style.display = 'none';
        a--
    }
})

// close php error message
const close = document.querySelector('#close');
const errorDiv = document.querySelector('div.error');

if (close) {
    close.addEventListener('click', () => {
        errorDiv.remove();
        close.remove();
    })
}

 //bubbles effect
const help = document.querySelector('#band div:nth-child(1)');
const resource = document.querySelector('#band div:nth-child(2)');
const utils = document.querySelector('#band div:nth-child(3)');
const utile = document.querySelector('#band div:nth-child(4)');

if (help) {
    if (window.innerWidth > 550) {
        document.body.style.overflowX = 'hidden';
        document.body.style.background = 'white';
    }

    animation(help, 'c=category&a=get-category&name=help&type');
    animation(resource, 'c=category&a=get-category&name=resource&type');
    animation(utils, 'c=category&a=get-category&name=utils&type');
    animation(utile, 'c=toolbox');
}

function animation(div, url) {
    div.addEventListener('click', function () {
        div.classList.remove('floating_bubble');
        div.classList.remove('floating-reverse_bubble');
        div.classList.add('loader');
        div.style.zIndex = '10';
        setTimeout(function () {
            window.location.href = '/index.php?' + url;
        }, 1000)
    })
}

// FormConnexion/Inscription verif

let container = document.getElementById('contains');
container.style.position = "relative";

//Login form
let email = document.getElementById('email');
let password = document.getElementById('pswd');
let btnConnexion = document.getElementById('buttonC');

//Registration Form
let pseudoI = document.getElementById('pseudoInscript');
let emailI = document.getElementById('emailInscript');
let passwordI = document.getElementById('passwordInscript');
let passwordConfirmI = document.getElementById('passwordConfirmInscript');
let btnInscriptionI = document.getElementById('buttonValidateI');

let pattern = /^[^ ]+@[^ ]+.[a-z]{2,3}$/;

/**
 * Event when the login button is clicked and verification of the login form fields
 */
if (btnConnexion) {
    btnConnexion.addEventListener("click", function(e){
        if(email.value === "" || password.value === ""){
            e.preventDefault();
            message("Merci de remplir les champs requis", container);
        }
        else if(email.value.length < 8 || email.value.length > 100 || password.value.length < 8 ||
            password.value.length > 255){
            e.preventDefault();
            message("Votre email ou mot de passe est incorrect", container);
        }
    });
}


/**
 * Event when clicking on the registration button and verification of the fields of the registration form
 */
if (btnInscriptionI) {
    btnInscriptionI.addEventListener('click', function (e){
        if(pseudoI.value === "" || passwordI.value === "" || passwordConfirmI.value === "" ||
            emailI.value === ""){
            e.preventDefault();
            message("Merci de remplir les champs requis !", container);
        }
        else{
            if(passwordI.value !== passwordConfirmI.value){
                e.preventDefault();
                message("Les mots de passe ne correspondent pas !", container);
            }
            else if(!emailI.value.match(pattern)){
                e.preventDefault();
                message("Merci de renseigner une adresse e-mail valide !", container);
            }
            else if (pseudoI.value.length < 5 || pseudoI.value.length > 100 || passwordI.value.length < 8
                || passwordI.value.length > 255 || passwordConfirmI.value.length < 8 ||
                passwordConfirmI.value.length > 255){
                e.preventDefault();
                message("Votre pseudo ou votre mot de passe ne comporte pas le nombre de caractères requis !", container);
            }
        }
    });
}


/*
 * basic verifications for change_email_username form
 */
const changeEmailUsername = document.querySelector('#change_email_username input[type=submit]');

if (changeEmailUsername) {
    const email = document.querySelector('#change_email_username input[type=email]');
    const username = document.querySelector('#change_email_username input[type=text]');
    const password = document.querySelector('#change_email_username input[type=password]');

    changeEmailUsername.addEventListener("click", function(e) {
        if(email.value === "" || password.value === "" || username.value === "") {
            e.preventDefault();
            message("Merci de remplir les champs requis", container);

        } else {
            if(email.value.length < 8 || email.value.length > 100 || password.value.length < 8 ||
                password.value.length > 255) {
                e.preventDefault();
                message("Votre email ou mot de passe est incorrect", container);
            }

            if (username.value.length < 5 || username.value.length > 100) {
                e.preventDefault();
                message("Le nom d'utilisateur doit faire entre 5 et 100 caractères", container);
            }

            if(!email.value.match(pattern)){
                e.preventDefault();
                message("Merci de renseigner une adresse e-mail valide !", container);
            }
        }
    });
}

/*
 * basic verifications for change_password form
 */
const changePassword = document.querySelector('#change_password input[type=submit]');

if (changePassword) {
    const oldPassword = document.querySelector('#change_password input[name=password]');
    const newPassword = document.querySelector('#change_password input[name=password]');
    const passwordRepeat = document.querySelector('#change_password input[name=passwordRepeat]');

    changePassword.addEventListener('click', function(e) {
        if (oldPassword.value.length === '' || newPassword.value.length === '') {
            e.preventDefault();
            message("Merci de remplir les champs requis", container);

        } else {
            if (newPassword.value.length < 8 || newPassword.value.length > 255) {
                e.preventDefault();
                message("Le mot de passe doit faire au moins 8 caractères", container);
            }

            if(newPassword.value !== passwordRepeat.value){
                e.preventDefault();
                message("Les mots de passe ne correspondent pas !", container);
            }
        }
    })
}

// verif activity form
let addActBtn = document.getElementById('addActBtn');
const title = document.querySelector('#add-activity input[name=title]');
const text = document.querySelector('#add-activity textarea');
const place = document.querySelector('#add-activity input[name=location]');
const date = document.querySelector('#schedules');

if(addActBtn){
    addActBtn.addEventListener('click', function (e){
        if(title.value === ""){
            e.preventDefault();
            message("Merci de remplir le champ titre", container);
        }
        else if (text.value === ""){
            e.preventDefault();
            message("Merci de remplir le champ description", container);
        }
        else if(place.value === ""){
            e.preventDefault();
            message("Merci de remplir le champ lieu", container);
        }
        else if(date.value === ""){
            e.preventDefault();
            message("Merci de remplir le champ date et horaires", container);
        }
    })
}

let linkBtn = document.getElementById('linkBtn');
let addLink = document.getElementById('add-link');
addLink.style.position = "relative";
const linkTitle = document.querySelector('#add-link input[type=text]');
const addUrl = document.querySelector('#add-link input[type=url]');
if(linkBtn){
    linkBtn.addEventListener('click', function (e){
        if(linkTitle.value === ""){
            e.preventDefault();
            message("Merci de remplir le champ titre", addLink);
        }
        if(addUrl.value === ""){
            e.preventDefault();
            message("Merci de remplir le champ lien", addLink);
        }
    })
}

/**
 * Function which allows you to create error or success messages!
 * @param message = Message content to display
 * @param type = success or error
 * @param target
 */

function message(message, target, type ="error"){
    let div = document.createElement("div");
    let span = document.createElement("span");
    span.innerHTML = message;
    div.append(span);
    div.className = type;
    div.id = "errorOrSuccess";
    target.prepend(div);
    slideUp(div.id, type)
}

//We add the slideUp animation to the div element that contains the message.
function slideUp(id, type){
    let timeout = setTimeout(function (){
        let div = document.getElementById(id);
        div.classList = (type + " remove");
        deleteMessage("errorOrSuccess");
        clearTimeout(timeout);
    }, 4500);
}

//Function that deletes the message after 4 seconds
function deleteMessage(id){
    let timeout = setTimeout(function (){
        let div = document.getElementById(id);
        div.remove();
        clearTimeout(timeout);
    }, 400);
}
