<?php
session_start();
require_once 'includes/db.php';

$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        $errores[] = "Todos los campos son obligatorios.";
    } else {
        $query = "SELECT id, nombre_completo, password, rol FROM usuarios WHERE usuario = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $id, $nombre, $hash, $rol);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hash)) {
                // Login exitoso
                $_SESSION['id'] = $id;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['rol'] = $rol;

                // Redirigir según el rol
                if ($rol === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: admin_productos.php?modo=vista");
                }
                exit;
            } else {
                $errores[] = "Contraseña incorrecta.";
            }
        } else {
            $errores[] = "Usuario no encontrado.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Login</h1>

    <?php foreach ($errores as $error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endforeach; ?>

    <form method="POST" action="">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Ingresar">
    </form>
</body>
</html>
