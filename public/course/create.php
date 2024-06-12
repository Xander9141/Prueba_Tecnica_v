<?php
require '../config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO cursos (titulo, descripcion, estado, user_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $titulo, $descripcion, $estado, $user_id);

    if ($stmt->execute()) {
        echo "Curso creado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Curso</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">Academia de Cursos</a>
            <div class="navbar-nav">
                <a class="nav-link" href="../dashboard.php">Dashboard</a>
                <a class="nav-link" href="../logout.php">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Crear Curso</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="titulo">Título del Curso:</label><br>
            <input type="text" id="titulo" name="titulo" placeholder="Ingresa el título del curso" required><br>

            <label for="descripcion">Descripción del Curso:</label><br>
            <textarea id="descripcion" name="descripcion" placeholder="Ingresa la descripción del curso" required></textarea><br>

            <label for="estado">Estado del Curso:</label><br>
            <select id="estado" name="estado" required>
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select><br>

            <input type="submit" value="Crear Curso">
        </form>
    </div>
</body>
</html>
