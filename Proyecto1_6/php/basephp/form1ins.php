<?php
include 'validarcedula.php';
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Persona 
    $cedula = $_POST["cedula"]; 
    
    if (!validarCedula($cedula)) {
        header("Location: ../asignacion.php");
        exit();
    }
    // RECOPILA LOS DATOS A SER EDITADOS Y LOS COLOCA EN VARIABLES
    $nombre = $_POST["nombre"]; 
    $apellido = $_POST["apellido"]; 
    $fecnac = $_POST["fecnac"];
    $genero = $_POST["genero"];  
    $activo = "1"; 

    // Info aparte
    $motivo = $_POST["motivo"]; 
    $fecha_creacion = date('Y-m-d H:i:s');
    $tipoform = "General";
    $comision = $_POST['comi']; 
    
    // Viaje 
    $origen = $_POST["origen"]; 
    $localidado = $_POST["localidado"];
    $destino = $_POST["destino"]; 
    $localidadd = $_POST["localidadd"]; 
    $anotaciones = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];

    // VERIFICA SI LA PERSONA YA EXISTE EN LA BASE DE DATOS CON ESA CÉDULA
    $sql_verificar = "SELECT numCedula FROM persona WHERE numCedula = '$cedula'";
    $result = $conn->query($sql_verificar);

    if ($result->num_rows == 0) {
        // EN CASO DE QUE NO EXISTA INSERTA UNA NUEVA PERSONA
        $sql_persona = "INSERT INTO persona (numCedula, nombre, apellido, fecnac, genero, activo) 
                        VALUES ('$cedula', '$nombre', '$apellido', '$fecnac', '$genero', '$activo')";

        if (!$conn->query($sql_persona)) {
            echo "Error al insertar en Persona: " . $conn->error;
            exit();
        }
    }

    // INSERTAR DATOS EN LA TABLA DEL FORMULARIO
    $sql_formulario = "INSERT INTO formulario (Persona_numCedula, anotaciones, fechaCreacion, motivo, agencia, tipo, comision) 
                       VALUES ('$cedula', '$anotaciones', '$fecha_creacion', '$motivo', '$agencia', '$tipoform', '$comision' )";

    if ($conn->query($sql_formulario) !== TRUE) {
        echo "Error al insertar en formulario: " . $conn->error;
        exit();
    }

    // DEFINE EL ID DEL FORMULARIO AL SER INSERTADO PRIMERO PARA LUEGO POSTEARLO EN SU CLAVE FORANEA DENTRO DE PASAJE
    $id_form = $conn->insert_id;

    // INSERTAR DATOS EN LA TABLA PASAJE
    $sql_pasaje = "INSERT INTO pasaje (formulario_id_form, Persona_numCedula, origen, localidado, destino, localidadd, fecha) 
                   VALUES ('$id_form', '$cedula', '$origen', '$localidado', '$destino', '$localidadd', '$fecviaje')";

    if ($conn->query($sql_pasaje) !== TRUE) {
        echo "Error al insertar en Pasaje: " . $conn->error;
        exit();
    }
    
    header("Location: ../registros.php");
    exit(); 
}

$conn->close();
?>
