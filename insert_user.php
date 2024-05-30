<?php
include 'db.php';

$nombre = 'Maria Garcia';
$numero_control = '654321';
$usuario = 'mariagarcia';
$password_plain = 'securepwd123';
$password_hashed = password_hash($password_plain, PASSWORD_DEFAULT);

$sql = "INSERT INTO estudiantes (nombre, numero_control, usuario, password) VALUES ('$nombre', '$numero_control', '$usuario', '$password_hashed')";

if ($conn->query($sql) === TRUE) {
    echo "Nuevo usuario registrado exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
