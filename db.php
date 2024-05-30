<?php
$servername = "dbpf2.privatelink.mysql.database.azure.com";
$username = "sam";
$password = "Bleach150!!!";
$dbname = "estudianteDB";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
