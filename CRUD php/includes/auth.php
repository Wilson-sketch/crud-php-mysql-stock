<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function verificarSesion() {
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit;
    }
}

function verificarRol($rolRequerido) {
    if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== $rolRequerido) {
        echo "Acceso denegado.";
        exit;
    }
}
