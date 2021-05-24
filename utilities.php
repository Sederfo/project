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
    $insertQuery = $conn->prepare("insert into project.tickets(`from`,`date`, `subject`, `description`, `priority`, `status`, `SLA`)
    values(?, ?, ?, ?, ?, ?, ?);");
    $date = date('Y-m-d H:i:s');
    $sla = date('Y-m-d H:i:s');
    if($priority === "low"){
      $sla = date("Y-m-d H:i:s", strtotime("+12 hours"));
    }else if($priority === "medium"){
      $sla = date("Y-m-d H:i:s", strtotime("+8 hours"));
    }else if($priority === "high"){
      $sla = date("Y-m-d H:i:s", strtotime("+6 hours"));
    }else if($priority === "critical"){
      $sla = date("Y-m-d H:i:s", strtotime("+4 hours"));
    }
    $status = "pending";
    $insertQuery->bind_param("sssssss", $_SESSION["user_name"], $date, $subject, $description, $priority, $status, $sla);
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
    $checkQuery->store_result();
    $result = $checkQuery->num_rows;
    $checkQuery->close();
    if($result === 1){
      return true;
    }else{
      return false;
    }
  }

  function deleteTicket($id){
    include 'db_conn.php';
    $deleteQuery = $conn->prepare("delete from project.tickets where id = ?;");
    $deleteQuery->bind_param("i", $id);
    $deleteQuery->execute();
    $deleteQuery->close();
  }

  function updateAssignedTo($id, $newAT){
    include 'db_conn.php';
    $updateATQuery = $conn->prepare("update project.tickets set `assignedTo` = ? where id = ?;");
    $updateATQuery->bind_param("si",$newAT, $id);
    $updateATQuery->execute();
    $updateATQuery->close();
  }

  function addSolvedTicket($id, $solvedBy, $rca){
    include 'db_conn.php';
    $addSolvedTicketQuery = $conn->prepare("insert into project.solved_tickets(`id`, `solved_by`, `RCA`) values(?, ?, ?);");
    $addSolvedTicketQuery->bind_param("iss", $id, $solvedBy, $rca);
    $addSolvedTicketQuery->execute();
    $addSolvedTicketQuery->close();
  }

  function getRCA($id){
    include 'db_conn.php';
    $getRCAQuery = $conn->prepare("select RCA from project.solved_tickets where id = ?");
    $getRCAQuery->bind_param("i", $id);
    $getRCAQuery->execute();
    $result = $getRCAQuery->get_result();
    $rca = $result->fetch_all(MYSQLI_ASSOC);
    if(count($rca)){
      return $rca;
    }else{
      return [];
    }
  }
 ?>
