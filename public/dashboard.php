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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 20px;
        }

        .btn-create-course {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 12px 24px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-create-course i {
            margin-right: 8px;
        }

        .btn-create-course:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-graduation-cap"></i> Academia de Cursos</a>
            <div class="navbar-nav">
                <a class="nav-link" href="logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>Visualización de Cursos</h2>
        <div class="card">
        <a href="course/create.php" class="btn-create-course"><i class="fas fa-plus-circle"></i>Crear Curso</a>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><?php echo $course['title']; ?></td>
                                <td><?php echo $course['description']; ?></td>
                                <td><?php echo $course['status']; ?></td>
                                <td>
                                    <!-- Aquí puedes agregar enlaces para ver detalles, editar o eliminar -->
                                    <a href="course/view.php?id=<?php echo $course['id']; ?>">Ver</a> |
                                    <a href="course/edit.php?id=<?php echo $course['id']; ?>">Editar</a> |
                                    <a href="course/delete.php?id=<?php echo $course['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este curso?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
            </div>
            
        </div>
    </div>
</body>
</html>
