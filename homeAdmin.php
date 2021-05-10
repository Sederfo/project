<?php
  session_start();
  include "db_conn.php";
  require "utilities.php";
  if(isset($_SESSION['id']) && isset($_SESSION['user_name']) && isset($_SESSION['role'])){
    if(isset($_POST["subject"]) && isset($_POST["description"]) && isset($_POST["priority"])){
      $subject = $_POST["subject"];
      $description = $_POST["description"];
      $priority = $_POST["priority"];
      addTicket($subject, $description, $priority);
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

    <form method = "post" id ="addTIcketForm">
    </form>

    <button class ="modal-btn">Add Ticket</button>

    <div class = "modal-bg">
      <div class = "modal">
        <label for="Subject">Subject: </label>
        <input type = "text" name = "sbj" form = "addTIcketForm" id = "sbj">
        <label for ="Description">Description</label>
        <textarea id = "dsc" name = "dsc"></textarea>
        <label for ="Priority">Priority</label>
        <select name = "priority" id = "priority" form = "addTIcketForm">
          <option value ="low" id = "lowpr">Low</option>
          <option value ="medium" id = "mediumpr">Medium</option>
          <option value ="high" id = "highpr">High</option>
          <option value ="critical" id = "criticalpr">Critical</option>
        </select>
        <button type = "submit" class = "doneBtn" name = "doneBtn">Done</button>
        <span class ="modal-close">X</span>
      </div>
    </div>

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

    modalDone.addEventListener('click', () =>{
      var subject = document.getElementById('sbj').value;
      var description = document.getElementById('dsc').value;
      var priority = document.getElementById('priority').value;

      console.log("subject: " + subject);
      console.log("description: " + description);
      console.log("priority: " + priority);

      $.ajax({
        type: "post",
        data: {subject: subject, description: description, priority: priority},
        success: function(data){
          console.log("success");
        }
      });

      modalBg.classList.remove('bg-active');

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
    <?php

     ?>
  </body>
</html>

<?php
}else{
  header("Location: index.php");
  exit();
}
?>
