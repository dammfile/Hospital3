<?php
require 'basephp/mostrarinac.php';
require 'basephp/conexion.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/registro.css">
    <link rel="icon" href="../assets/favicon.ico">
    <title>Archivo</title>
</head>
<body>
    <div class="contenido">
<header>
<h1>ARCHIVO DE USUARIOS</h1>
</header>
<a href="personas.php" class="backbtn">Atrás</a>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <h1 id="ttitle">USUARIOS INACTIVOS</h1>
                    <th style="border: 2px solid #0078ff;">C&eacute;dula</th> 
                    <th style="border: 2px solid #0078ff;">Nombre</th> 
                    <th style="border: 2px solid #0078ff;">Apellido</th> 
                    <th style="border: 2px solid #0078ff;">Genero</th> 
                    <th style="border: 2px solid #0078ff;">Fecha de nacimiento</th>
                    <th style="border: 2px solid #0078ff;">Estado</th>
                    <th style="border: 2px solid #0078ff;">Acciones</th> 
                    <th></th>
                </tr>
            </thead>
             <tbody>
             <?php 
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Bucle para cada fila del resultado
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row["numCedula"]; ?></td>
                                <td><?php echo $row["nombre"]; ?></td>
                                <td><?php echo $row["apellido"]; ?></td>
                                <td><?php echo $row["genero"]; ?></td>
                                <td><?php echo $row["fecnac"]; ?></td>
                                <td><?php echo $row["activo"] == 1 ? "Activo" : "Inactivo"; ?></td>
                                <td>                    
                                    <form action="basephp/reactivar_persona.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="cedula" value="<?php echo $row["numCedula"]; ?>">
                                        <button class="btn" type="submit" onclick='return confirm("¿Estás seguro de que quieres reactivar este Usuario?")'>Reactivar</button>
                                    </form>
                            </td>
                        </tr>
                    <?php }  ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="7">No se encontraron inactivos</td>
                    </tr>
                <?php }  ?>
                </tr>
    </tbody>
        </table>
    </div>
    </div>
</body>
</html>