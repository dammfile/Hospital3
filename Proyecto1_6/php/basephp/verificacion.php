<?php
require 'conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['id_form']) && isset($_POST['tipo'])) {
        $id_form = $_POST['id_form'];
        $tipo = $_POST['tipo'];

// CONDICIONAL QUE SEPARA LOS FORMULARIOS EN BASE A UN ATRIBUTO INTERNO DENTRO DE CADA ARCHIVO DE INSERCIÓN LLAMADO "TIPO"
// ESTE DATO ES UTILIZADO POR LA PÁGINA PARA LA GESTIÓN INTERNA Y PODER SABER DE QUE TIPO DE DOCUMENTO SE TRATA A LA HORA DE REALIZAR LA EDICIÓN
        if ($tipo === 'General') {
            header("Location: ../editar_form1.php?id_form=" . urlencode($id_form));
            exit;
        } elseif ($tipo === 'Paciente') {
            header("Location: ../editar_form2.php?id_form=" . urlencode($id_form));
            exit;
        }
    } else {
        echo "Error: Cedula o tipo no están definidos.";
    }
} else {
    echo "Error: Se esperaba una solicitud POST.";
}
?>
