<!DOCTYPE html>
<html>
<head>
    <title>Resultado de Procesamiento</title>
</head>
<body>
    <?php if (!empty($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <?php if (!empty($search_results)): ?>
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

        <!-- Botón de Cerrar Sesión -->
        <form method="post" action="logout.php">
            <input type="submit" name="logout" value="Cerrar Sesión">
        </form>
    <?php else: ?>
        <a href="index.html">Volver al inicio</a>
    <?php endif; ?>
</body>
</html>
