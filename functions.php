
<?php

  function VarCheck($var){
    return (isset($var) && !empty($var));

  }

  function LoginInfoCheck($log, $pwd){
    return (VarCheck($log) && VarCheck($pwd));

  }



 ?>
