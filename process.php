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
            header("Location: process.php");
            exit;
        } else {
            // Si la contraseña es incorrecta, mostrar un mensaje de error
            $message = "Contraseña incorrecta.";
        }
    } else {
        // Si el usuario no se encontró en la base de datos, mostrar un mensaje de error
        $message = "Usuario no encontrado.";
    }
}

// Si el usuario ya ha iniciado sesión, redirigirlo a process.php
if (isset($_SESSION['usuario'])) {
    header("Location: process.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Inicio de Sesión</title>
</head>
<body>
    <h2>Inicio de Sesión</h2>
    <form method="post" action="">
        Usuario: <input type="text" name="usuario" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Iniciar Sesión">
    </form>
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
