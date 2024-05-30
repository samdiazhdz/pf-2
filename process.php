<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Manejo del inicio de sesión
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        $sql = "SELECT id, password FROM estudiantes WHERE usuario = '$usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['user_id'] = $row['id'];
                header("Location: process.php");
                exit;
            } else {
                $message = "Contraseña incorrecta.";
            }
        } else {
            $message = "Usuario no encontrado.";
        }
    } elseif (isset($_SESSION['usuario'])) {
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
        } elseif (isset($_POST['search'])) {
            // Búsqueda de estudiantes
            $numero_control = $_POST['numero_control_search'];

            $sql = "SELECT * FROM estudiantes WHERE numero_control = '$numero_control'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $search_results = "";
                while ($row = $result->fetch_assoc()) {
                    $search_results .= "Nombre: " . $row["nombre"]. " - Número de Control: " . $row["numero_control"]. "<br>";
                }
            } else {
                $search_results = "No se encontraron resultados.";
            }
        }
    } else {
        header("Location: index.html");
        exit;
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

    <?php if (!isset($message) && isset($_SESSION['usuario'])): ?>
        <h2>Formulario de Registro</h2>
        <form method="post" action="process.php">
            Nombre: <input type="text" name="nombre" required><br>
            Número de Control: <input type="text" name="numero_control" required><br>
            Usuario: <input type="text" name="usuario" required><br>
            Contraseña: <input type="password" name="password" required><br>
            <input type="submit" name="register" value="Registrar">
        </form>

        <h2>Consulta de Estudiantes</h2>
        <form method="post" action="process.php">
            Número de Control: <input type="text" name="numero_control_search" required><br>
            <input type="submit" name="search" value="Buscar">
        </form>
        <!-- Mostrar resultados de la búsqueda -->
        <?php if (isset($search_results)): ?>
            <h3>Resultados de la Búsqueda:</h3>
            <p><?php echo $search_results; ?></p>
        <?php endif; ?>

        <!-- Regresar al inicio -->
        <form method="get" action="index.html">
            <input type="submit" value="Ir al inicio">
        </form>
    <?php elseif (!isset($_SESSION['usuario'])): ?>
        <a href="index.html">Volver al inicio</a>
    <?php endif; ?>
</body>
</html>
