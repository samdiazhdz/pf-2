<!DOCTYPE html>
<html>
<head>
    <title>Registro y Consulta de Estudiantes</title>
</head>
<body>
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
</body>
</html>
