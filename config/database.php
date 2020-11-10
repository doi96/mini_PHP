<?php
// Dùng để connect với database
$host = "localhost";
$db_name = "mini_PHP";
$username = "root";
$password = "";

try {
    $con = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
}

// show error
catch (PDOException $exception) {
    echo "Lỗi connect: " . $exception->getMessage();
}
?>