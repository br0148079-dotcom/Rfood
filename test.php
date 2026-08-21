<?php

require_once "config/Database.php";

$database = new Database();
$conn = $database->connect();

if ($conn) {
    echo "<h2 style='color:green;'>✅ Database Connected Successfully!</h2>";
} else {
    echo "<h2 style='color:red;'>❌ Database Connection Failed!</h2>";
}

?>