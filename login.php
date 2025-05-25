<?php
session_start();
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['LAST_ACTIVITY'] = time();
        header("Location: index.php");
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Iniciar sesión</title></head>
<body>
    <link rel="stylesheet" href="css/style.css">
    <h1>Iniciar sesión</h1>
    <?php if (isset($_GET['timeout'])): ?>
        <p style="color:red;">Sesión cerrada por inactividad.</p>
    <?php endif; ?>
    <form method="POST">
        Email: <input type="email" name="email" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <input type="submit" value="Entrar">
    </form>
</body>
</html>
