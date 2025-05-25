<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$curso_id = $_GET['curso_id'] ?? null;

if (!$curso_id) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT titulo FROM cursos WHERE id = ?");
$stmt->execute([$curso_id]);
$curso = $stmt->fetch();

if (!$curso) {
    die("Curso no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Confirmación de Inscripción</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
  <div class="container">
    <a class="navbar-brand" href="index.php">Cursos Online</a>
    <div>
        <span class="navbar-text me-3">Hola, <?= htmlspecialchars($_SESSION['nombre']) ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
    </div>
  </div>
</nav>

<main class="container text-center">
    <div class="alert alert-success">
        <h2>¡Inscripción Confirmada!</h2>
        <p>Te has inscrito correctamente al curso: <strong><?= htmlspecialchars($curso['titulo']) ?></strong>.</p>
        <a href="index.php" class="btn btn-primary mt-3">Volver a Inicio</a>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
