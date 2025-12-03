<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

if (!isset($_GET['id_usuario'])) {
    echo "<script>alert('Usuario no encontrado'); window.location='adminis_user.php';</script>";
    exit();
}

$id = $_GET['id_usuario'];

$sql = $con->prepare("SELECT * FROM usuario WHERE id_usuario = ?");
$sql->execute([$id]);
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo "<script>alert('Usuario inválido'); window.location='adminuser.php';</script>";
    exit();
}

if (isset($_POST['actualizar'])) {

    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $rol = $_POST['id_role'];

    if (!empty($_POST['password'])) {
        $newPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $upd = $con->prepare("UPDATE usuario SET nombre=?, email=?, password=? WHERE id_usuario=?");
        $upd->execute([$nombre, $email, $newPass, $id]);
    } else {
        $upd = $con->prepare("UPDATE usuario SET nombre=?, email=?, id_estado=? WHERE id_usuario=?");
        $upd->execute([$nombre, $email, $estado, $id]);
    }

    echo "<script>alert('Usuario actualizado correctamente'); window.location='adminis_user.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light text-white">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card p-4 bg-secondary">
        <h3 class="text-center">Editar usuario</h3>

        <form method="POST">

            <label class="mt-2">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $usuario['nombre'] ?>" required>

            <label class="mt-2">email</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>" required>

            
            <label class="mt-2">Nueva contraseña (opcional)</label>
            <input type="password" name="password" class="form-control" placeholder="Escribir solo si deseas cambiarla" required>

            <button type="submit" name="actualizar" class="btn btn-warning mt-3 w-100">Actualizar</button>

            <a href="adminis_user.php" class="btn btn-light mt-2 w-100">Volver</a>
        </form>
    </div>
</div>

</body>
</html>
