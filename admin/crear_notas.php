<?php
session_start();
require_once '../config/database.php';
$db = new Database();
$con = $db->conectar();

if (isset($_POST['guardar'])) {

    $nombre_carrera = $_POST['nombre_carrera'];

    $sql = $con->prepare("INSERT INTO carrera (nombre_carrera) VALUES (?)");
    $sql->execute([$nombre_carrera]);

    echo "<script>alert('Carrera registrada correctamente');</script>";
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
<div class="card p-4">
    <h3 class="text-center">Registrar Nota</h3>
    <a href="admin.php" class="btn btn-primary mb-3">volver</a>
    
    <form method="POST">
        <h3 class="text-center">Registrar nombre de la carrera</h3>
        
        <input class="form-control mb-2" name="nombre_carrera" placeholder="nombre de la carrera" required>
        
        <button class="btn btn-primary mt-4 w-100" name="guardar">Guardar</button>
    </form>

</body>
</html>
