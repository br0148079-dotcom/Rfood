<?php

session_start();

require_once "../config/Database.php";

// Check admin login
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

// Database connection
$database = new Database();
$conn = $database->connect();

// Fetch all bookings
$sql = "SELECT * FROM bookings ORDER BY booking_date DESC, booking_time DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        /* Header */

        .header {
            background: #111;
            color: white;
            padding: 20px 30px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout {
            background: #e74c3c;
            color: white;

            padding: 10px 18px;

            text-decoration: none;

            border-radius: 5px;
        }

        .logout:hover {
            background: #c0392b;
        }


        /* Container */

        .container {
            padding: 30px;
        }

        .container h1 {
            margin-bottom: 20px;
        }


        /* Table */

        .table-box {
            background: white;

            padding: 20px;

            border-radius: 10px;

            overflow-x: auto;

            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 1000px;
        }

        th {
            background: #111;

            color: white;

            padding: 14px;

            text-align: left;
        }

        td {
            padding: 13px;

            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f9f9f9;
        }


        /* Status */

        .status {
            font-weight: bold;
        }

        .pending {
            color: orange;
        }

        .confirmed {
            color: green;
        }

        .cancelled {
            color: red;
        }


        /* Buttons */

        .action-buttons {
            display: flex;

            gap: 6px;

            flex-wrap: wrap;
        }

        .action-buttons a {
            text-decoration: none;
        }

        .btn {
            border: none;

            padding: 8px 12px;

            border-radius: 4px;

            color: white;

            cursor: pointer;

            font-size: 13px;
        }

        .confirm-btn {
            background: #27ae60;
        }

        .confirm-btn:hover {
            background: #219150;
        }

        .cancel-btn {
            background: #f39c12;
        }

        .cancel-btn:hover {
            background: #d68910;
        }

        .delete-btn {
            background: #e74c3c;
        }

        .delete-btn:hover {
            background: #c0392b;
        }


        /* No bookings */

        .no-bookings {
            text-align: center;

            padding: 30px;

            color: #777;
        }


        /* Mobile */

        @media (max-width: 700px) {

            .header {
                flex-direction: column;

                align-items: flex-start;

                gap: 15px;
            }

            .admin-info {
                width: 100%;

                justify-content: space-between;
            }

            .container {
                padding: 15px;
            }

        }

    </style>

</head>


<body>


<!-- HEADER -->

<div class="header">

    <h2>Restaurant Admin Dashboard</h2>

    <div class="admin-info">

        <span>
            Welcome,
            <?php echo htmlspecialchars($_SESSION["admin_username"]); ?>
        </span>

        <a class="logout" href="logout.php">
            Logout
        </a>

    </div>

</div>


<!-- MAIN -->

<div class="container">

    <h1>Restaurant Bookings</h1>


    <div class="table-box">

        <table>

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Name</th>

                    <th>Phone</th>

                    <th>Email</th>

                    <th>Date</th>

                    <th>Time</th>

                    <th>Guests</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>


            <tbody>

            <?php

            if ($result && $result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    $status = strtolower($row["status"]);

            ?>

                <tr>

                    <!-- ID -->

                    <td>
                        <?php echo $row["id"]; ?>
                    </td>


                    <!-- Name -->

                    <td>

                        <?php

                        echo htmlspecialchars(
                            $row["first_name"] . " " . $row["last_name"]
                        );

                        ?>

                    </td>


                    <!-- Phone -->

                    <td>

                        <?php

                        echo htmlspecialchars($row["phone"]);

                        ?>

                    </td>


                    <!-- Email -->

                    <td>

                        <?php

                        echo htmlspecialchars($row["email"]);

                        ?>

                    </td>


                    <!-- Date -->

                    <td>

                        <?php

                        echo htmlspecialchars($row["booking_date"]);

                        ?>

                    </td>


                    <!-- Time -->

                    <td>

                        <?php

                        echo htmlspecialchars($row["booking_time"]);

                        ?>

                    </td>


                    <!-- Guests -->

                    <td>

                        <?php

                        echo htmlspecialchars($row["guests"]);

                        ?>

                    </td>


                    <!-- Status -->

                    <td>

                        <span class="status <?php echo $status; ?>">

                            <?php

                            echo htmlspecialchars($row["status"]);

                            ?>

                        </span>

                    </td>


                    <!-- ACTIONS -->

                    <td>

                        <div class="action-buttons">


                            <!-- CONFIRM -->

                            <a
                                href="update_booking.php?id=<?php echo $row['id']; ?>&status=Confirmed"
                                onclick="return confirm('Confirm this booking?');"
                            >

                                <button class="btn confirm-btn">
                                    Confirm
                                </button>

                            </a>


                            <!-- CANCEL -->

                            <a
                                href="update_booking.php?id=<?php echo $row['id']; ?>&status=Cancelled"
                                onclick="return confirm('Cancel this booking?');"
                            >

                                <button class="btn cancel-btn">
                                    Cancel
                                </button>

                            </a>


                            <!-- DELETE -->

                            <a
                                href="delete_booking.php?id=<?php echo $row['id']; ?>"
                                onclick="return confirm('Are you sure you want to DELETE this booking?');"
                            >

                                <button class="btn delete-btn">
                                    Delete
                                </button>

                            </a>


                        </div>

                    </td>

                </tr>


            <?php

                }

            } else {

            ?>

                <tr>

                    <td colspan="9" class="no-bookings">

                        No bookings found.

                    </td>

                </tr>

            <?php

            }

            ?>

            </tbody>

        </table>

    </div>

</div>


</body>

</html>