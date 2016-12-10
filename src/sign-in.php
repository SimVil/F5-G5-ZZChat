
<?php
/* --------------------------------------------------------------------
 * FILE : sign-in.php
 * signin form, called in index.php
 *
 * Author : Amin, Simon
 * ------------------------------------------------------------------ */

?>
</br>
</br>
</br>
</br>

<!-- buttons for language -->
<a href="index.php?id=signin&lg=english" > <input type="button" value="english"/> </a>
<a href="index.php?id=signin&lg=french"> <input type="button" value="french" /> </a>


<!-- signin form -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="form-signin" action="./src/login.php?lg=<?php echo($_COOKIE['langzzchat']); ?>" method="post">
                <h1 class="form-heading"> ZZ-Chat </h1>
                <div class="form-input-text">
                    <!-- we use a cookie here to automatically fill the login field, if somebody -->
                    <!-- has already been connected before -->

                    <!-- input area for password and login -->
                    <input type="text" class="valid" name="login" id="login" placeholder="Login"
                    value="<? if(isset($_COOKIE['login'])){echo $_COOKIE['login'];}?>"/>
                    <br>

                    <input type="password" class ="valid" name="password" id="password" placeholder="Password"/><br>

                </div>

                <!-- submit button -->
                <div class="form-input-submit">
                    <input type="submit" name="action" id="submit" value="<?php echo($signinbar); ?>"/>

                </div>

                <?php
                    $err = 0;
                    // two types of specific message here : a valid registration
                    // or wrong informations given
                    if(isset($_GET['err'])){
                        $err = $_GET['err'];

                        switch($err){
                            case 'signerr':
                                echo '<div class="failure"> <b> Error</b>: Wrong Informations or already connected </div>';
                                break;

                            case 'regv':
                                echo '<div class="success"> Valid registration ! </div>';
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
