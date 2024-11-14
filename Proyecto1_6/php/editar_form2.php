<?php
require 'basephp/conexion.php'; 

// Verificar si se se ha enviado la cedula
if (isset($_GET['id_form'])) {
    $id_form = $_GET['id_form'];

    // Consulta para obtener los datos
$sql = "SELECT 
        pasaje.Persona_numCedula, persona.nombre, persona.apellido, persona.fecnac, persona.genero, formulario.motivo, 
        pasaje.cantidad, pasaje.origen, pasaje.localidado, pasaje.localidadd, pasaje.destino, formulario.anotaciones, 
        pasaje.fecha, pasaje.formulario_id_form, formulario.agencia, formulario.comision, 
        formulario.hospital, formulario.id_form, acompañante.id_acomp, acompañante.nombrea, 
        acompañante.apellidoa, acompañante.acomp, acompañante.razonAcomp 
    FROM pasaje 
    JOIN formulario ON pasaje.formulario_id_form = formulario.id_form 
    JOIN persona ON pasaje.Persona_numCedula = persona.numCedula 
    LEFT JOIN acompañante ON formulario.Acompañante_id_acomp = acompañante.id_acomp
    WHERE formulario.id_form = '$id_form'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $acomp = $row['acomp'];
        $comi = $row['comision'];
    } else {
        echo "No se encontraron datos.";
        exit;
    }
} else {
    echo "Error: Cédula no definida.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="icon" href="../assets/favicon.ico">
    <title>Actualizar Informe</title>

    <script>
        // FUNCIÓN USADA PARA ACTUALIZAR LOCALIDADES CUANDO SE SELECCIONE UNA OPCION CORRESPONDIENTE
    function actualizarLocalidades(departamentoSelectId, localidadSelectId) {
        // TRAE EL ELEMENTO SELECCIONADO DEL SELECT DE LOS DEPARTAMENTOS EN BASE A SU ID
        var departamento = document.getElementById(departamentoSelectId).value;
        // TRAE EL SELECT DE LOCALIDAD DONDE SE COLOCARÁN LAS LOCALIDADES
        var localidadSelect = document.getElementById(localidadSelectId);

        
        // RETIRA LAS OPCIONES DEL SELECT EN CASO DE QUE ESTE CUENTE YA CON UNA O VARIAS.
        localidadSelect.innerHTML = "";

        // ALMACENA LAS LOCALIDADES DE CADA DEPARTAMENTO
        var localidades = {
            "Artigas": ["Artigas Ciudad", "Bella Unión", "Tomás Gomensoro"],
            "Canelones": ["Canelones Ciudad", "Las Piedras", "Pando", "Santa Lucía"],
            "Cerro Largo": ["Cerro Largo Ciudad", "Fraile Muerto", "Rio Branco"],
            "Colonia": ["Colonia del Sacramento", "Nueva Helvecia", "Tarariras"],
            "Durazno": ["Durazno Ciudad", "La Paloma", "Sarandí del Yi"],
            "Flores": ["Trinidad", "Sarandí de Navarro"],
            "Florida": ["Florida Ciudad", "Sarandí Grande"],
            "Lavalleja": ["Minas", "Solís de Mataojo", "Mariscala"],
            "Maldonado": ["Maldonado Ciudad", "Punta del Este", "San Carlos"],
            "Montevideo": ["Montevideo Ciudad"],
            "Paysandú": ["Paysandú Ciudad", "Quebracho", "Guichón"],
            "Río Negro": ["Fray Bentos", "Young"],
            "Rivera": ["Rivera Ciudad", "Tranqueras"],
            "Rocha": ["Rocha Ciudad", "Cabo Polonio", "La Paloma"],
            "Salto": ["Salto Ciudad", "Constitución"],
            "San José": ["San José Ciudad", "Ecilda Paullier"],
            "San Ramón": ["San Ramón", "Aguas Corrientes"],
            "Soriano": ["Mercedes", "Dolores", "Rodríguez", "Cervecera"],
            "Tacuarembó": ["Tacuarembó Ciudad", "Paso de los Toros"],
            "Treinta y Tres": ["Treinta y Tres Ciudad", "Castillos"]
        };

        // PRIMERO VERIFICAMOS SI EL DEPARTAMENTO QUE SE SELECCIONO EXISTE EN EL VAR DE LOCALIDADES
        if (localidades[departamento]) {
            // POSTERIORMENTE SE RECORRE EL ARRAY CON LAS LOCALIDADES DEL DEPARTAMENTO SELECCIONADO
            localidades[departamento].forEach(function(localidad) {
                // SE CREA UN NUEVO OPTION PARA CADA ELEMENTO DEL ARRAY
                var opcion = document.createElement("option");
                opcion.value = localidad; // SE ESTABLECE EL VALOR O LO QUE SE GUARDARÁ
                opcion.text = localidad; // ESTABLECE EL TEXTO QUE SE MOSTRARÁ
                localidadSelect.appendChild(opcion);
            });
        }
    }
</script>

</head>
<body>
<header>
    <h1>Actualizar Informe</h1>
</header>
<div class="formulario">
    <form action="basephp/editarform2.php" method="post">
    <input type="hidden" name="id_form" value="<?php echo $row['id_form']; ?>">
        <!-- Información del Usuario -->
        <legend><b>Información del Paciente </b></legend>
        <div class="user-info">
            <div class="organ">
                <label for="cedula">Cédula:</label>
                <input type="number" id="cedula" name="cedula" value="<?php echo $row['Persona_numCedula']; ?>" readonly>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $row['apellido']; ?>" readonly>
                
                <label for="fecnac">Fecha de nacimiento:*</label>
                <input type="date" name="fecnac" id="fecnac" value="<?php echo $row['fecnac']; ?>">

                <label for="comi">Comision de servicio</label>
                <select name="comi" id="comi">
                <option value="<?php echo $row['comision']; ?>"><?php echo "Actual: ".$row['comision']; ?></option>
                    <option value="Gratuito">Gratuito</option>
                    <option value="Oficial">Oficial</option>
                </select>
            </div>

            <div class="organ">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" readonly>

                    <label for="genero">Genero:*</label>
                <select name="genero" id="genero" required>
                <option value="<?php echo $row['genero']; ?>" readonly><?php echo "Genero del paciente: ".$row['genero']; ?></option>
                </select>

                <label for="atm">Atención Médica:</label>
                <select name="atm" id="atm" required>
                    <option value="<?php echo $row['motivo']; ?>"><?php echo "Actual: ".$row['motivo']; ?></option>
                    <option value="Traumatologia">Traumatología</option>
                    <option value="Odontología">Odontología</option>
                    <option value="Salud Mental">Salud Mental</option>
                    <option value="Cardiologia">Cardiología</option>
                    <option value="Neurocirugia">Neurocirugía</option>
                    <option value="Oncologia">Oncología</option>
                    <option value="Urologia">Urología</option>
                    <option value="Pediatria">Pediatría</option>
                    <option value="Gineco Obstetricia">Gineco-obstetricia</option>
                    <option value="Endocrinologia">Endocrinología</option>
                    <option value="Geriatria">Geriatría</option>
                    <option value="Infectologia">Infectología</option>
                    <option value="Neumonologia">Neumonología</option>
                </select>
            </div>
        </div>

        <!-- Acompañante -->
        <legend><b>Acompañante</b></legend>
        <div class="acomp-info">
            <div class="organ">
            <label for="acomp">¿Lleva acompañante?</label>
                <select name="acomp" id="acomp">
                    <option value="<?php echo isset($row['acomp']) ? $row['acomp'] : ''; ?>"><?php echo isset($row['acomp']) ? "Actual: " .$row['acomp'] : 'Seleccione'; ?></option>
                    <option value="Si">Si</option>
                    <option value="No">No</option>
                </select>
                <label for="nombrea">Nombre:</label>
                <input type="text" id="nombrea" name="nombrea" value="<?php echo isset($row['nombrea']) ? $row['nombrea'] : ''; ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo se permiten letras y espacios">
                
                <label for="razon">Anotaciones:</label>
                <textarea id="razon" name="razon" rows="4"><?php echo isset($row['razonAcomp']) ? $row['razonAcomp'] : ''; ?></textarea>

            </div>
            
            <div class="organ">

                <label for="cedulaa">Cédula:</label>
                <input type="text" id="cedulaa" name="cedulaa" value="<?php echo isset($row['id_acomp']) ? $row['id_acomp'] : ''; ?>">

                
                <label for="apellidoa">Apellido:</label>
                <input type="text" id="apellidoa" name="apellidoa" value="<?php echo isset($row['apellidoa']) ? $row['apellidoa'] : ''; ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo se permiten letras y espacios">
               
            </div>
        </div>

        <!-- Información del Viaje -->
        <legend><b>Información del Viaje</b></legend>
        <div class="viaje-info">
            <div class="organ">
            <label for="origen">Origen:*</label>
                <select name="origen" id="origen" onchange="actualizarLocalidades('origen', 'localidado')" required>
                    <option value="<?php echo $row['origen']; ?>"><?php echo "Actual: ".$row['origen']; ?></option>
                    <option value="Artigas">Artigas</option>
                    <option value="Canelones">Canelones</option>
                    <option value="Cerro Largo">Cerro Largo</option>
                    <option value="Colonia">Colonia</option>
                    <option value="Durazno">Durazno</option>
                    <option value="Flores">Flores</option>
                    <option value="Florida">Florida</option>
                    <option value="Lavalleja">Lavalleja</option>
                    <option value="Maldonado">Maldonado</option>
                    <option value="Montevideo">Montevideo</option>
                    <option value="Paysandú">Paysandú</option>
                    <option value="Río Negro">Río Negro</option>
                    <option value="Rivera">Rivera</option>
                    <option value="Rocha">Rocha</option>
                    <option value="Salto">Salto</option>
                    <option value="San José">San José</option>
                    <option value="Soriano">Soriano</option>
                    <option value="Tacuarembó">Tacuarembó</option>
                    <option value="Treinta y Tres">Treinta y Tres</option>
                </select>

                <label for="localidado">Localidad de Origen:*</label>
                <select name="localidado" id="localidado">
                <option value="<?php echo $row['localidado']; ?>"><?php echo "Actual: ".$row['localidado']; ?></option>
                </select>


                <label for="destino">Destino:*</label>
                <select name="destino" id="destino" onchange="actualizarLocalidades('destino', 'localidadd')" required>
                <option value="<?php echo $row['destino']; ?>"><?php echo "Actual: ".$row['destino']; ?></option>
                <option value="Artigas">Artigas</option>
                <option value="Canelones">Canelones</option>
                <option value="Cerro Largo">Cerro Largo</option>
                <option value="Colonia">Colonia</option>
                <option value="Durazno">Durazno</option>
                <option value="Flores">Flores</option>
                <option value="Florida">Florida</option>
                <option value="Lavalleja">Lavalleja</option>
                <option value="Maldonado">Maldonado</option>
                <option value="Montevideo">Montevideo</option>
                <option value="Paysandú">Paysandú</option>
                <option value="Río Negro">Río Negro</option>
                <option value="Rivera">Rivera</option>
                <option value="Rocha">Rocha</option>
                <option value="Salto">Salto</option>
                <option value="San José">San José</option>
                <option value="Soriano">Soriano</option>
                <option value="Tacuarembó">Tacuarembó</option>
                <option value="Treinta y Tres">Treinta y Tres</option>
                </select>

                <label for="localidadd">Localidad de Destino:*</label>
                <select name="localidadd" id="localidadd">
                    <option value="<?php echo $row['localidadd']; ?>"><?php echo "Actual: ".$row['localidadd']; ?></option>
                </select>

            </div>

            <div class="organ">
                <label for="fecha">Fecha de Viaje:</label>
                <input type="datetime-local" id="fecha" name="fecha" value="<?php echo $row['fecha']; ?>" required>

                <label for="agencia">Agencia:</label>
                <select name="agencia" id="agencia" required>
                    <option value="<?php echo $row['agencia']; ?>"><?php echo "Actual: ".$row['agencia']; ?></option>
                    <option value="CUT">CUT</option>
                    <option value="Turil">Turil</option>
                    <option value="Grupo Agencia">Grupo Agencia</option>
                    <option value="Jotaele">Jotaele</option>
                </select>
                <label for="hospitales">Hospital:</label>
                <select name="hospitales" id="hospitales">
                <option value="<?php echo $row['hospital']?>"><?php echo "Actual: ".$row['hospital']?></option>
                    <optgroup label="Artigas">
                        <option value="Hospital Artigas">Hospital de Artigas</option>
                        <option value="Hospital Bella Union">Hospital de Bella Unión</option>
                        <option value="Hospital Tomas Gomensoro">Hospital de Tomás Gomensoro</option>
                    </optgroup>
                    <optgroup label="Canelones">
                        <option value="Hospital Francisco Soca">Hospital Dr. Francisco Soca - Canelones</option>
                        <option value="Hospital Las Piedras">Hospital de Las Piedras</option>
                        <option value="Hospital Pando">Hospital de Pando</option>
                    </optgroup>
                    <optgroup label="Cerro Largo">
                        <option value="Hospital Melo">Hospital de Melo</option>
                        <option value="Hospital Rio Branco">Hospital de Río Branco</option>
                        <option value="Hospital Fraile Muerto">Hospital de Fraile Muerto</option>
                    </optgroup>
                    <optgroup label="Colonia">
                        <option value="Hospital Colonia">Hospital de Colonia</option>
                        <option value="Hospital Rosario">Hospital de Rosario</option>
                        <option value="Hospital Carmelo">Hospital de Carmelo</option>
                    </optgroup>
                    <optgroup label="Durazno">
                        <option value="Hospital Durazno">Hospital de Durazno</option>
                        <option value="Centro Sarandi del Yi">Centro Auxiliar de Sarandí del Yí</option>
                        <option value="Centro La Paloma">Centro Auxiliar de La Paloma</option>
                    </optgroup>
                    <optgroup label="Flores">
                        <option value="Hospital Trinidad">Hospital de Trinidad</option>
                    </optgroup>
                    <optgroup label="Florida">
                        <option value="Hospital Florida">Hospital de Florida</option>
                        <option value="Centro Sarandi Grande">Centro Auxiliar de Sarandí Grande</option>
                        <option value="Centro Fray Marcos">Centro Auxiliar de Fray Marcos</option>
                    </optgroup>
                    <optgroup label="Lavalleja">
                        <option value="Hospital Minas">Hospital de Minas</option>
                        <option value="Centro Jose Pedro Varela">Centro Auxiliar de José Pedro Varela</option>
                        <option value="Centro Solis Mataojo">Centro Auxiliar de Solís de Mataojo</option>
                    </optgroup>
                    <optgroup label="Maldonado">
                        <option value="Hospital Maldonado">Hospital de Maldonado</option>
                        <option value="Hospital San Carlos">Hospital de San Carlos</option>
                        <option value="Hospital Pan de Azucar">Hospital de Pan de Azúcar</option>
                    </optgroup>
                    <optgroup label="Montevideo">
                        <option value="Hospital Clinicas">Hospital de Clínicas</option>
                        <option value="Hospital Maciel">Hospital Maciel</option>
                        <option value="Hospital Pasteur">Hospital Pasteur</option>
                        <option value="Hospital Pereira Rossell">Hospital Pediátrico Pereira Rossell</option>
                    </optgroup>
                    <optgroup label="Paysandu">
                        <option value="Hospital Escuela Litoral">Hospital Escuela del Litoral</option>
                        <option value="Hospital Guichon">Hospital de Guichón</option>
                        <option value="Hospital Quebracho">Hospital de Quebracho</option>
                    </optgroup>
                    <optgroup label="Rio Negro">
                        <option value="Hospital Fray Bentos">Hospital de Fray Bentos</option>
                        <option value="Centro Young">Centro Auxiliar de Young</option>
                        <option value="Centro Nuevo Berlin">Centro Auxiliar de Nuevo Berlín</option>
                    </optgroup>
                    <optgroup label="Rivera">
                        <option value="Hospital Rivera">Hospital de Rivera</option>
                        <option value="Hospital Tranqueras">Hospital de Tranqueras</option>
                        <option value="Centro Minas Corrales">Centro de Salud Minas de Corrales</option>
                    </optgroup>
                    <optgroup label="Rocha">
                        <option value="Hospital Rocha">Hospital de Rocha</option>
                        <option value="Centro Chuy">Centro Auxiliar de Chuy</option>
                        <option value="Centro Castillos">Centro Auxiliar de Castillos</option>
                    </optgroup>
                    <optgroup label="Salto">
                        <option value="Hospital Regional Salto">Hospital Regional de Salto</option>
                        <option value="Hospital Constitucion">Hospital de Constitución</option>
                        <option value="Hospital Belen">Hospital de Belén</option>
                    </optgroup>
                    <optgroup label="San Jose">
                        <option value="Hospital San Jose">Hospital de San José</option>
                        <option value="Centro Libertad">Centro Auxiliar de Libertad</option>
                        <option value="Centro Ciudad del Plata">Centro Auxiliar de Ciudad del Plata</option>
                    </optgroup>
                    <optgroup label="Soriano">
                        <option value="Hospital Mercedes">Hospital de Mercedes</option>
                        <option value="Centro Cardona">Centro Auxiliar de Cardona</option>
                        <option value="Centro Dolores">Centro Auxiliar de Dolores</option>
                    </optgroup>
                    <optgroup label="Tacuarembo">
                        <option value="Hospital Tacuarembo">Hospital de Tacuarembó</option>
                        <option value="Centro Paso de los Toros">Centro Auxiliar de Paso de los Toros</option>
                        <option value="Centro San Gregorio Polanco">Centro Auxiliar de San Gregorio de Polanco</option>
                    </optgroup>
                    <optgroup label="Treinta y Tres">
                        <option value="Hospital Treinta y Tres">Hospital de Treinta y Tres</option>
                        <option value="Centro Vergara">Centro Auxiliar de Vergara</option>
                        <option value="Centro Santa Clara Olimar">Centro Auxiliar de Santa Clara de Olimar</option>
                    </optgroup>
                    </select>

                <label for="anot">Anotaciones</label>
                <textarea id="anot" name="anot" rows="4"><?php echo isset($row['anotaciones']) ? ($row['anotaciones']) : ''; ?></textarea>
            </div>
        </div>

        <div class="btn-container">
            <input type="submit" class="btn" value="Actualizar">
        </div>
    </form>
</div>
<a href="registros.php" class="backbtn">Atrás</a>
</body>
</html>
