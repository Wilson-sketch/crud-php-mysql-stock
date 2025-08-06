<?php
require_once 'includes/auth.php';
verificarSesion();
verificarRol('admin');
require_once 'includes/db.php';

$errores = [];
$exito = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Validaciones básicas
    if (empty($nombre) || empty($precio) || empty($stock)) {
        $errores[] = "Nombre, precio y stock son obligatorios.";
    } elseif (!is_numeric($precio) || !is_numeric($stock)) {
        $errores[] = "Precio y stock deben ser números válidos.";
    } else {
        $query = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssdi", $nombre, $descripcion, $precio, $stock);

        if (mysqli_stmt_execute($stmt)) {
            $exito = "Producto agregado exitosamente.";
        } else {
            $errores[] = "Error al guardar el producto.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Producto</title>
</head>
<body>
    <h1>Agregar Producto</h1>
    <a href="admin.php">Menú inicial</a> |
    <a href="admin_productos.php">Ver lista de productos</a><br><br>
    
    <?php foreach ($errores as $error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endforeach; ?>

    <?php if ($exito): ?>
        <p style="color:green;"><?php echo $exito; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"></textarea><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" required><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" required><br><br>

        <input type="submit" value="Guardar Producto">
    </form>
</body>
</html>
