<?php
session_start();
require_once '../config/database.php';

$db = new Database();
$con = $db->conectar();

if (isset($_POST['eliminar'])) {
    $id = $_POST['id_usuario'];
    $sql = $con->prepare("DELETE FROM usuario WHERE id_usuario = ?");
    $sql->execute([$id]);
    header("Refresh:0");
}

$sql = $con->prepare("SELECT u.id_usuario, u.nombre, u.email, r.id_role, r.nombre_rol FROM usuario AS u 
INNER JOIN roles AS r ON u.id_role = r.id_role;");

$sql->execute();
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .btn-sm {
            margin: 2px;
        }
    </style>
</head>

<body>

<div class="container mt-4">

        <h2>Gestión de Usuarios</h2>

        <a href="admin.php" class="btn btn-primary mb-3">volver</a>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>nombre</th>
                        <th>email</th>
                        <th>roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= $u['id_usuario'] ?></td>
                            <td><?= $u['nombre'] ?></td>
                            <td><?= $u['email'] ?></td>
                            <td><?= $u['nombre_rol'] ?></td>

                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="id_usuario" value="<?= $u['id_usuario'] ?>">

                                    <button class="btn btn-sm btn-danger" name="eliminar"
                                        onclick="return confirm('Estás seguro de eliminar este usuario')">
                                        Eliminar
                                    </button>
                                        
                                    <a href=""
                                    onclick="window.open('updateuser.php?id_usuario=<?= $u['id_usuario'] ?>', '', 'width=500, height=500, toolbar=no'); return false;"
                                    class="btn btn-sm btn-warning">Editar</a>

                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</body>
</html>
