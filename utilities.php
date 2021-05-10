<?php
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
 ?>
