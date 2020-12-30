<?php
    include_once('userManager.php');
    
    UserManager::userLogout();
    
    header('Refresh: 1; URL = /login-one-page.php');
?>