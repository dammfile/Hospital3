<?php
require 'conexion.php';
// RECOPILA LOS DATOS A SER EDITADOS Y LOS COLOCA EN VARIABLES
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Persona
    $id_form = $_POST["id_form"];
    $cedula = $_POST["cedula"];
    $atm = $_POST["atm"];
    $comision = $_POST['comi'];
    $fecha_edicion = date('Y-m-d H:i:s');

    // Acompañante
    $cedulaa = $_POST["cedulaa"];
    $nombrea = $_POST["nombrea"];
    $apellidoa = $_POST["apellidoa"];
    $razon = $_POST["razon"];
    $acomp = $_POST['acomp'];

    // Viaje
    $origen = $_POST["origen"]; 
    $localidado = $_POST["localidado"]; 
    $destino = $_POST["destino"];
    $localidadd = $_POST["localidadd"]; 
    $anotaciones = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    $hospital = $_POST["hospitales"];

// SENTENCIAS PARA ACTUALIZAR.

// ACTUALIZAR LOS DATOS DEL PASAJE.
    $sql_pasaje = "UPDATE pasaje 
                   SET origen='$origen', localidado='$localidado', destino='$destino', localidadd='$localidadd', fecha='$fecviaje'
                   WHERE formulario_id_form = '$id_form'";
    if (!$conn->query($sql_pasaje)) {
        echo "Error al actualizar Pasaje: " . $conn->error;
        exit();
    }

    if ($acomp == "Si") {
// BUSCAR EN ACOMPAÑANTE SI ESTE EXISTE.
        $check_acompanante = "SELECT id_acomp FROM Acompañante WHERE id_acomp = '$cedulaa'";
        $result = $conn->query($check_acompanante);

        if ($result->num_rows > 0) {

            // ACTUALIZAR ACOMPAÑANTE EN CASO DE QUE EXISTA.

            $sql_acompanante = "UPDATE acompañante SET nombrea = '$nombrea', apellidoa = '$apellidoa', razonAcomp = '$razon', acomp = '$acomp', Persona_numCedula = '$cedula'
                                WHERE id_acomp = '$cedulaa'";
        } else {

            // INSERTAR LOS DATOS EN LA TABLA ACOMPAÑANTE EN CASO DE QUE ESTE NO EXISTA
            $sql_acompanante = "INSERT INTO acompañante (id_acomp, nombrea, apellidoa, razonAcomp, acomp, Persona_numCedula) 
                                VALUES ('$cedulaa', '$nombrea', '$apellidoa', '$razon', '$acomp', '$cedula')";
        }

        if (!$conn->query($sql_acompanante)) {
            echo "Error al insertar o actualizar en Acompañante: " . $conn->error;
            exit();
        }
        
        $acomp_id = $cedulaa;
    } elseif ($acomp == "No") {

        $acomp_id = NULL;  
    }

    // ACTUALIZAR EL FORMULARIO Y ACTUALIZAR LA CLAVE DE ACOMPAÑANTE_ID_ACOMP SI ES NECESARIO HACERLO.
    $sql_formulario = "UPDATE formulario 
                       SET anotaciones='$anotaciones', motivo='$atm', hospital='$hospital', agencia='$agencia', 
                           comision='$comision', ultimaEdicion='$fecha_edicion', Acompañante_id_acomp = " . ($acomp_id ? "'$acomp_id'" : "NULL") . "
                       WHERE id_form = '$id_form'";
    if (!$conn->query($sql_formulario)) {
        echo "Error al actualizar Formulario: " . $conn->error;
        exit();
    }

    header("Location: ../registros.php");
    exit();
}

$conn->close();
?>