<?php

session_start();

require_once "../config/Database.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id"]) && isset($_GET["status"])) {

    $id = $_GET["id"];
    $status = $_GET["status"];

    $allowed_status = ["Confirmed", "Cancelled", "Pending"];

    if (!in_array($status, $allowed_status)) {
        die("Invalid status");
    }

    $database = new Database();
    $conn = $database->connect();

    $sql = "UPDATE bookings SET status = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("si", $status, $id);

    $stmt->execute();
}

header("Location: dashboard.php");
exit;

?>