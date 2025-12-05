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
<path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
</svg> BIenvenido usuario <?php echo $usuario['nombre']?></a>
        </div>
    </nav>

    <div class="container m-5">
        <h2 class="text-center mb-4">Notass actuales</h2>
        <p class="text-center">Aqui podras ver todas tus notas en cada materia</p>

        <div class="d-flex flex-wrap justify-content-center gap-4">
            <?php
            $sql_notas = $con->prepare("SELECT * FROM notas WHERE id_usuario =?");
            $sql_notas->execute([$doc]);
            $resultado12 = $sql_notas->fetchAll(PDO::FETCH_ASSOC);
            foreach ($resultado12 as $resultado) {
            ?>
                <div class="card" style="width: 18rem;">
                
                    <div class="card-body">
                        <p class="card-text"><?php echo $resultado['id_usuario']; ?></p>
                        <p class="card-text"><?php echo $resultado['nombre']; ?></p>
                        <p class="card-text"><?php echo $resultado['email']; ?></p>
                        <h5 class="card-title"><?php echo $resultado['tipo_nota']; ?></h5>
                        <h5 class="card-title"><?php echo $resultado['valor_nota']; ?></h5>
                        <p class="card-text"><?php echo $resultado['id_carrera']; ?></p>
                        <p class="card-text"><?php echo $resultado['id_semestre']; ?></p>
                        <p class="card-text"><?php echo $resultado['fecha_registro']; ?></p>
                        <a href="adminpro.php" class="btn btn-primary">comprar</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>