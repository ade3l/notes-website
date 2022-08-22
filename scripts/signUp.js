const form = document.querySelector("form");
const email = form.email;
const password = form.password;
const password_conf = form.password_conf;
const showPassword = form.password_show;
form.onsubmit = function(event) {
    event.preventDefault();
    if(email.value==""){
        email.setCustomValidity("Email is required");
        email.reportValidity();
    }
    else if(password.value==""){
        password.setCustomValidity("Password is required");
        password.reportValidity();
    }
    //check if password is at least 8 characters long
    else if(!password.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/)){
        console.log("object");
        password.setCustomValidity("Password must contain at least one number, one uppercase letter, one special character, and be between 8 and 15 characters long");
        password.reportValidity();
    }

    else if(password_conf.value==""){
        password_conf.setCustomValidity("Password is required");
        password_conf.reportValidity();
    }

    else if(password.value!=password_conf.value){
        password_conf.setCustomValidity("Passwords do not match");
        password_conf.reportValidity();
    }
}

email.onkeydown = ()=> {
    email.setCustomValidity("");
    email.reportValidity();
}
password.onkeydown = function(event) {
    password.setCustomValidity("");
    password.reportValidity();
}
password_conf.onkeydown = function(event) {
    password_conf.setCustomValidity("");
    password_conf.reportValidity();
}

//when the show password button is clicked, show the password
showPassword.onclick = function(event) {
    if(showPassword.checked){
        password.type = "text";
        password_conf.type = "text";
    }
    else{
        password.type = "password";
        password_conf.type = "password";
    }
}