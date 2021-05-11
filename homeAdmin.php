<?php
  session_start();
  include "db_conn.php";
  require "utilities.php";
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){
    if(isset($_POST["doneBtn"])) {
      $subject = $_POST["subject"];
      $description = $_POST["description"];
      $priority = $_POST["priority"];
      addTicket($subject, $description, $priority);
      header("Location: homeAdmin.php");
      exit;
    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <head>
    <meta charset="utf-8">
    <title>Home</title>
    <link rel = "stylesheet" type = "text/css" href="homeAdmin.css">
  </head>
  <body>
    <div class = "sidenav">
      <div class = "opts">
        <a href = "#">Tickets</a>
        <a href = "#">Profile</a>
        <a href = "logout.php">Log out</a>
      </div>
    </div>

    <table id ="ticketsTable">
      <tr>
        <th>Ticket number</th>
        <th>Date</th>
        <th>From</th>
        <th>Subject</th>
        <th>Priority</th>
        <th>Status</th>
      </tr>
      <?php

        $sql = $conn->prepare("select `id`, `date`, `from`, `subject`, `description`, `priority`, `status` from
        project.tickets");

        $sql->execute();
        $res = $sql->get_result();

        if($res->num_rows > 0){
          $data = $res->fetch_all(MYSQLI_ASSOC);
          $_SESSION["tickets"] = $data;
          foreach($data as $row){
            echo "<tr class = 'table-row' data-href = '/project/ticketsDetails.php' id ='currentRow'><td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["from"] .
              "</td><td>" . $row["subject"] . "</td><td>"  . $row["priority"] . "</td><td>" . $row["status"] . "</td></tr>";
          }

        }else{
          echo "No tickets";
        }
       ?>
    </table>

    <button class ="modal-btn">Add Ticket</button>

    <form action = "" method = "post" id ="addTicketForm">
      <div class = "modal-bg">
        <div class = "modal">
          <label for="Subject">Subject: </label>
          <input type = "text" name = "subject" form = "addTicketForm" id = "sbj" required>
          <label for ="Description">Description</label>
          <textarea id = "dsc" name = "description" required></textarea>
          <label for ="Priority">Priority</label>
          <select name = "priority" id = "priority" form = "addTicketForm" required>
            <option value ="" disabled selected>Select priority</option>
            <option value ="low" id = "lowpr">Low</option>
            <option value ="medium" id = "mediumpr">Medium</option>
            <option value ="high" id = "highpr">High</option>
            <option value ="critical" id = "criticalpr">Critical</option>
          </select>
          <input type = "submit" class = "doneBtn" name = "doneBtn" value = "Done">
          <span class ="modal-close">X</span>
        </div>
      </div>
    </form>
    <script>

    var modalBtn = document.querySelector('.modal-btn');
    var modalBg = document.querySelector('.modal-bg');
    var modalClose = document.querySelector('.modal-close');
    var modalDone = document.querySelector('.doneBtn');

    modalBtn.addEventListener('click', () => {
      modalBg.classList.add('bg-active');
    });

    modalClose.addEventListener('click', () =>{
      modalBg.classList.remove('bg-active');
    });

    modalDone.addEventListener('submit', (e) =>{
      e.preventDefault();
      var subject = document.getElementById('sbj').value;
      var description = document.getElementById('dsc').value;
      var priority = document.getElementById('priority').value;

      modalBg.classList.remove('bg-active');
      window.location.reload();
    });

      document.addEventListener("DOMContentLoaded", () => {
      const rows = document.querySelectorAll("tr[data-href]");
      rows.forEach(row => {
        if (row.children[5].textContent == "pending"){
          row.addEventListener("click", () => {
            var ticketId = row.children[0].textContent;
            window.location.href =  row.dataset.href + "?id=" + ticketId;
        });
        }
        else {
          row.style.color = "green";
        }
      });
    });
    </script>

  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}
?>
