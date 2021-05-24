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

    if(isset($_POST["accDoneBtn"])){
      $username = $_POST["username"];
      $name = $_POST["name"];
      $role = $_POST["role"];
      if(checkIfUserExists($username) === true){
        //add notification "user exists" and display the modal until the admin inputs a valid username
      }else{
        //add notification "account has been added"
        addAccount($username, $name, $role);
        header("Location: homeAdmin.php");
        exit;
      }
    }
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<script src= "http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src= "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

  <head>
    <meta charset="utf-8" http-equiv="refresh" content = "60">
    <title>Home</title>
    <link rel = "stylesheet" type = "text/css" href="homeAdmin.css">
  </head>
  <body>
    <div class = "sidenav">
      <div class = "opts">
        <a href = "#">Tickets</a>
        <a href ="#addAcc" id = "add-account">Add Account</a>
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
        project.tickets order by `date` desc");

        $sql->execute();
        $res = $sql->get_result();

        if($res->num_rows > 0){
          $data = $res->fetch_all(MYSQLI_ASSOC);
          $_SESSION["tickets"] = $data;
          foreach($data as $row){
            echo "<tr class = 'table-row' data-href = '/project/ticketsDetails.php' id ='currentRow'><td>" . $row["id"] . "</td><td>" . $row["date"] . "</td><td>" . $row["from"] .
              "</td><td>" . $row["subject"] . "</td><td>"  . $row["priority"] . "</td><td>" . $row["status"] . "</td></tr>";

          }
        }
       ?>
    </table>

    <button class ="modal-btn">Add Ticket</button>

    <form action = "" method = "post" id ="addTicketForm">
      <div class = "modal-bg">
        <div class = "modal">
          <label for="Subject">Subject</label>
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

    <form action = "" method = "post" id ="addAccountForm">
      <div class = "acc-modal-bg">
        <div class ="acc-modal">
          <label for = "Username">Username</label>
          <input type ="text" name ="username" id ="usr" required>
          <label for ="Name">Name</label>
          <input type = "text" name = "name" id = "name" required>
          <select name = "role" id = "role" required>
            <option value = "" disabled selected>Select role</option>
            <option value = "Employee" id = "empRole">Employee</option>
            <option value ="User" id = "userRole">User</option>
          </select>
          <input type = "submit" class = "accDoneBtn" name = "accDoneBtn" value = "Done">
          <span class = "acc-modal-close">X</span>
        </div>
      </div>
    </form>
    <div class = "notification">

    </div>
    <script>

    // variables for add ticket modal
    var modalBtn = document.querySelector('.modal-btn');
    var modalBg = document.querySelector('.modal-bg');
    var modalClose = document.querySelector('.modal-close');
    var modalDone = document.querySelector('.doneBtn');

    //variables for add account modal
    var addAccount = document.getElementById('add-account');
    var accModalBg = document.querySelector('.acc-modal-bg');
    var accModalClose = document.querySelector('.acc-modal-close');
    var accModalDone = document.querySelector('.accDoneBtn');

    addAccount.addEventListener('click', () =>{
      accModalBg.classList.add('acc-bg-active');
    });

    accModalClose.addEventListener('click', () =>{
      accModalBg.classList.remove('acc-bg-active');
    });

    accModalDone.addEventListener('submit', (e) => {
      e.preventDefault();
      accModalBg.remove('bg-active');
    });

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
        row.addEventListener("click", () => {
          var ticketId = row.children[0].textContent;
          console.log(ticketId);
          window.location.href =  row.dataset.href + "?id=" + ticketId;
      });
      switch (row.children[5].textContent) {
        case "pending":
          row.children[5].style.color = "rgb(204, 163, 0)";
          break;
        case "in progress":
          row.children[5].style.color = "green";
          break;
        case "solved":
          row.children[5].style.color = "red";
          break;
        default:
        row.children[5].style.color = "black";
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
