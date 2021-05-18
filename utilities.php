<?php
declare(strict_types=1);
session_status() === PHP_SESSION_ACTIVE ?: session_start();



  function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  function updateStatus($id, $status){
    include 'db_conn.php';
    $updateQuery = $conn->prepare("update project.tickets set `status` = ? where `id` = ?");
    $updateQuery->bind_param("si", $status, $id);
    $updateQuery->execute();
    $updateQuery->close();
  }

  function addTicket($subject, $description, $priority){
    include 'db_conn.php';
    $insertQuery = $conn->prepare("insert into project.tickets(`from`,`date`, `subject`, `description`, `priority`, `status`)
    values(?, ?, ?, ?, ?, ?);");
    $date = date('Y-m-d H:i:s');
    $status = "pending";
    $insertQuery->bind_param("ssssss", $_SESSION["user_name"], $date, $subject, $description, $priority, $status);
    $insertQuery->execute();
    $insertQuery->close();
  }

  function addAccount($username, $name, $role){
    include 'db_conn.php';
    $insertAccQuery = $conn->prepare("insert into project.users(`user_name`, `password`, `name`, `role`)
    values (?, ?, ?, ?);");
    $password = "123456";
    $insertAccQuery->bind_param("ssss", $username, $password, $name, $role);
    $insertAccQuery->execute();
    $insertAccQuery->close();
  }

  function checkIfUserExists($username){
    include 'db_conn.php';
    $checkQuery = $conn->prepare("select user_name from project.users where user_name = ?;");
    $checkQuery->bind_param("s", $username);
    $checkQuery->execute();
    $result = $checkQuery->get_result();
    $checkQuery->close();
    return $result;
  }
 ?>
