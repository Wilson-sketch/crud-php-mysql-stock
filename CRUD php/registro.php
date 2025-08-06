<?php
require_once 'includes/db.php';

$errores = [];
$exito = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $rol = $_POST['rol']; // admin o usuario

    // Validaciones básicas
    if (empty($nombre) || empty($usuario) || empty($email) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido.";
    } else {
        // Verificar si usuario o email ya existen
        $query = "SELECT id FROM usuarios WHERE usuario = ? OR email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errores[] = "El usuario o email ya está en uso.";
        } else {
            // Encriptar contraseña
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar nuevo usuario
            $insert = "INSERT INTO usuarios (nombre_completo, usuario, email, password, rol)
                       VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert);
            mysqli_stmt_bind_param($stmt, "sssss", $nombre, $usuario, $email, $passwordHash, $rol);

            if (mysqli_stmt_execute($stmt)) {
                $exito = "Usuario registrado exitosamente.";
            } else {
                $errores[] = "Error al registrar el usuario.";
            }
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
</head>
<body>
    <h1>Registro</h1>

    <?php if ($exito): ?>
        <p style="color:green;"><?php echo $exito; ?></p>
    <?php endif; ?>

    <?php foreach ($errores as $error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endforeach; ?>

    <form method="POST" action="">
        <label>Nombre completo:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Rol:</label><br>
        <select name="rol">
            <option value="usuario">Usuario</option>
            <option value="admin">Administrador</option>
        </select><br><br>

        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
