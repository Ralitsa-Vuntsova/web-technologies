function validate(){
    var username = document.getElementById("username").value;
    var name = document.getElementById("name").value;
    var familyName = document.getElementById("family-name").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var postalCode = document.getElementById("postal-code").value;
    var error = document.getElementById("error");
    var success = document.getElementById("success");

    // validation for username
    if(!/^.{3,10}$/.test(username)){
        error.innerHTML += "Невалидно потребителско име!";
    }

    // validation for name
    if(!/^.{1,50}$/.test(name)){
        error.innerHTML += "Невалидно име!";
    }

    // validation for familyName
    if(!/^.{1,50}$/.test(familyName)){
        error.innerHTML += "Невалидно фамилно име!";
    }

    // validation for email
    if(!/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/.test(email)){
        error.innerHTML += "Невалиден e-mail!";
    }

    // validation for password
    if(!/^[a-zA-Z0-9]{6,10}$/.test(password)){
        error.innerHTML += "Невалидна парола!";
    }

    // validation for postal-code
    if(!/^([0-9]{4}|[0-9]{5}-[0-9]{4})$/.test(postalCode)){
        error.innerHTML += "Невалиден пощенски код!";
    }

    var userData = {
        username, name, familyName, email, password, postalCode, error, success
    };

    // async request
    if(error.innerHTML.length == 0){
        var url = 'http://jsonplaceholder.typicode.com/users';
        asyncRequest(url, userData);
    } else{
        error.style.display = "block";
    }
}

function asyncRequest(url, userData){
    fetch(url)
    .then((response) => {
        return response.json();
    })
    .then((data) => {
        isUserRegistered(data, userData);
    });
}

function isUserRegistered(data, userData){
    for(var i = 0; i < data.length; i++){
        if(data[i].username === userData.username){
            userData.error.innerHTML += "Потребител с такова потребителско име вече съществува!";
            return;
        }
    }
    
    if(userData.error.innerHTML.length == 0){
        userData.success.innerHTML = "Успешна регистрация!";
        userData.success.style.display = "block";
    } else{
        userData.error.style.display = "block";
    }
}