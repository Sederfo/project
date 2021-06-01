<?php
    session_start();
    //redirect to homeAdmin if user is admin
    //redirect to homeEmployee if user is employee
    if ($_SESSION["role"] == "admin")
        header("Location: homeAdmin.php");
        
    else if ($_SESSION["role"] == "employee")
        header("Location: homeEmployee.php");
    else 
    header("Location: homeUser.php");
        
?>