<?php
require 'config.php'; // Incluir archivo de configuración
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Aquí puedes agregar lógica para mostrar los cursos del usuario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Academia de Cursos</a>
            <div class="navbar-nav">
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Bienvenido al Dashboard</h1>
        <!-- Aquí iría el contenido del dashboard, como la lista de cursos, enlaces para crear, editar o eliminar cursos, etc. -->
    </div>
</body>
</html>
