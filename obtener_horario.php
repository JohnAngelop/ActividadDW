<?php
require 'conexion.php';

if (isset($_GET['curso_id'])) {
    $stmt = $pdo->prepare("SELECT id, horario FROM horarios WHERE curso_id = ?");
    $stmt->execute([$_GET['curso_id']]);
    echo json_encode($stmt->fetchAll());
}
