<?php
    include_once('userManager.php');
    
    UserManager::userLogout();
    
    header('Refresh: 2; URL = login.php');
?>