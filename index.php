<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>recuperacion evaluacion</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
body {
font-family: 'Lexend', sans-serif;
background-color: #f6f7f9;
min-height: 100vh;
display: flex;
align-items: center;
justify-content: center;
color: #222;
}

.card-login {
background: #fff;
border: none;
border-radius: 1rem;
box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
width: 100%;
max-width: 360px;
padding: 2rem;
text-align: center;
}


</style>
</head>
<body>

<div class="card card-login">
<h2>Iniciar Sesión</h2>

<form action="includes/inicio.php" method="POST">
<div class="mb-3">
<input type="text" class="form-control" name="email" placeholder="email" required>
</div>
<div class="mb-3">
<input type="password" class="form-control" name="password" placeholder="Contraseña" required>
</div>
<button type="submit" class="btn btn-primary w-100 py-2" name="entrar">
Ingresar
</button>
</form>
<div class="acciones"><br>
<a href="includes/registrarse.php" class="d-block">Registrarse</a>
</div>
</div>

</body>
</html>