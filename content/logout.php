<?php
    include_once('userManager.php');
    
    UserManager::userLogout();
    
    header('Refresh: 1; URL = /login-or-register.php');
?>