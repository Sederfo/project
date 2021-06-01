<?php
    include "db_conn.php";
    $deleteQuery = $conn->prepare("delete from project.tickets where id = ?;");
    $deleteQuery->bind_param("i", $_POST["id"]);
    $deleteQuery->execute();
    $deleteQuery->close();
    header("Location: goToHome.php");
?>