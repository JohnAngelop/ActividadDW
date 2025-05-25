<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'conexion.php';

$tiempo_maximo = 900; // 15 minutos
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tiempo_maximo)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

try {
    $cursos = $pdo->query("SELECT * FROM cursos")->fetchAll();
} catch (PDOException $e) {
    die("Error al obtener cursos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Portal de Cursos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Bienvenido al Portal de Cursos Online</h1>

    <?php if (isset($_SESSION['usuario_id'])): ?>
        <p>Hola, <?= htmlspecialchars($_SESSION['nombre']) ?> | <a href="logout.php">Cerrar sesión</a></p>
        <h2>Cursos Disponibles</h2>
        <ul>
            <?php foreach ($cursos as $curso): ?>
                <li>
                    <strong><?= htmlspecialchars($curso['titulo']) ?></strong><br>
                    <?= htmlspecialchars($curso['descripcion']) ?><br>
                    <a href="seleccionar_curso.php">Inscribirse</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p><a href="login.php">Iniciar sesión</a> o <a href="registro.php">Registrarse</a></p>
    <?php endif; ?>
</body>
</html>

