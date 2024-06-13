<?php
// Aquí puedes incluir la lógica para obtener los cursos de la base de datos y mostrarlos en una tabla
require 'config.php'; // Incluir archivo de configuración

// Verificar si hay una sesión de usuario iniciada
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #343a40;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar-brand,
        .nav-link {
            color: white;
        }

        .nav-link {
            margin-left: 20px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card-header {
            background-color: #f2f2f2;
            border-bottom: none;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .card-body {
            padding: 20px;
            font-size: 18px;
        }

        .bg-cover {
            background-image: url('assets/images/inicio.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .btn-courses {
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .btn-courses:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-graduation-cap"></i> Academia de Cursos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-chalkboard-teacher"></i> Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user"></i> Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 bg-cover">

            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <h5 class="card-header">¿Quieres estudiar?</h5>
                    <div class="card-body">
                        <p>Academia de Cursos es tu plataforma educativa ideal para aprender, mejorar tus habilidades y alcanzar tus metas profesionales. Ofrecemos una amplia gama de cursos en diferentes áreas, impartidos por expertos en el campo.</p>
                        <p><strong>¿Por qué estudiar con nosotros?</strong></p>
                        <ul>
                            <li>Contenido de calidad y actualizado.</li>
                            <li>Acceso las 24 horas, los 7 días de la semana.</li>
                            <li>Aprendizaje interactivo y práctico.</li>
                            <li>Certificados reconocidos internacionalmente.</li>
                            <li>Comunidad de aprendizaje activa y colaborativa.</li>
                        </ul>
                        <p>Únete a nuestra comunidad hoy mismo y da el siguiente paso en tu carrera profesional.</p>
                    </div>
                </div>
                <div class="card mb-3">
                    <h5 class="card-header">¿Quieres Inscribirte?</h5>
                    <div class="card-body">
                        <p>Explora nuestra amplia oferta de cursos y elige el que mejor se adapte a tus necesidades y objetivos profesionales.</p>
                        <a href="dashboard.php" class="btn-courses"><i class="fas fa-chalkboard-teacher"></i> Ver Cursos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

