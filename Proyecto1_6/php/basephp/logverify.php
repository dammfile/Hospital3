<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreUsuario = $_POST['usuario'];
    $contrasenaUsuario = $_POST['password'];

    $sql = "SELECT * FROM Usuarios WHERE usuario = '$nombreUsuario' AND password = '$contrasenaUsuario'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        header("Location: ../../home.html");
        exit(); 
    } else {
        // FALLO AL INICIAR SESION
        session_start();
        $_SESSION['error'] = "El usuario o contraseña no son correctos";
        header("Location: ../../index.php");
        exit();

    }
}

$conn->close();
?>
