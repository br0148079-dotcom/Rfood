<?php

require_once "../classes/Booking.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../index.php");
    exit;
}

$booking = new Booking();

$result = $booking->saveBooking(
    $_POST["first_name"],
    $_POST["last_name"],
    $_POST["phone"],
    $_POST["email"],
    $_POST["booking_date"],
    $_POST["booking_time"]
);

if ($result) {
    header("Location: ../index.php?booking=success");
    exit;
}

header("Location: ../index.php?booking=failed");
exit;
?>