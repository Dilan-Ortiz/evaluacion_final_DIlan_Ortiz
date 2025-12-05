<?php
session_start();
require_once("../config/database.php");
$db = new Database();
$con = $db->conectar();

if (!isset($_GET['id_nota'])) {
    echo "<script>alert('no se encnotro la nota'); window.location='notas.php';</script>";
    exit();
}

$id_nota = $_GET['id_nota'];

$sql = $con->prepare("SELECT * FROM notas WHERE id_nota = ?");
$sql->execute([$id_nota]);
$nota = $sql->fetch(PDO::FETCH_ASSOC);

if (!$nota) {
    echo "<script>alert('La nota no existe'); window.location='notas.php';</script>";
    exit();
}

if (isset($_POST['actualizar'])) {

    $tipo_nota   = $_POST['tipo_nota'];
    $valor_nota  = $_POST['valor_nota'];
    $id_carrera  = $_POST['id_carrera'];
    $id_semestre = $_POST['id_semestre'];

    $upd = $con->prepare("UPDATE notas 
        SET tipo_nota=?, valor_nota=?, id_carrera=?, id_semestre=?
        WHERE id_nota=?");

    $upd->execute([$tipo_nota, $valor_nota, $id_carrera, $id_semestre, $id_nota]);

    echo "<script>alert('Nota actualizada correctamente'); window.location='notas.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Nota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light text-dark">

<div class="container mt-5" style="max-width: 600px;">
    <div class="card p-4 bg-white shadow">
        <h3 class="text-center">Editar Nota</h3>

        <form method="POST">

            <label class="mt-2">Tipo de Nota</label>
            <select name="tipo_nota">
                <option value="">Seleccione uno</option>
                <option value="parcial" <?= $nota['tipo_nota'] == 'parcial'?>>parcial</option>
                <option value="final" <?= $nota['tipo_nota'] == 'final'?>>final</option>
                <option value="taller" <?= $nota['tipo_nota'] == 'taller'?>>taller</option>
                <option value="quiz" <?= $nota['tipo_nota'] == 'quiz'?>>quiz</option>
            </select><br>

            <label class="mt-2">Valor de la Nota</label>
            <input type="number" step="0.1" name="valor_nota" class="form-control" 
                value="<?= $nota['valor_nota'] ?>" required>

            <label class="mt-2">Carrera</label>
            <select name="id_carrera">
                <option value="">Seleccione uno</option>
                <?php
                $control = $con->prepare("SELECT * FROM carrera");
                $control->execute();

                while ($fila = $control->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($fila['id_carrera'] == $nota['id_carrera']);
                    echo "<option value='" . $fila['id_carrera'] . "' $selected>" . $fila['nombre_carrera'] . "</option>";
                }
                ?>
            </select><br>

            <label class="mt-2">Semestre</label>
            <select name="id_semestre">
                <option value="">Seleccione uno</option>
                <?php
                $control2 = $con->prepare("SELECT * FROM semestre");
                $control2->execute();

                while ($fila2 = $control2->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($fila2['id_semestre'] == $nota['id_semestre']);
                    echo "<option value='" . $fila2['id_semestre'] . "' $selected>" . $fila2['nombre_semestre'] . "</option>";
                }
                ?>
            </select><br>

            <button type="submit" name="actualizar" class="btn btn-warning mt-3 w-100">Actualizar</button>
            <a href="notas.php" class="btn btn-secondary mt-2 w-100">Volver</a>

        </form>

    </div>
</div>

</body>
</html>
