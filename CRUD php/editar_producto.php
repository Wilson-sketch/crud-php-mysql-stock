<?php
require_once 'includes/auth.php';
verificarSesion();
verificarRol('admin');
require_once 'includes/db.php';

$errores = [];
$exito = '';

// Validar que viene el ID por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit;
}

$id = $_GET['id'];

// Obtener el producto actual
$query = "SELECT * FROM productos WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {
    echo "Producto no encontrado.";
    exit;
}

$producto = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($stmt);

// Procesar edición
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    if (empty($nombre) || empty($precio) || empty($stock)) {
        $errores[] = "Nombre, precio y stock son obligatorios.";
    } elseif (!is_numeric($precio) || !is_numeric($stock)) {
        $errores[] = "Precio y stock deben ser numéricos.";
    } else {
        $update = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update);
        mysqli_stmt_bind_param($stmt, "ssdii", $nombre, $descripcion, $precio, $stock, $id);

        if (mysqli_stmt_execute($stmt)) {
            $exito = "Producto actualizado con éxito.";
            // Actualizar datos en pantalla
            $producto['nombre'] = $nombre;
            $producto['descripcion'] = $descripcion;
            $producto['precio'] = $precio;
            $producto['stock'] = $stock;
        } else {
            $errores[] = "Error al actualizar.";
        }

        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
</head>
<body>
    <h1>Editar Producto</h1>
    

    <?php foreach ($errores as $error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endforeach; ?>

    <?php if ($exito): ?>
        <p style="color:green;"><?php echo $exito; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required><br><br>

        <label>Descripción:</label><br>
        <textarea name="descripcion"><?php echo htmlspecialchars($producto['descripcion']); ?></textarea><br><br>

        <label>Precio:</label><br>
        <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" required><br><br>

        <label>Stock:</label><br>
        <input type="number" name="stock" value="<?php echo $producto['stock']; ?>" required><br><br>

<form method="POST" action="actualizar_producto.php">
    <!-- campos del producto -->
     <a href="admin_productos.php">Volver al listado</a><br><br>
    <input type="submit" value="Actualizar">
    <button type="button" onclick="window.location.href='admin_productos.php'">Cancelar</button>
</form>


    </form>
</body>
</html>
