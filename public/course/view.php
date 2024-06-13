<?php
require '../config.php';
session_start();

// Obtener el ID del curso desde la URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($course_id <= 0) {
    echo "ID de curso no válido.";
    exit();
}

// Consultar la base de datos para obtener los detalles del curso
$stmt = $conn->prepare("SELECT courses.*, users.name AS creator_name FROM courses JOIN users ON courses.user_id = users.id WHERE courses.id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Curso no encontrado.";
    exit();
}

$course = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Curso</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
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
            background-image: url('../assets/images/inicio.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .action-links {
            margin-top: 20px;
        }

        .action-links a {
            margin-right: 10px;
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
                        <a class="nav-link" href="../dashboard.php"><i class="fas fa-chalkboard-teacher"></i> Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../profile.php"><i class="fas fa-user"></i> Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
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
                    <h5 class="card-header"><?php echo htmlspecialchars($course['title']); ?></h5>
                    <div class="card-body">
                        <p><strong>Descripción:</strong> <?php echo htmlspecialchars($course['description']); ?></p>
                        <p><strong>Estado:</strong> <?php echo ucfirst($course['status']); ?></p>
                        <p><strong>Creador:</strong> <?php echo htmlspecialchars($course['creator_name']); ?></p>

                        <?php
                        // Mostrar enlaces de acción solo si el usuario es el creador del curso
                        if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $course['user_id']) {
                            echo '<div class="action-links">';
                            echo '<a href="../dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>';
                            echo '<a href="edit.php?id=' . $course_id . '" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</a>';
                            echo '<a href="delete.php?id=' . $course_id . '" class="btn btn-danger"><i class="fas fa-trash"></i> Eliminar</a>';
                            echo '</div>';
                        } else {
                            echo '<a href="../dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
