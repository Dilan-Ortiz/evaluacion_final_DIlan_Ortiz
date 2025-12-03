<?php
session_start();
require_once '../config/database.php';
$db = new Database();
$con = $db->conectar();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php");
    exit;
}

$semestres = $con->query("SELECT * FROM semestre")->fetchAll(PDO::FETCH_ASSOC);
$carreras = $con->query("SELECT * FROM carrera")->fetchAll(PDO::FETCH_ASSOC);
$usuarios = $con->query("SELECT * FROM usuario WHERE id_role = 2")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['guardar'])) {

    $id_usuario = $_POST['id_usuario'];
    $id_semestre = $_POST['id_semestre'];
    $id_carrera = $_POST['id_carrera'];
    $tipo_nota = $_POST['tipo_nota'];
    $valor_nota = $_POST['valor_nota'];

    $id_admin = $_SESSION['id_usuario'];

    $sql = $con->prepare("INSERT INTO notas 
        (tipo_nota, valor_nota, id_usuario, id_carrera, id_semestre)
        VALUES (?, ?, ?, ?, ?)
    ");

    $sql->execute([$tipo_nota, $valor_nota, $id_usuario, $id_carrera, $id_semestre]);

    echo "<script>alert('nta registrada correctamente');</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-4">

    <div class="card p-4">
        <h3 class="text-center">Registrar Nota</h3>

        <form method="POST">

            <label>Estudiante</label>
            <select name="id_usuario" class="form-select" required>
                <?php foreach ($usuarios as $u) { ?>
                    <option value="<?= $u['id_usuario'] ?>"><?= $u['nombre'] ?></option>
                <?php } ?>
            </select>

            <label class="mt-3">Semestre</label>
            <select name="id_semestre" class="form-select" required>
                <?php foreach ($semestres as $s) { ?>
                    <option value="<?= $s['id_semestre'] ?>"><?= $s['nombre_semestre'] ?></option>
                <?php } ?>
            </select>

            <label class="mt-3">Carrera</label>
            <select name="id_carrera" class="form-select" required>
                <?php foreach ($carreras as $c) { ?>
                    <option value="<?= $c['id_carrera'] ?>"><?= $c['nombre_carrera'] ?></option>
                <?php } ?>
            </select>

            <label class="mt-3">Tipo de nota</label>
            <select name="tipo_nota" class="form-select" required>
                <option value="parcial">Parcial</option>
                <option value="final">Final</option>
                <option value="taller">Taller</option>
                <option value="quiz">Quiz</option>
            </select>

            <label class="mt-3">Valor de nota</label>
            <input type="number" step="0.1" name="valor_nota" class="form-control" required>

            <button class="btn btn-primary mt-4 w-100" name="guardar">Guardar</button>
        </form>
    </div>

    <hr class="my-5">

    <h4 class="text-center">Listado de notas registradas</h4>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
        <tr>
            <th>Estudiante</th>
            <th>Carrera</th>
            <th>Semestre</th>
            <th>Tipo Nota</th>
            <th>Valor</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $sql_show = $con->query("SELECT n.valor_nota, n.tipo_nota,s.nombre_semestre, c.nombre_carrera, u.nombre AS estudiante
            FROM notas n INNER JOIN usuario u ON n.id_usuario = u.id_usuario
            INNER JOIN carrera c ON n.id_carrera = c.id_carrera INNER JOIN semestre s ON n.id_semestre = s.id_semestre
            ORDER BY n.id_nota DESC");

        foreach ($sql_show->fetchAll(PDO::FETCH_ASSOC) as $fila) { ?>
            <tr>
                <td><?= $fila['estudiante'] ?></td>
                <td><?= $fila['nombre_carrera'] ?></td>
                <td><?= $fila['nombre_semestre'] ?></td>
                <td><?= $fila['tipo_nota'] ?></td>
                <td><?= $fila['valor_nota'] ?></td>
            </tr>
        <?php } ?>

        </tbody>
    </table>

</div>

</body>
</html>
