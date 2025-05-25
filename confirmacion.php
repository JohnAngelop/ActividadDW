<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id']) || !isset($_GET['curso_id']) || !isset($_GET['horario_id'])) {
    header("Location: index.php");
    exit;
}

$stmt1 = $pdo->prepare("SELECT titulo FROM cursos WHERE id = ?");
$stmt1->execute([$_GET['curso_id']]);
$curso = $stmt1->fetch();

$stmt2 = $pdo->prepare("SELECT horario FROM horarios WHERE id = ?");
$stmt2->execute([$_GET['horario_id']]);
$horario = $stmt2->fetch();
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/style.css">
<head><title>Confirmación</title></head>
<body>
    <h1>¡Inscripción Confirmada!</h1>
    <p><strong>Curso:</strong> <?= htmlspecialchars($curso['titulo']) ?></p>
    <p><strong>Horario:</strong> <?= htmlspecialchars($horario['horario']) ?></p>
    <a href="index.php">Volver al inicio</a>
</body>
</html>
