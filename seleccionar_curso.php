<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$cursos = $pdo->query("SELECT * FROM cursos")->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Curso</title>
</head>
<body>
    <link rel="stylesheet" href="css/style.css">
    <h1>Selecciona un curso y un horario</h1>

    <form method="POST" action="enroll.php">
        <label>Curso:</label>
        <select name="curso_id" id="curso" required onchange="cargarHorarios(this.value)">
            <option value="">-- Selecciona --</option>
            <?php foreach ($cursos as $curso): ?>
                <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['titulo']) ?></option>
            <?php endforeach; ?>
        </select>

        <br><br>
        <label>Horario:</label>
        <select name="horario_id" id="horario" required>
            <option value="">-- Selecciona un horario --</option>
        </select>

        <br><br>
        <input type="submit" value="Confirmar Inscripción">
    </form>

    <script>
        function cargarHorarios(cursoId) {
            fetch('obtener_horarios.php?curso_id=' + cursoId)
                .then(response => response.json())
                .then(data => {
                    const horario = document.getElementById('horario');
                    horario.innerHTML = '<option value="">-- Selecciona un horario --</option>';
                    data.forEach(h => {
                        horario.innerHTML += `<option value="${h.id}">${h.horario}</option>`;
                    });
                });
        }
    </script>
</body>
</html>
