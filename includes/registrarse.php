<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

if (isset($_POST['registrar'])) {
    $doc = $_POST['id_usuario'];
    $nombre = trim($_POST['nombre']);
    $email  = trim($_POST['email']);
    $pass   = $_POST['password'];
    $rol = 2;

    if ($doc === "" ||$nombre === "" || $email === "" || $pass === "") {
        echo '<script>alert("EXISTEN DATOS VACÍOS");</script>';
        exit();
    }

    $sql = $con->prepare("SELECT id_usuario FROM usuario WHERE nombre = ? OR password = ?");
    $sql->execute([$nombre, $pass]);
    if ($sql->fetch()) { echo '<script>alert("El nombre o email ya están registrados");</script>';
        exit();}

    $hash = password_hash($pass, PASSWORD_DEFAULT);

    $insert = $con->prepare("INSERT INTO usuario (id_usuario, nombre, email, password, id_role) VALUES (?, ?, ?, ?, ? )");
    $insert->execute([$doc, $nombre, $email, $hash, $rol]);

    echo '<script>alert("Registro exitoso. Ya puedes iniciar sesión."); location="../index.php";</script>';
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <title>Registrarse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <form method="POST" class="w-100" style="max-width:360px;">
        <h3 class="text-center mb-3">Registrarse</h3>
        <input class="form-control mb-2" name="id_usuario" placeholder="numero de documento" required>
        <input class="form-control mb-2" name="nombre" placeholder="Nombre" required>
        <input class="form-control mb-2" name="email" type="email" placeholder="email" required>
        <input class="form-control mb-2" name="password" type="password" placeholder="Contraseña" required>
        <button class="btn btn-primary w-100" name="registrar" type="submit">Registrar</button>
        <div class="text-center mt-2"><a href="../index.php">Volver</a></div>
    </form>
    </div>
</body>
</html>
