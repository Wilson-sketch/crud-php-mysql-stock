<?php
require_once 'includes/auth.php';
verificarSesion();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
</head>
<body>
    <h1>Contacto</h1>
<?php
require_once 'includes/auth.php';
verificarSesion();
?>

<!-- Resto del código contacto -->

<!-- Botón para volver al menú correcto según el rol -->
<?php if ($_SESSION['rol'] === 'admin'): ?>
    <a href="admin.php">Menú inicial</a>
<?php else: ?>
    <a href="usuario.php">Menú inicial</a>
<?php endif; ?>

    <br><br>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $email = htmlspecialchars(trim($_POST['email']));
        $mensaje = htmlspecialchars(trim($_POST['mensaje']));

        if (empty($nombre) || empty($email) || empty($mensaje)) {
            echo "<p style='color:red;'>Todos los campos son obligatorios.</p>";
        } else {
            echo "<p style='color:green;'>Mensaje enviado correctamente (simulado).</p>";
            echo "<h3>Datos enviados:</h3>";
            echo "<strong>Nombre:</strong> $nombre<br>";
            echo "<strong>Email:</strong> $email<br>";
            echo "<strong>Mensaje:</strong><br><pre>$mensaje</pre>";
        }
    }
    ?>

    <form method="POST" action="">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Mensaje:</label><br>
        <textarea name="mensaje" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" value="Enviar mensaje">
    </form>
</body>
</html>
