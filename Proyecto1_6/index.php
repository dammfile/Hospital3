<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
// PARA ELIMINAR EL MENSAJE LUEGO DE SER ENVIADO
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/persona.css">
    <link rel="icon" href="assets/favicon.ico">
    <title>Ingreso</title>
</head>
<body>
<div class="anim">
<header>
<h1>INGRESO USUARIO</h1>
</header>
<div class="contenido">
    
    <div class="form">
    <h2>Ingrese sus datos</h2>
    <form action="php/basephp/logverify.php" method="POST">
    <label for="cedula">Usuario</label>
        <input type="text" name="usuario" id="usuario" placeholder="Ingrese su Usuario" required>
    
    <label for="nombre">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Ingrese su Contraseña" required>
        
    <div class="btn-container">
            <input type="submit" class="btn" value="INGRESAR">
        </div>
    </form>
    </div>
</div>
</div>
</body>
</html>