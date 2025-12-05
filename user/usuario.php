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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold " href="usuario.php"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">

</svg> BIenvenido usuario <?php echo $usuario['nombre']?></a>
<a href="../index.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container m-5">
        <h2 class="text-center mb-4">Notass actuales</h2>
        <p class="text-center">Aqui podras ver todas tus notas en cada materia</p>

        <div class="d-flex flex-wrap justify-content-center gap-4">
            <?php
            $sql_notas = $con->prepare("SELECT n.tipo_nota, c.nombre_carrera ,n.valor_nota, n.id_carrera, n.id_semestre, n.fecha_registro, u.id_usuario, u.nombre, u.email 
            FROM usuario AS u 
            INNER JOIN notas AS n ON u.id_usuario = n.id_usuario 
            INNER JOIN carrera AS c ON n.id_carrera = c.id_carrera 
            WHERE u.id_usuario = ?;");
            $sql_notas->execute([$doc]);
            $resultado12 = $sql_notas->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado12 as $resultado) {
            ?>
                <div class="card" style="width: 18rem;">
                
                    <div class="card-body">
                        <h5 class="card-tittle">Documento <?php echo $resultado['id_usuario']; ?></h5>
                        <h5 class="card-title">Nombre <?php echo $resultado['nombre']; ?></h5>
                        <h5 class="card-text">Email <?php echo $resultado['email']; ?></h5>
                        <p class="card-text">Tipo de nota <?php echo $resultado['tipo_nota']; ?></p>
                        <p class="card-text">Valor de la nota<?php echo $resultado['valor_nota']; ?></p>
                        <p class="card-text">Carrera <?php echo $resultado['nombre_carrera']; ?></p>
                        <p class="card-text">id del semestre <?php echo $resultado['id_semestre']; ?></p>
                        <p class="card-text">Fecha de registro de la nota <?php echo $resultado['fecha_registro']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>