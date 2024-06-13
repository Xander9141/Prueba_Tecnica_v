<?php
// Aquí puedes incluir la lógica para obtener los cursos de la base de datos y mostrarlos en una tabla
require 'config.php'; // Incluir archivo de configuración

// Verificar si hay una sesión de usuario iniciada
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Obtener cursos de la base de datos
$stmt = $conn->prepare("SELECT * FROM courses");
$stmt->execute();
$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Academia de Cursos</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            overflow: hidden;
        }

        .card-2 {
            border-top: 100px;
            border-bottom: 100px;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 20px;
            overflow-x: auto;
            /* Desplazamiento horizontal en tarjeta si es necesario */
        }

        .btn-create-course {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 16px 28px;
            /* Aumento del padding para el botón */
            text-align: center;
            font-size: 18px;
            /* Aumento del tamaño de fuente */
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            display: inline-block;
            margin-bottom: 20px;
            position: relative;
            /* Añadido */
            z-index: 1;
            /* Añadido */
        }

        .btn-create-course i {
            margin-right: 8px;
        }

        .btn-create-course:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            overflow-x: auto;
            /* Permitir desplazamiento horizontal en pantallas pequeñas */
            white-space: nowrap;
            /* Evitar el salto de línea en celdas largas */
            margin-top: 20px;
            /* Ajuste del margen superior para la tabla */
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .btn-action {
            margin-right: 5px;
        }

        .navbar {
            background-color: #343a40;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            /* Asegura que la barra de navegación esté por encima del contenido */
        }

        .navbar-brand,
        .nav-link {
            color: white;
        }

        .nav-link {
            margin-left: 20px;
        }

        /* Estilos adicionales para asegurar responsividad */
        @media (max-width: 767px) {
            .card-body {
                padding: 15px;
                /* Reducir el espacio interno en pantallas pequeñas */
            }

            .btn-create-course {
                padding: 16px 22px;
                /* Ajuste del padding para el botón en pantallas pequeñas */
                font-size: 16px;
                /* Ajuste del tamaño de fuente para el botón en pantallas pequeñas */
            }
        }

        body {
            padding-top: 60px;
            /* Ajuste del padding-top para el cuerpo del documento */
            padding-bottom: 60px;
            /* Añadido para el footer */
            position: relative;
            /* Añadido para establecer un contexto de posición para el footer */
            min-height: 100vh;
            /* Asegura que el contenido ocupe al menos el 100% de la altura de la ventana */
        }

        /* Añadido para ajustar el margen superior del título y de la tabla */
        .container-title {
            margin-top: 100px;
            /* Ajuste del margen superior para el título */
        }

        .container-table {
            margin-top: 20px;
            /* Ajuste del margen superior para la tabla */
            margin-bottom: 60px;
            /* Ajuste del margen inferior para el footer */
            min-height: calc(100vh - 220px);
            /* Ajuste de la altura mínima para el contenido */
        }

        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-graduation-cap"></i> Academia de Cursos</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="fas fa-home"></i> Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><i class="fas fa-user"></i> Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid container-title">
        <h2 class="text-center">Visualización de Cursos</h2>
    </div>

    <div class="container-fluid container-table">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body">
                        <a href="course/create.php" class="btn-create-course"><i class="fas fa-plus-circle"></i> Crear Curso</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course) : ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['title']); ?></td>
                                            <td><?php echo htmlspecialchars($course['description']); ?></td>
                                            <td><?php echo htmlspecialchars($course['status']); ?></td>
                                            <td>
                                                <a href="course/view.php?id=<?php echo $course['id']; ?>" class="btn btn-info btn-sm btn-action"><i class="fas fa-eye"></i></a>
                                                
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-2">

    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

