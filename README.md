# Plataforma de Gestión de Cursos Online

## Descripción del Proyecto
Este proyecto consiste en una plataforma básica para la gestión de cursos online. Los usuarios pueden registrarse, iniciar sesión, crear y gestionar cursos, así como visualizar los cursos disponibles. La plataforma está desarrollada utilizando PHP, MySQL, HTML5, CSS, Bootstrap y jQuery.

## Funcionalidades
- **Autenticación de Usuarios**
  - Registro de usuarios con validación de correo electrónico.
  - Inicio de sesión y cierre de sesión.
  - Mantenimiento de la autenticación del usuario utilizando sesiones.

- **Gestión de Cursos**
  - **Crear Cursos:** Formulario para crear nuevos cursos con los campos: título, descripción, estado (activo/inactivo). Solo los usuarios autenticados pueden crear cursos.
  - **Editar Cursos:** Formulario para editar cursos existentes. Solo el usuario que creó el curso puede editarlo.
  - **Eliminar Cursos:** Funcionalidad para eliminar cursos. Solo el usuario que creó el curso puede eliminarlo.

- **Visualización de Cursos**
  - **Listado de Cursos:** Página que muestra una lista de todos los cursos disponibles. Cada curso muestra el título y un enlace para ver más detalles.
  - **Detalles del Curso:** Página de detalles que muestra la información completa del curso (título, descripción, estado) y enlaces para editar o eliminar el curso (si el usuario es el creador).

## Estructura del Proyecto
```plaintext
my-online-course-platform/
├── public/
│   ├── index.php
│   ├── register.php
│   ├── login.php
│   ├── dashboard.php
│   ├── course/
│   │   ├── create.php
│   │   ├── edit.php
│   │   ├── delete.php
│   │   ├── view.php
│   └── assets/
│       ├── css/
│       ├── js/
│       └── images/
├── src/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Helpers/
├── tests/
├── .gitignore
├── composer.json
├── README.md
└── database.sql

Instalación y Configuración
Prerrequisitos
Servidor web (e.g., Apache, Nginx)
PHP 7.4 o superior
MySQL 5.7 o superior
Composer
Instalación
Clona el repositorio en tu máquina local

Instala las dependencias de Composer
composer install

Configura el archivo config.php con los detalles de tu base de datos:
// config.php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'tu_usuario');
define('DB_PASSWORD', 'tu_contraseña');
define('DB_NAME', 'tu_base_de_datos');

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}



Asegúrate de que el directorio public/assets es accesible desde tu servidor web.

Uso
Registro de Usuario:


Inicio de Sesión:


Gestión de Cursos:

Una vez autenticado, accede a dashboard.php para gestionar tus cursos.
Contribución
Si deseas contribuir a este proyecto, por favor, sigue estos pasos:

Haz un fork del repositorio.
Crea una nueva rama (git checkout -b feature/nueva-funcionalidad).
Realiza tus cambios y haz commit (git commit -m 'Añadir nueva funcionalidad').
Haz push a la rama (git push origin feature/nueva-funcionalidad).
Abre un Pull Request.
Licencia
Este proyecto está licenciado bajo la Licencia MIT. Consulta el archivo LICENSE para más detalles.

Contacto
Para cualquier consulta o sugerencia, por favor, contacta a ramontorrres91.00@gmail.com



Este `README.md` cubre los aspectos esenciales del proyecto, incluidos la descripción, funcionalidades, 
