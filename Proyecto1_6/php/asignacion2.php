<?php
require 'basephp/conexion.php';

$nombre = "";
$apellido = "";
$cedula = ""; 
$fecnac = "";
$genero = "";
// el name "buscar" envia "cedula" la cual posteriormente pasará a ser una variable usada para filtrar 
// nombre y apellido y rellenar estos automaticamente al buscar y encontrar una cedula registrada.
if (isset($_POST['buscar'])) {
    $cedula = $_POST['cedula']; 

    $sql = "SELECT nombre, apellido, genero, fecnac FROM persona WHERE numCedula = '$cedula'";
    $result = mysqli_query($conn, $sql);

    // Si se encuentra la cédula, autocompletar los campos
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $fecnac = $row['fecnac'];
        $genero = $row['genero'];
    } else {
        $error = "No se encontró ninguna persona con esa cédula.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form2.css">
    <link rel="icon" href="../assets/favicon.ico">
    <title>Nuevo Informe</title>

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
    <h1>Nuevo Informe</h1>
</header>

<?php if (isset($error)): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>

    <div class="busqueda">
<form action="" method="post">
        <input type="number" id="cedula" name="cedula" value="<?php echo $cedula; ?>" required placeholder="Ingrese su cédula">
        <button type="submit" name="buscar" class="btn">Buscar Cédula</button>
        </form>
</div>

<div class="formulario">
    <form action="basephp/form1ins.php" method="post">
        <legend><b>Información del Usuario</b></legend>
        <div class="user-info">
            <div class="organ">
                <label for="nombre">Cedula:*</label>
                <input type="number" id="cedula" name="cedula" value="<?php echo $cedula; ?>" required>

                <label for="apellido">Apellido:*</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>

            <label for="genero">Genero:*</label>
            <select name="genero" id="genero" required>
            <option value="<?php echo $genero; ?>"><?php echo "Genero encontrado: ".$genero; ?></option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otros</option>
            </select>
        
            <label for="comi">Comisión de servicio</label>
            <select name="comi" id="comi">
            <option value="">- Seleciona -</option>
                    <option value="Gratuito">Gratuito</option>
                    <option value="Oficial">Oficial</option>
                </select>

            </div>

            <div class="organ">

            <label for="nombre">Nombre:*</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>

                <label for="fecnac">Fecha de nacimiento:*</label>
            <input type="date" name="fecnac" id="fecnac" value="<?php echo $fecnac; ?>">
                
                <label for="motivo">Motivo:*</label>
                <select name="motivo" id="motivo" required>
                    <option value="">- Selecciona -</option>
                    <option value="Tramite">Trámite</option>
                    <option value="Policlinica">Policlinica</option>
                    <option value="Guardia">Guardia</option>
                    <option value="Capacitación">Capacitación</option>
                </select>
            </div>
        </div>

        <!-- Información del Viaje -->
        <legend><b>Información del Viaje</b></legend>
        <div class="viaje-info">
            <div class="organ">
            <select name="origen" id="origen" onchange="actualizarLocalidades('origen', 'localidado')" required>
                    <option value="">- Selecciona -</option>
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
                    <option value="">- Selecciona -</option>
                </select>

                <label for="destino">Destino:*</label>
                <select name="destino" id="destino" onchange="actualizarLocalidades('destino', 'localidadd')" required>
                <option value="">- Selecciona -</option>
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
                    <option value="Tamadua">- Seleciona -</option>
                </select>

            </div>


            <div class="organ">
                <label for="fecha">Fecha de Viaje:*</label>
                <input type="datetime-local" id="fecha" name="fecha" required>

                <label for="agencia">Agencia:</label>
                <select name="agencia" id="agencia" required>
                    <option value="">Selecciona una agencia</option>
                    <option value="CUT">CUT</option>
                    <option value="Turil">Turil</option>
                    <option value="Grupo Agencia">Grupo Agencia</option>
                    <option value="Jotaele">Jotaele</option>
                </select>

                <label for="razon">Anotaciones:</label>
                <textarea id="anot" name="anot" rows="4"></textarea>
            </div>
        </div>
            <input type="submit" class="btn" value="ENVIAR">
    </form>
</div>

<a href="../html/menu.html" class="backbtn">Atrás</a>

</body>
</html>
