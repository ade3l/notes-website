const form = document.querySelector("#loginForm")
const email = form.email;
const password = form.password;

form.onsubmit = function(event) {
    event.preventDefault();
    if(email.value==""){
        email.setCustomValidity("Email is required");
        email.reportValidity();
    }
    else if(password.value==""){
        console.log("hwllo");       
        password.setCustomValidity("Password is required");
        password.reportValidity();
    }
    //Check password for at least one number and one uppercase letter and one special character
    else if(!password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/)){
        console.log("object");
        password.setCustomValidity("Password must contain at least one number, one uppercase letter, one special character, and be between 8 and 15 characters long");
        password.reportValidity();
    }

    //Check if email is valid using regex
    return false;
}

//If a character is entered into the email field, remove the error message
email.onkeydown = ()=> {
    email.setCustomValidity("");
    email.reportValidity();
}
password.onkeydown = function(event) {
    password.setCustomValidity("");
    password.reportValidity();
}

//When the show password button is clicked, show the password
const showPassword = form.password_show;
showPassword.onclick = function(event) {
    if(showPassword.checked){
        password.type = "text";
    }
    else{
        password.type = "password";
    }
}
