<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';
$usuario_id = $_SESSION['usuario_id'];

$cursos = $pdo->query("SELECT * FROM cursos")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso_id = $_POST['curso_id'] ?? null;
    $horario_id = $_POST['horario_id'] ?? '';

    if ($curso_id && $horario_id) {
        // Verificar si ya está inscrito
        $stmt = $pdo->prepare("SELECT * FROM inscripciones WHERE usuario_id = ? AND curso_id = ?");
        $stmt->execute([$usuario_id, $curso_id]);
        if ($stmt->fetch()) {
            $mensaje = "Ya estás inscrito en este curso.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO inscripciones (usuario_id, curso_id, horario_id) VALUES (?, ?, ?)");
            $stmt->execute([$usuario_id, $curso_id, $horario_id]);
            header("Location: confirmacion.php?curso_id=" . $curso_id);
            exit;
        }
    } else {
        $mensaje = "Por favor selecciona curso y horario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inscribirse a un Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-primary">
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
    <h1 class="mb-4">Inscribirse a un Curso</h1>

    <?php if ($mensaje): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="post" class="mb-4">
        <div class="mb-3">
            <label for="curso_id" class="form-label">Curso</label>
            <select name="curso_id" id="curso_id" class="form-select" required>
                <option value="">Seleccione un curso</option>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['id'] ?>"><?= htmlspecialchars($curso['titulo']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="horario" class="form-label">Horario</label>
            <select name="horario" id="horario" class="form-select" required>
                <option value="">Seleccione un horario</option>
                <option value="Lunes 9am-11am">Lunes 9am-11am</option>
                <option value="Miércoles 4pm-6pm">Miércoles 4pm-6pm</option>
                <option value="Viernes 7pm-9pm">Viernes 7pm-9pm</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Confirmar Inscripción</button>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

