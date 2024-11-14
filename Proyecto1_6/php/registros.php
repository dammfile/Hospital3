<?php
require 'basephp/mostrar_form.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="icon" href="../assets/favicon.ico">
    <title>Registros</title>
</head>
<body>
    <div class="contenido">
        <header>
            <h1>GESTIÓN DE PASAJES</h1>
        </header>
        <a href="../home.html" class="backbtn">Atrás</a>
        <div class="busqueda">
        <form method="POST" action="">
            <input type="text" name="buscar" placeholder="Buscar..." value="<?php echo isset($buscar) ? $buscar : ''; ?>">
            <input type="submit" value="Buscar" class="btn">
        </form>
        </div>
        <div class="table">
            <table>
                <thead>
                    <tr>
                        <h1 id="ttitle">TABLA DE PASAJES</h1>
                        <th style="border: 2px solid #0078ff;">N° de Formulario</th> 
                        <th style="border: 2px solid #0078ff;">C&eacute;dula</th> 
                        <th style="border: 2px solid #0078ff;">Nombre</th> 
                        <th style="border: 2px solid #0078ff;">Apellido</th> 
                        <th style="border: 2px solid #0078ff;">Tipo</th> 
                        <th style="border: 2px solid #0078ff;">Razon</th> 
                        <th style="border: 2px solid #0078ff;">Acompañante</th> 
                        <th style="border: 2px solid #0078ff;">Fecha de Viaje</th> 
                        <th style="border: 2px solid #0078ff;">Creaci&oacuten</th> 
                        <th style="border: 2px solid #0078ff;">Acciones</th> 
                    </tr>
                </thead>
                <tbody>
                <?php 
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo "#".$row["id_form"]; ?></td>
                            <td><?php echo $row["Persona_numCedula"]; ?></td>
                            <td><?php echo $row["nombre"]; ?></td>
                            <td><?php echo $row["apellido"]; ?></td>
                            <td><?php echo $row["comision"]; ?></td>
                            <td><?php echo $row["motivo"]; ?></td>
                            <td><?php echo ($row["nombrea"] && $row["apellidoa"]) ? $row["nombrea"]. " ".$row["apellidoa"] : 'No tiene'; ?></td>
                            <td><?php echo $row["fecha"]; ?></td>
                            <td><?php echo isset($row["fechaCreacion"]) ? $row["fechaCreacion"] : 'N/A'; ?></td>
                            <td>                    
                                <!-- Formulario para editar -->
                                <form action="basephp/verificacion.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_form" value="<?php echo $row['id_form']; ?>">
                                <input type="hidden" name="tipo" value="<?php echo $row['tipo']; ?>">
                                <button class="btn" type="submit" onclick='return confirm("¿Estás seguro de que quieres editar este Registro?")'>Editar</button>
                                </form>
                        </tr>
                    <?php }  ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7">No se encontraron Registros</td>
                    </tr>
                <?php }  ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
