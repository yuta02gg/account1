<?php
function getDbConnection() {
    $servername = "localhost";
    $username = "tanaka";
    $password = "hNS7OLeIYydQDd0V";
    $dbname = "account";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        throw new Exception("Connection failed: " . $e->getMessage());
    }
}
?>
