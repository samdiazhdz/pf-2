<?php
include 'db.php';
session_start();

$message = "";

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Obtener el usuario y la contraseña enviados desde el formulario
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $password = $_POST['password'];

    // Consultar la base de datos para obtener el usuario con el nombre proporcionado
    $sql = "SELECT id, password FROM estudiantes WHERE usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si se encontró un usuario, verificar la contraseña
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Iniciar sesión y redirigir al usuario a process.php
            $_SESSION['usuario'] = $usuario;
            $_SESSION['user_id'] = $row['id'];
        } else {
            // Si la contraseña es incorrecta, mostrar un mensaje de error
            $message = "Contraseña incorrecta.";
        }
    } else {
        // Si el usuario no se encontró en la base de datos, mostrar un mensaje de error
        $message = "Usuario no encontrado.";
    }
}

// Si el usuario ya ha iniciado sesión, mostrar el formulario de registro y consulta de estudiantes
if (isset($_SESSION['usuario'])) {
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

    <?php if (isset($_SESSION['usuario'])): ?>
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
        <!-- Botón para ir al inicio (login) -->
        <form method="get" action="index.html">
            <input type="submit" value="Ir al inicio">
        </form>
    </body>
    </html>
    <?php
    exit;
}

// Si el usuario no ha iniciado sesión o hubo un error, redirigir al usuario al formulario de inicio de sesión
header("Location: index.html");
exit;
?>
