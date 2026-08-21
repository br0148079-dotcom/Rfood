<?php

session_start();

require_once "../config/Database.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $database = new Database();
    $conn = $database->connect();

    $sql = "DELETE FROM bookings WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $id);

    $stmt->execute();
}

header("Location: dashboard.php");
exit;

?>