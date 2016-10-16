
/* -----------------------------------------------------------------------------
Javascript file : aims to achieve some client-side dynamic
validation before sending request for PHP server-side operations

*/

(function main(){

    // Get main variables to be listened
    var login = document.getElementById("login");
    var pass = document.getElementById("password");
    var sign = document.getElementById("signin");

    // listeners on variables
    login.addEventListener("input", function(){loginDynListen(login);}, false);
    pass.addEventListener("input", function(){passDynListen(pass);}, false);
    sign.addEventListener("mouseenter", function(){sendRequest(sign, login, pass);}, false);



    // -------------------------------------------------------------------------
    // functions for listening inputs



    /* loginDynListen  ---------------------------------------------------------
    /    Stands for checking login validations. Return testing value (true or
    /  false). A given login can contain letters (lower/uppercase), numbers and
    /  "-".
    /
    /  Parameters
    /    - elt : login to be verified.
    / --------------- */
    function loginDynListen(elt){
        var regex = new RegExp("^[a-zA-Z0-9\\-]{0,}$")
        elt.className = "valid";

        if (!regex.test(elt.value)) {
             if(elt.value.length != 0){
                 elt.className = "invalid";
             }

             return false;

        } else {
            return true;

        }
    };



    /* passDynListen -----------------------------------------------------------
    /    Check form constraints on a given password. Return testing value (true
    /  or false). A password must have at least one lowercase letter, an
    /  uppercase one, and a number. It must be at least 8 char long.
    /
    /  Parameters :
    /    - elt : password to be checked.
    / -------------- */
    function passDynListen(elt){
        var regexNb = new RegExp("[0-9]{1,}");
        var regexMin = new RegExp("[a-z]{1,}");
        var regexMaj = new RegExp("[A-Z]{1,}");
        var tmp = elt.value;

        elt.className = "valid";
        var constraints = regexNb.test(tmp) && regexMin.test(tmp) &&
            regexMaj.test(tmp);

        if ((tmp.length >= 8) && (constraints)) {
            return true;

        } else {
            if(tmp.length != 0){
               elt.className = "invalid";
            }

            return false;

        }

    };




    /* sendRequest -------------------------------------------------------------
    /    Allows or not to click on the "Sign in" button, according to login and
    /  password values. The button may not be clickable until datas are correct.
    /
    /  Parameters :
    /    - elt : button.
    /    - login : login to be checked.
    /    - pass : password to be checked.
    / -------------- */
    function sendRequest(elt, login, pass){
      elt.disabled = true;

      if (passDynListen(pass) && loginDynListen(login)) {
        elt.disabled = false;
        return true;
      } else {

      }

      return false;

    };


})()
