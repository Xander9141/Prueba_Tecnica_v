<?php
require 'config.php'; // Incluir archivo de configuración

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña

    // Verificar si el correo electrónico ya está registrado
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Insertar nuevo usuario en la base de datos
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $password);

        if ($stmt->execute()) {
            echo "Registro exitoso. Redirigiendo al panel de control...";
            header("Location: dashboard.php"); // Redirigir al panel de control después del registro exitoso
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $checkEmail->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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
                <h1>Registro de Usuario</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required><br>

                    <label for="email">Correo Electrónico:</label><br>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo electrónico" required><br>

                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required><br>

                    <label for="confirm_password">Confirmar Contraseña:</label><br>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirma tu contraseña" required><br>

                    <input type="submit" value="Registrarse">
                </form>
                <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html>
