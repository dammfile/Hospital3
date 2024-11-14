<?php
require 'conexion.php';

$buscar = "";

// VERIFICA SI SE HA REALIZADO ALGUNA BUSQUEDA.
if (isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];
}

// CONSULTA PARA OBTENER TODOS LOS DATOS MIENTRAS NO SE REALIZA NINGUNA BUSQUEDA
$query = "SELECT formulario.id_form, formulario.Persona_numCedula, formulario.fechaCreacion, formulario.ultimaEdicion, 
                 formulario.tipo, formulario.motivo, formulario.comision,
                 persona.nombre, persona.apellido, pasaje.fecha, 
                 acompañante.nombrea, acompañante.apellidoa, acompañante.razonAcomp, acompañante.acomp
          FROM formulario
          JOIN persona ON formulario.Persona_numCedula = persona.numCedula
          JOIN pasaje ON pasaje.formulario_id_form = formulario.id_form
          LEFT JOIN acompañante ON formulario.Acompañante_id_acomp = acompañante.id_acomp";

if (!empty($buscar)) {
    $query .= " WHERE formulario.id_form LIKE '%$buscar%' 
                 OR formulario.Persona_numCedula LIKE '%$buscar%'  
                 OR formulario.motivo LIKE '%$buscar%'";
}

$query .= " GROUP BY formulario.id_form"; 

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conn); 
}

$conn->close();
?>