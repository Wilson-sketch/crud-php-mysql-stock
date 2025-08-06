<?php
session_start();
require_once 'includes/auth.php';
verificarSesion();

// Solo usuarios que NO sean admin
if ($_SESSION['rol'] === 'admin') {
    header("Location: admin.php");
    exit;
}

require_once 'includes/db.php';

// Obtener productos de la base
$query = "SELECT * FROM productos ORDER BY fecha_creacion DESC";
$resultado = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio Usuario</title>
</head>
<body>
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>
    <h2>Lista de Productos</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Fecha</th>
        </tr>

        <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?php echo $producto['id']; ?></td>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
            <td>$<?php echo $producto['precio']; ?></td>
            <td><?php echo $producto['stock']; ?></td>
            <td><?php echo $producto['fecha_creacion']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br><br>
    <form action="contacto.php" method="GET" style="display:inline;">
        <button type="submit">Contacto</button>
    </form>

    <form action="logout.php" method="POST" style="display:inline;">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
