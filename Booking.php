<?php

require_once __DIR__ . "/../config/Database.php";

class Booking
{
    private $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function saveBooking($first_name, $last_name, $phone, $email, $booking_date, $booking_time)
    {
        $sql = "INSERT INTO bookings
        (first_name, last_name, phone, email, booking_date, booking_time)
        VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ssssss",
            $first_name,
            $last_name,
            $phone,
            $email,
            $booking_date,
            $booking_time
        );

        return $stmt->execute();
    }
}
?>