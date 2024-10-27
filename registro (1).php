<?php
include "includes/conecta.php";  // Conectar a la base de datos

// Consulta para extraer datos de género
$Genero = "SELECT * FROM Genero";
$guardar = $conecta->query($Genero);

$mensaje = "";  // Inicializa el mensaje

// Validación del botón enviar
if (isset($_POST['registrar'])) {
    $nombre = $conecta->real_escape_string($_POST['Nombre']);
    $Apellido1 = $conecta->real_escape_string($_POST['ApellidoP']);
    $Apellido2 = $conecta->real_escape_string($_POST['ApellidoM']);
    $fecha = $conecta->real_escape_string($_POST['Fechnac']);
    $genero = $conecta->real_escape_string($_POST['genero']);
    $telefono = $conecta->real_escape_string($_POST['Telefono']);
    $email = $conecta->real_escape_string($_POST['Email']);
    $Nombre_de_usuario = $conecta->real_escape_string($_POST['Nombre_de_usuario']);
    $Pass = $conecta->real_escape_string(md5($_POST['Password']));  

    //Consulta para verificar que el registro no exista
    $validar="SELECT * FROM Usuarios WHERE Email='$email' OR Nombre_de_usuario='$Nombre_de_usuario'";
    $validando=$conecta->query($validar);
    if($validando->num_rows > 0){
        $mensaje = "<div class='text-danger text-center mt-4'>El usuario y/o email ya se encuentran registrados</div>";
    } else {
        // Consulta para insertar datos
        $Insertar = "INSERT INTO Usuarios (Nombre, ApellidoP, ApellidoM, Fechnac, ID_Genero, Telefono, Email, Nombre_de_usuario, Password) 
                     VALUES ('$nombre', '$Apellido1', '$Apellido2', '$fecha', '$genero', '$telefono', '$email', '$Nombre_de_usuario','$Pass')";

        $guardando = $conecta->query($Insertar);

        if ($guardando) {
            $mensaje = "<div class='alert alert-success text-center mt-4'>El registro se realizó con éxito</div>";
        } else {
            $mensaje = "<div class='alert alert-danger text-center mt-4'>Tu registro no se realizó con éxito</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>REGISTRO</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            margin-top: 5%;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-sm-12 col-md-8 col-lg-6 form-container">
            <h4 class="text-center mb-4">Registro</h4>
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="text" name="Nombre" placeholder="Nombre" class="form-control mb-3" required>
                <input type="text" name="ApellidoP" placeholder="Apellido Paterno" class="form-control mb-3" required>
                <input type="text" name="ApellidoM" placeholder="Apellido Materno" class="form-control mb-3" required>
                <input type="date" name="Fechnac" class="form-control mb-3" required>
                <select class="form-control mb-3" name="genero" required>
                    <option value="">Selecciona un género</option>
                    <?php while ($row = $guardar->fetch_assoc()) { ?>
                        <option value="<?php echo $row['ID_Genero'] ?>"><?php echo $row['Nombre_genero'] ?></option>
                    <?php } ?>
                </select>
                <input type="tel" name="Telefono" placeholder="Teléfono" class="form-control mb-3" required>
                <input type="email" name="Email" placeholder="Email" class="form-control mb-3" required>
                <input type="text" name="Nombre_de_usuario" placeholder="Nombre de Usuario" class="form-control mb-3" required>
                <input type="password" name="Password" placeholder="Contraseña" class="form-control mb-3" required>
                <button type="submit" name="registrar" class="btn btn-success btn-block">Registrar</button>
            </form>

            <!-- Mostrar mensaje aquí -->
            <?php echo $mensaje; ?>
        </div>
    </div>
</body>
</html>
