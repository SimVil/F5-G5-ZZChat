<div class="container">
  <div class="row">
    <div class="col-md-12">
      <form class="form-signin" action="./src/login.php" method="post">
        <h1 class="form-heading"> ZZ-Chat </h1>
        <div class="form-input-text">
          <input type="text" class="valid" name="login" id="login" placeholder="Login"/>
          <br>

          <input type="password" class ="valid" name="password" id="password" placeholder="Password"/>
          <br>

        </div>

        <div class="form-input-submit">
          <input type="submit" name="action" id="submit" value="Register"/>

        </div>

        <?php
          $err = 0;
          if(isset($_GET['err'])){
            $err = $_GET['err'];

            switch($err){
                case 'regerr':
                  echo '<div class="failure"> <b> Error</b>: Wrong or existent informations </div>';
                  break;

                default:
                  break;
              }
          }


        ?>

      </form>

    </div>
  </div>
  <script type="text/javascript" src="static/js/DynListen.js"></script>
  <script type="text/javascript" src="static/js/ScriptSign.js"></script>
</div>
