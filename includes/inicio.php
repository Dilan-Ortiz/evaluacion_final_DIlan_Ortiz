<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

if (isset($_POST['entrar'])) {
    $email = trim($_POST['email']);
    $contrasena = $_POST['password'];

    if ($email === "" || $contrasena === "") {
        echo '<script>alert("Datos vacíos"); location="../index.php";</script>';
        exit();
    }

    $stmt = $con->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->execute([$email]);
    $fila = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$fila) {
        echo '<script>alert("email incorrecto"); location="../index.php";</script>';
        exit();
    }

    if (!password_verify($contrasena, $fila['password'])) {
        echo '<script>alert("Contraseña o email incorrecta"); location="../index.php";</script>';
        exit();
    }

    $_SESSION['id_usuario'] = $fila['id_usuario'];
    $_SESSION['email'] = $fila['email'];
    $_SESSION['id_role'] = $fila['id_role'];

    if ($fila['id_role'] == 1) {
        header("Location: ../admin/admin.php");
        exit();
    }

    if ($fila['id_role'] == 2) {
        header("Location: ../user/usuario.php");
        exit();
    }

    echo '<script>alert("Rol de usuario desconocido"); location="../index.php";</script>';
}
?>
