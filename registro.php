<?php
require 'conexion.php';

function validarPassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[\\W_]).{8,}$/', $password);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!validarPassword($password)) {
        echo "La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $email, $passwordHash]);

    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head><title>Registro</title></head>
<body>
    <link rel="stylesheet" href="css/style.css">
    <h1>Registro de Usuario</h1>
    <form method="POST">
        Nombre: <input type="text" name="nombre" required><br>
        Email: <input type="email" name="email" required><br>
        Contraseña: <input type="password" name="password" required><br>
        <input type="submit" value="Registrarse">
    </form>
</body>
</html>
