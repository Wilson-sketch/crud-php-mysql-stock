<?php
require_once 'includes/auth.php';
verificarSesion();
verificarRol('admin');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        .menu {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .menu a {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['nombre']; ?> (Administrador)</h1>

    <div class="menu">
        <a href="producto_nuevo.php">Agregar Producto</a>
        <a href="admin_productos.php">Editar/Listar Productos</a>
        <a href="contacto.php">Contacto</a>
        <a href="logout.php">Cerrar Sesión</a>
    </div>
</body>
</html>
