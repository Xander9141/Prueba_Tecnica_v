<?php
// Incluir archivo de configuración y verificar sesión de usuario
require '../config.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// Verificar si se proporciona un ID válido de curso
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../dashboard.php");
    exit();
}

// Obtener el ID del curso desde el parámetro GET
$course_id = $_GET['id'];

// Consultar la base de datos para obtener el curso específico
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    // Si no se encuentra el curso, redirigir de vuelta al dashboard
    header("Location: ../dashboard.php");
    exit();
}

// Obtener los datos del curso
$course = $result->fetch_assoc();

// Cerrar la consulta y la conexión
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualización de Curso - Academia de Cursos</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Añade estilos específicos para corregir el problema del navbar */
        body {
            padding-top: 60px; /* Ajuste del padding-top para el cuerpo del documento */
        }
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .container-content {
            margin-top: 80px; /* Ajuste del margen superior para el contenido */
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
                        <a class="nav-link" href="../dashboard.php"><i class="fas fa-arrow-left"></i> Volver al Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container container-content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h2>
                        <p class="card-text"><strong>Descripción:</strong> <?php echo htmlspecialchars($course['description']); ?></p>
                        <p class="card-text"><strong>Estado:</strong> <?php echo htmlspecialchars($course['status']); ?></p>
                        <!-- Otros detalles del curso según necesidad -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
