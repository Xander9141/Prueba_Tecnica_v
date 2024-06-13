<?php
require '../config.php';
session_start();

// Procesamiento del formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar y validar los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $user_id = $_POST['user_id'];

    // Verificar que todos los datos se están recibiendo correctamente
    if (empty($titulo) || empty($descripcion) || empty($estado) || empty($user_id)) {
        echo "Por favor complete todos los campos.";
        exit();
    }

    // Verificar el valor de $estado antes de insertarlo
    if (!in_array($estado, ['active', 'inactive'])) {
        echo "Estado inválido.";
        exit();
    }

    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO courses (title, description, status, user_id) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conn->error;
        exit();
    }

    // Vincular los parámetros
    $stmt->bind_param("sssi", $titulo, $descripcion, $estado, $user_id);

    // Ejecutar la consulta y verificar el resultado
    if ($stmt->execute()) {
        // Redirigir a dashboard.php después de la creación exitosa
        header("Location: ../dashboard.php");
        exit();
    } else {
        echo "Error al crear el curso: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
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
        .table-card {
            width: 70%;
            background: #9CECFB;
            background: -webkit-linear-gradient(to top, #0052D4, #65C7F7, #9CECFB);
            background: linear-gradient(to top, #0052D4, #65C7F7, #9CECFB);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
            margin: auto; /* Centrar la tarjeta horizontalmente */
            margin-top: 20px; /* Espacio arriba de la tarjeta */
        }
        .table-card:hover {
            transform: translateY(-5px);
        }
        .table-card h1 {
            color: white;
            margin-bottom: 20px;
        }
        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-card table th, .table-card table td {
            border: none;
            padding: 10px;
            text-align: left;
            color: white;
        }
        .table-card table th {
            font-weight: normal;
            width: 30%;
        }
        .table-card table td {
            width: 70%;
        }
        input, textarea, select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn-create {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-create:hover {
            background-color: #0056b3;
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
        <div class="table-card">
            <h1>Crear Curso</h1>
            <form action="" method="post">
                <table>
                    <tr>
                        <th><label for="titulo">Título:</label></th>
                        <td><input type="text" id="titulo" name="titulo" required></td>
                    </tr>
                    <tr>
                        <th><label for="descripcion">Descripción:</label></th>
                        <td><textarea id="descripcion" name="descripcion" required></textarea></td>
                    </tr>
                    <tr>
                        <th><label for="estado">Estado:</label></th>
                        <td>
                            <select id="estado" name="estado" required>
                                <option value="active">Activo</option>
                                <option value="inactive">Inactivo</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="user_id">Usuario:</label></th>
                        <td>
                            <select id="user_id" name="user_id" required>
                                <?php
                                // Consulta para obtener la lista de usuarios
                                $query = "SELECT id, name FROM users";
                                $result = $conn->query($query);
                                if (!$result) {
                                    echo "Error al ejecutar la consulta: " . $conn->error;
                                } else {
                                    // Mostrar opciones de usuario en la lista desplegable
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn-create">Crear Curso</button>
            </form>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
