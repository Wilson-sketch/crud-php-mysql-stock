<?php
require_once 'includes/auth.php';
verificarSesion();

$modo = $_GET['modo'] ?? 'admin';

// Si no está en modo vista, verificar que sea admin
if ($modo !== 'vista') {
    verificarRol('admin');
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
    <title><?php echo $modo === 'vista' ? 'Lista de Productos' : 'Administrar Productos'; ?></title>
</head>
<body>
    <h1><?php echo $modo === 'vista' ? 'Lista de Productos (Solo lectura)' : 'Listado de Productos'; ?></h1>

    <?php if ($modo !== 'vista'): ?>
        <a href="admin.php">Menú inicial</a> | 
        <a href="producto_nuevo.php">Agregar nuevo producto</a><br><br>
    <?php else: ?>
        <a href="usuario.php">Volver</a><br><br>
    <?php endif; ?>

    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Fecha</th>
            <?php if ($modo !== 'vista'): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>

        <?php while ($producto = mysqli_fetch_assoc($resultado)): ?>
        <tr>
            <td><?php echo $producto['id']; ?></td>
            <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
            <td>$<?php echo $producto['precio']; ?></td>
            <td><?php echo $producto['stock']; ?></td>
            <td><?php echo $producto['fecha_creacion']; ?></td>

            <?php if ($modo !== 'vista'): ?>
                <?php if ($modo === 'vista'): ?>
    <br><br>
    <form action="contacto.php" method="GET" style="display:inline;">
        <button type="submit">Contacto</button>
    </form>

    <form action="logout.php" method="POST" style="display:inline;">
        <button type="submit">Cerrar sesión</button>
    </form>
<?php endif; ?>

                <td>
                    <a href="editar_producto.php?id=<?php echo $producto['id']; ?>">Editar</a> 
                    <a href="producto_eliminar.php?id=<?php echo $producto['id']; ?>" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
                </td>
            <?php endif; ?>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
