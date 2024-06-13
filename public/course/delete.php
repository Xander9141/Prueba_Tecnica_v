<?php
require '../config.php';
session_start();

// Verificar si se ha recibido el ID del curso a eliminar
if (isset($_GET['id'])) {
    $course_id = intval($_GET['id']);

    // Consultar si el curso existe
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Curso no encontrado.";
        exit();
    }

    // Confirmar eliminación del curso si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Eliminar el curso de la base de datos
        $delete_stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
        $delete_stmt->bind_param("i", $course_id);

        if ($delete_stmt->execute()) {
            // Redirigir al dashboard después de la eliminación exitosa
            header("Location: ../dashboard.php");
            exit();
        } else {
            echo "Error al eliminar el curso: " . $delete_stmt->error;
        }
    }
} else {
    echo "ID de curso no especificado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Curso</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        
        .delete-card {
            width: 70%;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .delete-card:hover {
            transform: translateY(-5px);
        }
        .delete-card h1 {
            color: #721c24;
            margin-bottom: 20px;
        }
        .delete-card p {
            color: #721c24;
            margin-bottom: 20px;
        }
        .btn-delete, .btn-cancel {
            border: none;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 5px;
            width: calc(50% - 10px);
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        .btn-cancel {
            background-color: #6c757d;
        }
        .btn-cancel:hover {
            background-color: #5a6268;
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

    <div class="container">
        <div class="delete-card center">
            <h1>Eliminar Curso</h1>
            <p>¿Estás seguro de que quieres eliminar este curso?</p>
            <form action="" method="post">
                <button type="submit" class="btn-delete" name="delete">Eliminar Curso</button>
                <a href="../dashboard.php" class="btn-cancel">Cancelar</a>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
