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
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: black;
        }
        .delete-card {
            width: 70%;
            background: #9CECFB;
            background: -webkit-linear-gradient(to top, #0052D4, #65C7F7, #9CECFB);
            background: linear-gradient(to top, #0052D4, #65C7F7, #9CECFB);
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
            color: white;
            margin-bottom: 20px;
        }
        .delete-card p {
            color: white;
            margin-bottom: 20px;
        }
        .btn-delete {
            background-color: #dc3545;
            border: none;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="delete-card">
            <h1>Eliminar Curso</h1>
            <p>¿Estás seguro de que quieres eliminar este curso?</p>
            <form action="" method="post">
                <button type="submit" class="btn-delete" name="delete">Eliminar Curso</button>
            </form>
        </div>
    </div>
</body>
</html>
