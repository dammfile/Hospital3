<?php
include 'validarcedula.php';
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // DATOS DE LA PERSONA
    $cedula = $_POST["cedula"];
    if (!validarCedula($cedula)) {
        header("Location: ../asignacion.php");
        exit();
    }
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $fecnac = $_POST["fecnac"];
    $genero = $_POST["genero"];
    $activo = "1";

    // INFO EXTRA
    $atm = $_POST["atm"];
    $comision = $_POST['comi'];
    $fecha_creacion = date('Y-m-d H:i:s');
    $tipoform = "Paciente";

    // ACOMPAÑANTE
    $cedulaa = $_POST["cedulaa"];
    $nombrea = $_POST["nombrea"];
    $apellidoa = $_POST["apellidoa"];
    $razon = $_POST["razon"];
    $acomp = $_POST['acomp'];

    // INFO DEL VIAJE
    $origen = $_POST["origen"];
    $localidado = $_POST["localidado"];
    $destino = $_POST["destino"];
    $localidadd = $_POST["localidadd"];
    $anot = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    $hospital = $_POST["hospitales"];

    // VERIFICAR SI LA PERSONA YA EXISTE
    $sql_verificar_persona = "SELECT numCedula FROM persona WHERE numCedula = '$cedula'";
    $result = $conn->query($sql_verificar_persona);

    if ($result->num_rows == 0) {
        // EN CASO DE NO EXISTIR INSERTAR UN NUEVO USUARIO
        $sql_persona = "INSERT INTO persona (numCedula, nombre, apellido, fecnac, genero, activo) 
                        VALUES ('$cedula', '$nombre', '$apellido', '$fecnac', '$genero', '$activo')";
        $conn->query($sql_persona);
    }

    if ($acomp == "Si") {
        // SI ACOMP ES SI ENTONCES VERIFICA SI EL ACOMPAÑANTE YA EXISTE.
        $sql_verificar_acomp = "SELECT id_acomp FROM acompañante WHERE id_acomp = '$cedulaa'";
        $result_acomp = $conn->query($sql_verificar_acomp);

    if ($result_acomp->num_rows > 0) {
        // SI EXISTE TRAE EL ID PARA RELACIONARLO CON ACOMP_ID
        $acomp_id = $cedulaa;
    } else {
        // EN CASO DE NO EXSISTIR INSERTA UNO NUEVO.
        $sql_acompanante = "INSERT INTO acompañante (id_acomp, nombrea, apellidoa, razonAcomp, acomp, Persona_numCedula) 
                            VALUES ('$cedulaa', '$nombrea', '$apellidoa', '$razon', '$acomp', '$cedula')";
        $conn->query($sql_acompanante);
        $acomp_id = $cedulaa;
    }

    } 
    // INSERTAR DATOS A LA TABLA FORMULARIO
    $sql_formulario = "INSERT INTO formulario (Persona_numCedula, anotaciones, fechaCreacion, motivo, hospital, agencia, tipo, comision, Acompañante_id_acomp) 
                       VALUES ('$cedula', '$anot', '$fecha_creacion', '$atm', '$hospital', '$agencia', '$tipoform', '$comision', '$acomp_id')";
    $conn->query($sql_formulario);

    // OBTENER EL ID DEL FORMULARIO PARA RELACIONARLO CON EL PASAJE
    $id_form = $conn->insert_id;

    // INSERTAR DATOS EN TABLA PASAJE
    $sql_pasaje = "INSERT INTO pasaje (formulario_id_form, Persona_numCedula, origen, localidado, destino, localidadd, fecha) 
                   VALUES ('$id_form', '$cedula', '$origen', '$localidado', '$destino', '$localidadd', '$fecviaje')";
    $conn->query($sql_pasaje);

    // REDIRECCIONAR SI TODAS LAS CONSULTAS HAN FUNCIONADO.
    header("Location: ../registros.php");
    exit();
}

$conn->close();
?>
