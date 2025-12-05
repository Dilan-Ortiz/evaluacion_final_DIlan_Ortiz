<?php

session_start();
require_once '../config/database.php';

$db = new Database();
$con = $db->conectar();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../index.php");
    exit;
}
$doc = $_SESSION['id_usuario'];
$sql = $con->prepare("SELECT * FROM usuario where id_usuario = ?");
$sql->execute([$doc]);
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>usuarios</title>
</head>
<body>
    <h1>BIenvenido usuario <?php echo $usuario['nombre']?></h1>
</body>
</html>