<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id']) || !isset($_POST['curso_id']) || !isset($_POST['horario_id'])) {
    header("Location: seleccionar_curso.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$curso_id = $_POST['curso_id'];
$horario_id = $_POST['horario_id'];

$stmt = $pdo->prepare("INSERT INTO inscripciones (usuario_id, curso_id, horario_id) VALUES (?, ?, ?)");
$stmt->execute([$usuario_id, $curso_id, $horario_id]);

header("Location: confirmacion.php?curso_id=$curso_id&horario_id=$horario_id");
