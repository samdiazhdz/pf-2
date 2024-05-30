<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registro de estudiantes
        $nombre = $_POST['nombre'];
        $numero_control = $_POST['numero_control'];
        $usuario = $_POST['usuario'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña

        $sql = "INSERT INTO estudiantes (nombre, numero_control, usuario, password) VALUES ('$nombre', '$numero_control', '$usuario', '$password')";

        if ($conn->query($sql) === TRUE) {
            $message = "Nuevo registro creado exitosamente";
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['login'])) {
        // Inicio de sesión
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $sql = "SELECT password FROM estudiantes WHERE usuario = '$usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['usuario'] = $usuario;
                header("Location: registro.php");
                exit;
            } else {
                $message = "Contraseña incorrecta.";
            }
        } else {
            $message = "Usuario no encontrado.";
        }
    } elseif (isset($_POST['search'])) {
        // Búsqueda de estudiantes
        $numero_control = $_POST['numero_control_search'];

        $sql = "SELECT * FROM estudiantes WHERE numero_control = '$numero_control'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $search_results = "";
            while($row = $result->fetch_assoc()) {
                $search_results .= "Nombre: " . $row["nombre"]. " - Número de Control: " . $row["numero_control"]. "<br>";
            }
        } else {
            $search_results = "No se encontraron resultados.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resultado de Procesamiento</title>
</head>
<body>
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (isset($search_results)): ?>
        <p><?php echo $search_results; ?></p>
    <?php endif; ?>

    <a href="index.php">Volver al inicio</a>
    <a href="registro.php">Volver al registro</a>
</body>
</html>
