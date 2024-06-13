<?php
require 'config.php'; // Incluir archivo de configuración

// Inicializar sesión si no está iniciada
session_start();

// Verificar si el usuario ya ha iniciado sesión
if (isset($_SESSION['user'])) {
    header("Location: index.php"); // Redirigir a index.php si el usuario ya ha iniciado sesión
    exit();
}

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario existe
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión y redirigir al panel de control
            $_SESSION['user'] = $user;
            header("Location: index.php"); // Redirigir a index.php después del inicio de sesión exitoso
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró una cuenta con ese correo electrónico.";
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
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-graduation-cap"></i> Academia de Cursos</a>
        </div>
    </nav>
    <div class="container" style="display: flex; margin-top: 100px;">
        <div style="flex: 1;">
            <img src="assets/images/curso.jpg" alt="Imagen del curso" style="width: 100%; height: 100vh; object-fit: cover;">
        </div>
        <div style="flex: 1; padding: 20px; display: flex; justify-content: center; align-items: center;">
            <div class="card">
                <h1>Inicio de Sesión</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required><br>

                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required><br>

                    <input type="submit" value="Iniciar Sesión">
                </form>
                <p>¿No tienes una cuenta? <a href="register.php">Regístrate</a></p>
            </div>
        </div>
    </div>
</body>
</html>
