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
        // Mostrar formularios solo si el usuario ha iniciado sesión
        ?>
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
        <!--Regresar al inicio-->
        <form method="get" action="index.html">
            <input type="submit" value="Ir al inicio">
        </form>
        <?php
    } else {
        header("Location: index.html");
        exit;
    }
}

$conn->close();
?>
