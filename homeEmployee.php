<?php
  session_start();
  include "db_conn.php";
  require "utilities.php";
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){

  }else{
    header("Location: index.php");
    exit();
  }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">


  <head>
    <meta charset="utf-8" http-equiv="refresh" content = "60">
    <title>Home</title>
    <link rel = "stylesheet" type = "text/css" href="css/homeAdmin.css">
    <link rel = "stylesheet" type = "text/css" href="css/ticketsTable.css">
    <link rel = "stylesheet" type = "text/css" href="css/modal.css">
    <link rel = "stylesheet" type = "text/css" href="css/topnav.css">
    <link rel = "stylesheet" type = "text/css" href="css/page.css">
    <link rel="icon" href="img/tm_logo.png">

    <script src= "http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src= "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script defer src= "js/homeEmployee.js"></script>
  </head>
  <body>
    <div class = "topnav">
      <div class = "opts">
        <img src="img/tm_logo.png" style="height: 48px;">
        <a href = "homeEmployee.php">Tickets</a>
        <a href = "logout.php">Log out</a>
      </div>
      <div>
        
      </div>
      <div class="opts"> <a >Welcome <?php echo $_SESSION["user_name"]; ?> </a></div>
    </div>
    
    <div class="testClass">
    <table class = "ticketsTable" id ="ticketsTable">
      <tr>  
        <th>Ticket number</th>
        <th>Date</th>
        <th>From</th>
        <th>Subject</th>
        <th>Priority</th>
        <th>Status</th>
        <th>SLA</th>
      </tr>
      <?php
        $sql = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status`, `SLA` from
        project.tickets order by `date` desc");

        $sql->execute();
        $res = $sql->get_result();

        if($res->num_rows > 0){
          $data = $res->fetch_all(MYSQLI_ASSOC);
          $_SESSION["tickets"] = $data;
          foreach($data as $row){
            echo "<tr class = 'table-row' data-href = '/project/ticketsDetails.php' id ='currentRow'><td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["from"] .
              "</td><td>" . $row["subject"] . "</td><td>"  . $row["priority"] . "</td><td>" . $row["status"] . "</td><td>" . $row["SLA"] . "</td></tr>";

          }
        }
       ?>
    </table>
  
      
    </div>
  </body>
</html>