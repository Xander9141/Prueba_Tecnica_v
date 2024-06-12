<?php
require '../config.php';
session_start();

// Procesamiento del formulario si se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar y validar los datos del formulario
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $user_id = $_SESSION['user_id'];

    // Insertar los datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO cursos (titulo, descripcion, estado, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $descripcion, $estado, $user_id);

    if ($stmt->execute()) {
        echo "Curso creado exitosamente.";
    } else {
        echo "Error al crear el curso: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
    <!-- Enlace a tu archivo CSS para estilos personalizados -->
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
            background-color: #f5f5f5;
        }

        .card {
            width: 400px;
            background: #9CECFB;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to top, #0052D4, #65C7F7, #9CECFB);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to top, #0052D4, #65C7F7, #9CECFB); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        input,
        textarea,
        select {
            width: calc(100% - 40px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
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
        }

        .btn-create:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <!-- Contenedor principal con fondo -->
    <div class="container">
        <!-- Tarjeta para el formulario -->
        <div class="card">
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <h1>Crear Curso</h1>
           <!-- Formulario -->
<form action="" method="post">

<label for="titulo">Título:</label><br>
<input type="text" id="titulo" name="titulo" required><br>

<label for="descripcion">Descripción:</label><br>
<textarea id="descripcion" name="descripcion" required></textarea><br>

<label for="estado">Estado:</label><br>
<select id="estado" name="estado" required>
    <option value="activo">Activo</option>
    <option value="inactivo">Inactivo</option>
</select><br>

<!-- Lista desplegable de usuarios -->
<label for="user_id">Usuario:</label><br>
<select id="user_id" name="user_id" required>
    <?php
    // Consulta para obtener la lista de usuarios
    $query = "SELECT user_id, username FROM users";
    $result = $conn->query($query);

    // Mostrar opciones de usuario en la lista desplegable
    while ($row = $result->fetch_assoc()) {
        echo "<option value='" . $row['user_id'] . "'>" . $row['username'] . "</option>";
    }
    ?>
</select><br>

<!-- Botón con diseño personalizado -->
<button type="submit" class="btn-create">Crear Curso</button>
</form>

        </div>
    </div>

    <!-- Enlace a la biblioteca de iconos -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
