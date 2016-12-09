/* -----------------------------------------------------------------------------
Javascript file : aims to achieve some client-side dynamic
validation before sending request for PHP server-side operations

*/

// -------------------------------------------------------------------------
// functions for listening inputs



/* DynListen  --------------------------------------------------------------
/    Stands for checking login validations. Return testing value (true or
/  false). A given login can contain letters (lower/uppercase), numbers and
/  "-".
/
/  Parameters
/    - elt : login to be verified.
/ --------------- */
function DynListen(elt){
    var regex = new RegExp("^[a-zA-Z0-9]{5,15}$")
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
<<<<<<< HEAD
=======

>>>>>>> 4c4c6620d5441c0030d2bd53165294a536c260aa
