<?php
session_start();
include "db_conn.php";
include "utilities.php";
if(isset($_POST['uname']) && isset($_POST['password'])) {

  $uname = validate($_POST['uname']);
  $password = validate($_POST['password']);

  if(empty($uname)){
    header("Location: index.php?error=Username is required");
    exit();
  }else if(empty($password)){
    header("Location: index.php?error=Password is required");
    exit();
  }else{
    $stmt = $conn->prepare("select id, user_name, password, name, role from project.users where user_name = ? and password = ?");

    $stmt->bind_param("ss", $uname, $password);

    $stmt->execute();

    $stmt->store_result();

    if($stmt->num_rows === 1){
      $stmt->bind_result($idAux, $unameAux, $passwordAux, $nameAux, $roleAux);
      $stmt->fetch();

      if($unameAux === $uname && $passwordAux === $password){
          $_SESSION["id"] = $idAux;
          $_SESSION["user_name"] = $unameAux;
          $_SESSION["password"] = $passwordAux;
          $_SESSION["name"] = $nameAux;
          $_SESSION["role"] = $roleAux;
          switch($_SESSION["role"]){
            case "admin":
              header("Location: homeAdmin.php");
              exit();
              break;
            case "employee":
              header("Location: homeEmployee.php");
              exit();
              break;
            case "user":
              header("Location: homeUser.php");
              exit();
              break;
          }
        }
      }
      else{
        header("Location: index.php?error=Incorrect username or password");
        exit();
      }
    }
}else{
        header("Location: index.php?");
        exit();
}
 ?>
