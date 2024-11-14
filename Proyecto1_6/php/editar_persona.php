<?php
require 'basephp/conexion.php'; 

// Comprobar si hay una cédula enviada
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    // Consulta para obtener el usuario con la cédula seleccionada
    $sql = "SELECT numCedula, nombre, apellido, genero, fecnac FROM persona WHERE numCedula = '$cedula'"; 
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conn);
        exit();
    }

    $usuario = mysqli_fetch_assoc($result);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "No se recibió ninguna cédula.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/persona.css">
    <link rel="icon" href="../assets/favicon.ico">
    <title>Registrar</title>
</head>
<body>
<div class="anim">
<header>
<h1>Editar Persona</h1>
</header>
<div class="contenido">
    
    <div class="form">
    <h2>Ingrese sus nuevos datos</h2>
    <form action="basephp/editar.php" method="POST">
    <label for="cedula">Cedula:</label>
        <input type="number" name="cedula" id="cedula" placeholder="Ingrese Cedula" value="<?php echo $usuario['numCedula']; ?>">
    
    <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre" value="<?php echo $usuario['nombre']; ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo se permiten letras y espacios">

    <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" placeholder="Ingrese Apellido" value="<?php echo $usuario['apellido']; ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo se permiten letras y espacios">

    <label for="genero">Genero:</label>
            <select name="genero" id="genero">
            <option value="<?php echo $usuario['genero']; ?>"><?php echo "Actual: " .$usuario['genero']; ?></option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otros</option>
            </select>

    <label for="fecnac">Fecha de Nacimiento:</label>
    <input type="date" name="fecnac" id="fecnac" value="<?php echo $usuario['fecnac']; ?>">

    <div class="btn-container">
            <input type="submit" class="btn" value="GUARDAR">
        </div>
    </form>
    </div>
</div>
<a href="../home.html" class="backbtn">Atrás</a>
</div>
</body>
</html>