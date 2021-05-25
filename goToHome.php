<?php
    session_start();
    //redirect to homeAdmin if user is admin
    //redirect to homeEmployee if user is employee
    if ($_SESSION["role"] == "admin")
        header("Location: homeAdmin.php");
        
    else
        header("Location: homeEmployee.php");
        
?>