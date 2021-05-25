<?php
  session_start();
  include "db_conn.php";
  include "utilities.php";
  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){

    if(isset($_POST["done"]) && isset($_POST["ticketPriority"])){
      $prt = $_POST["ticketPriority"];

      if($prt === "in progress"){
          updateAssignedTo($_GET["id"], $_SESSION["user_name"]);
          updateStatus($_GET["id"], "in progress");
      }else if($prt === "solved"){
          //addSolvedTicket($_GET["id"],$_SESSION['user_name'], $_POST["rca"]);
          updateStatus($_GET["id"], "solved");
      }
    }

    if(isset($_POST["rca"]) && isset($_POST["done"]) && !empty($_POST["rca"])){
        addSolvedTicket($_GET["id"], $_SESSION['user_name'], $_POST["rca"]);

        header("Location: goToHome.php");
        exit;
    }

    $rca = getRCA($_GET["id"]);

  }else{
    header("Location: index.php");
    exit();
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Ticket Details</title>
    <link rel = "stylesheet" type = "text/css" href="css/ticketsDetails.css">
    <link rel = "stylesheet" type = "text/css" href="css/modal.css">
    <link rel = "stylesheet" type = "text/css" href="css/topnav.css">
    <link rel = "stylesheet" type = "text/css" href="css/page.css">

    <script defer src="js/ticketsDetails.js" defer> </script>
  </head>
  <body>

  <div class = "topnav">
      <div class = "opts">
        <a href = "goToHome.php" id="tickets-btn">Tickets</a>
        
        <a href = "logout.php">Log out</a>
      </div>
      <div></div>
      <div class="opts"> <a > <?php echo $_SESSION["user_name"]; ?> </a></div>
    </div>

    <?php

    if(isset($_GET["id"])){
      // $_SESSION["currentTicketId"] = $_GET["id"];
      // $currentTicketId = $_SESSION["currentTicketId"];
      $currentTicketId = $_GET["id"];
      $currentTicket = array();
      $stmt = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status`, `assignedTo`
       from project.tickets where id = ?");

      $stmt->bind_param("i", $currentTicketId);

      $stmt->execute();

      $stmt->store_result();

      if($stmt->num_rows === 1){
        $stmt->bind_result($currentTicket["id"], $currentTicket["date"], $currentTicket["from"], $currentTicket["subject"],
        $currentTicket["description"], $currentTicket["priority"], $currentTicket["status"], $currentTicket["assignedTo"]);
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
      <p>Assigned to: <?php echo $currentTicket["assignedTo"];?></p>
    </div>

    <div id="container-description" class="container-description">
      <p><?php echo $currentTicket["description"];?> </p>
    </div>

    <form action = "" method = "post">
    <div id="container-solve" class="container-rca">
        <select name = "ticketPriority" id = "priority" class = "<?php echo $prt === "solved" || $currentTicket["status"] === "solved" ?  "rca-hidden" :  "rca-visible"; ?>">
          <option value = "pending" selected disabled>Choose status</option>
          <option value = "in progress" id = "in progress">In progress</option>
          <option value = "solved" id = "solved">Solved</option>
        </select>
        <?php
        if(count($rca) == 0){
        ?>
        <textarea rows="4" cols="150" name = "rca" style="resize: none" class = "<?php echo $prt === "solved" || $currentTicket["status"] === "solved" ?  "rca-visible":  "rca-hidden"; ?>"></textarea>
        <button type = "submit" name = "done" value="Done" id = "done-button"> Done </button>
      <?php
     }else {
        ?>
        <p><?php echo $rca[0]["RCA"];?></p>
        <?php }?>
    </div>
    </form>

    <div id="container-rca" class="container-rca" style="display:none">
      <textarea rows="4" cols="150" style="resize: none"> </textarea>
      <button> Done </button>
    </div>

    <?php 
      if ($currentTicket["status"] != "solved"){
        echo "
        <div>
          <button id='delete-btn' class='deleteTicketButton'> Delete ticket </button>
        </div>
        
        ";
      }
    ?>
    
    <div id="delete-modal-bg" class = "modal-bg ">
      <div id="delete-modal" class = "modal">
        <p> Are you sure you want to delete Ticket <?php echo $_GET["id"] ?> ?
        <form action = "deleteTicketHandle.php" method = "post">
          <input type="hidden" name="id" value=<?php echo $_GET["id"]?> >
          <button class="button" type = "submit" name = "deleteButton" value = "Delete" >
            Yes
          </button>
          <button id="delete-modal-close-no-button" class="button" type = "button" >
            No
          </button>
        </form>
      <span id = "delete-modal-close" class = "modal-close">X</span>
      </div>
    </div>
  </div>
  </body>
</html>
