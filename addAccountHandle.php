<?php
    include "db_conn.php";
    require "utilities.php";
    $username = $_POST["username"];
      $name = $_POST["name"];
      $role = $_POST["role"];
      if(checkIfUserExists($username) === true){
        header("Location: homeAdmin.php?error=User already exists!");
      }else{
        //add notification "account has been added"
        echo "user added";
        addAccount($username, $name, $role);
        //header("Location: homeAdmin.php");
        exit;
      }
?>