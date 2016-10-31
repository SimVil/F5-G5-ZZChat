(function main(){
    // Get main variables to be listened
    var login = document.getElementById("login");
    var pass = document.getElementById("password");
    var sign = document.getElementById("submit");

    // listeners on variables
    login.addEventListener("input", function(){loginDynListen(login);}, false);
    pass.addEventListener("input", function(){passDynListen(pass);}, false);
    sign.addEventListener("mouseenter", function(){sendRequest(sign, login, pass);}, false);


})()
