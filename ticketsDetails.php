<?php
  session_start();
  include "db_conn.php";
  include "utilities.php";
  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){

    if(isset($_POST["done"]) && isset($_POST["ticketPriority"])){
      $prt = $_POST["ticketPriority"];

      if($prt === "in progress"){
        
      }else if($prt === "solved"){
        header("Location: homeAdmin.php");
        exit;
      }

    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ticket Details</title>
    <link rel = "stylesheet" type = "text/css" href="ticketsDetails.css">
    <script src="ticketsDetails.js" defer> </script>
  </head>
  <body>

    <div class = "sidenav">
      <div class = "opts">
        <a href = "homeAdmin.php">Tickets</a>
        <a id = "add-account">Add Account</a>
        <a href = "logout.php">Log out</a>
      </div>
    </div>

    <?php

    if(isset($_GET["id"])){
      $_SESSION["currentTicketId"] = $_GET["id"];
      $currentTicketId = $_SESSION["currentTicketId"];
      $currentTicket = array();
      $stmt = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status`
       from project.tickets where id = ?");

      $stmt->bind_param("i", $currentTicketId);

      $stmt->execute();

      $stmt->store_result();

      if($stmt->num_rows === 1){
        $stmt->bind_result($currentTicket["id"], $currentTicket["date"], $currentTicket["from"], $currentTicket["subject"],
        $currentTicket["description"], $currentTicket["priority"], $currentTicket["status"]);
        $stmt->fetch();
      }
    }
     ?>

  <div class = "container">
    <div id="container-details" class="container-details">
      <h1>Ticket <?php echo $currentTicket["id"];?> </h1>
      <p>From: <?php echo $currentTicket["from"];?></p>
      <p>Subject: <?php echo $currentTicket["subject"];?></p>
      <p>Date: <?php echo $currentTicket["date"];?></p>
      <p>Status: <?php echo $currentTicket["status"];?></p>
      <p>Priority: <?php echo $currentTicket["priority"];?></p>
    </div>

    <div id="container-description" class="container-description">
      <p><?php echo $currentTicket["description"];?> </p>
    </div>

    <form action = "" method = "post">
    <div id="container-solve" class="container-rca">
        <!--<button type = "submit" id="solve-button" name = "solveButton"> Solve </button>-->

        <select name = "ticketPriority" id = "priority">
          <option value = "pending" selected disabled>Choose status</option>
          <option value = "in progress" id = "in progress">In progress</option>
          <option value = "solved" id = "solved">Solved</option>
        </select>
        <input type = "submit" name = "done" value="Done" id = "done-button">
    </div>
    </form>

    <div id="container-rca" class="container-rca" style="display:none">
      <textarea rows="4" cols="150" style="resize: none"> </textarea>
      <button> Done </button>
    </div>
  </div>


  <?php

  if(isset($_POST["solveButton"])){
    $status = "in progress";
    //updateStatus($currentTicket["id"], $status);
  }

   ?>


  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}

 ?>
