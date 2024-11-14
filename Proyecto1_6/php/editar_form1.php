<?php
require 'basephp/conexion.php'; 

if (isset($_GET['id_form'])) {
    $id_form = $_GET['id_form'];

    $sql = "SELECT pasaje.Persona_numCedula, persona.nombre, persona.apellido, persona.genero, persona.fecnac,
                   formulario.motivo, formulario.id_form, pasaje.cantidad, formulario.comision,
                   pasaje.origen, pasaje.destino, pasaje.localidado, pasaje.localidadd, pasaje.formulario_id_form, formulario.anotaciones, 
                   pasaje.fecha, formulario.agencia 
            FROM pasaje 
            JOIN formulario ON pasaje.formulario_id_form = formulario.id_form
            JOIN persona ON pasaje.Persona_numCedula = persona.numCedula
            WHERE formulario.id_form = '$id_form'"; 

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conn);
        exit();
    }

    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "No se recibió ninguna cédula.";
    exit();
}

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form2.css">
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
    <form action="basephp/editarform1.php" method="POST">
        <input type="hidden" name="id_form" value="<?php echo $row['id_form']; ?>">
        
        <legend><b>Información del Usuario</b></legend>
        <div class="user-info">
            <div class="organ">
                <label for="cedula">Cédula:</label>
                <input type="number" id="cedula" name="cedula" value="<?php echo $row['Persona_numCedula']; ?>" readonly>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $row['apellido']; ?>" readonly>
            
                    <label for="genero">Genero:*</label>
                <select name="genero" id="genero" required>
                <option value="<?php echo $row['genero']; ?>" readonly><?php echo $row['genero']; ?></option>
                </select>

                <label for="comi">Comisión de servicio</label>
            <select name="comi" id="comi">
            <option value="<?php echo $row['comision']; ?>"><?php echo "Actual: ".$row['comision']; ?></option>
                    <option value="Gratuito">Gratuito</option>
                    <option value="Oficial">Oficial</option>
                </select>
            
            </div>

            <div class="organ">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" readonly>

                <label for="fecnac">Fecha de nacimiento:*</label>
            <input type="date" name="fecnac" id="fecnac" value="<?php echo $row['fecnac']; ?>" readonly>

                <label for="motivo">Motivo:</label>
                <select name="motivo" id="motivo">
                    <option value="<?php echo $row['motivo']; ?>" selected><?php echo "Actual: " . $row['motivo']; ?></option>
                    <option value="Tramite">Trámite</option>
                    <option value="Policlinica">Policlínica</option>
                    <option value="Guardia">Guardia</option>
                    <option value="Capacitación">Capacitación</option>
                </select>
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
                    <option value="<?php echo $row['agencia']; ?>"><?php echo "Actual: " . $row['agencia']; ?></option>
                    <option value="CUT">CUT</option>
                    <option value="Turil">Turil</option>
                    <option value="Grupo Agencia">Grupo Agencia</option>
                    <option value="Jotaele">Jotaele</option>
                </select>

                <label for="anot">Anotaciones</label>
                <textarea id="anot" name="anot" rows="4"><?php echo isset($row['anotaciones']) ? ($row['anotaciones']) : ''; ?></textarea>

            </div>
        </div>

        <button type="submit" class="btn">Actualizar</button>
    </form>
    <a href="registros.php" class="backbtn">Atrás</a>
</div>
</body>
</html>
