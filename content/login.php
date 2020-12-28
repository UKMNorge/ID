<?php
    include_once('userManager.php');

    error_reporting(E_ALL);
    ini_set("display_errors", 1);
?>

<html lang = "en">
   
   <head>
      <title>ID UKM Login</title>   
   </head>

   <style>
    .container{
        width: 240px;
        border: solid 1px;
        padding: 20px;
        margin: auto;
    }

    .page-1 .header .header-background {
        background: #a0aec0;
        width: 100%;
    }

    </style>
	
   <body>
      
      <h2>Enter Username  and Password</h2> 
         
        <?php
            $msg = '';

            // There is an active session
            if (UserManager::isSessionActive()) {
                echo '<h2>Logged in!</h2>';
                echo '<a href = "logout.php" tite = "Logout">Logout</a>';
                exit;
            // Credentials provided
            } else if (isset($_POST['login']) && !empty($_POST['tel_nr']) && !empty($_POST['password'])) {
                // User credentials are correct
                if (UserManager::userLogin($_POST['tel_nr'], $_POST['password'])) {                    
                    header("Location: ./token-test.php");
                // User credentials are not correct
                }else {
                    $msg = 'Wrong username or password';
                }
            }
        ?>

        <div class = "container">
            <form class="form-signin" role="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type="tel" autocomplete="true" name="tel_nr" placeholder="telefonnummeret" required autofocus></br>
            <input type="password" name="password" placeholder="passord" required>
            <button type ="submit" name="login">Login</button>
            </form>
        <a href = "logout.php" tite = "Logout">Logout</a>
      </div> 
      

      <div class="page-one-page page-1" pageId="1">
        <div class="header">
            <div class="header-background">
                
            </div>
        </div>
      </div>

   </body>
</html>