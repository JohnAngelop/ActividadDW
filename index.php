<?php
session_start();
require 'conexion.php';

$tiempo_maximo = 900;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $tiempo_maximo)) {
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=1");
    exit;
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

// Consultar cursos disponibles
$cursos = $pdo->query("SELECT * FROM cursos")->fetchAll();

// Verificar si usuario tiene inscripciones
$stmt = $pdo->prepare("SELECT COUNT(*) FROM inscripciones WHERE usuario_id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$cantidad_inscripciones = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Portal de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-info">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Cursos Online</a>
    <div>
        <span class="navbar-text me-3">Hola, <?= htmlspecialchars($_SESSION['nombre']) ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
    </div>
  </div>
</nav>

<main class="container">
    <h1>Bienvenido al Portal de Cursos Online</h1>

    <?php if ($cantidad_inscripciones == 0): ?>
        <div class="alert alert-warning">
            <p>No estás inscrito en ningún curso todavía.</p>
            <a href="seleccionar_curso.php" class="btn btn-primary">Inscribirse a un Curso</a>
        </div>
    <?php endif; ?>

    <h2>Cursos Disponibles</h2>
    <ul class="list-group">
        <?php foreach ($cursos as $curso): ?>
            <li class="list-group-item">
                <strong><?= htmlspecialchars($curso['titulo']) ?></strong><br />
                <?= htmlspecialchars($curso['descripcion']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

