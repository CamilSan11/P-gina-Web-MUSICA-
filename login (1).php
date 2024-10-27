<?php
include 'includes/conecta.php';  
session_start();  // Iniciar sesión

$mensaje = '';

if (isset($_POST['entrar'])) {
    // Escapar las entradas del usuario
    $ruser = $conecta->real_escape_string($_POST['Nombre_de_usuario']);
    $rpass = $conecta->real_escape_string(md5($_POST['Password']));

    // Consulta SQL
    $consulta = "SELECT * FROM Usuarios WHERE Nombre_de_usuario = '$ruser' AND Password = '$rpass'";
    $resultado = $conecta->query($consulta);

    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_array();
        $userok = $row['Nombre_de_usuario'];

     
        $_SESSION['login'] = TRUE;
        $_SESSION['Nombre_de_usuario'] = $userok;

        
        header("Location: tabla dinamica.php");
        exit;
    } else {
       
        $mensaje = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Error:</strong> No se encontraron tus datos. Verifica tus credenciales.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }

    $resultado->close();
    $conecta->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Color de fondo general */
        }
        .login-container {
            background-color: #e3f2fd; /* Azul muy claro */
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="login-container col-sm-12 col-md-8 col-lg-4">
            <h4 class="text-center mb-4">Login al sistema</h4>
            <form action="" method="post">
                <div class="mb-3">
                    <input type="text" name="Nombre_de_usuario" class="form-control" placeholder="Nombre de usuario" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="Password" class="form-control" placeholder="Contraseña" required>
                </div>
                <div class="d-grid">
                    <button type="submit" name="entrar" class="btn btn-success btn-block">Entrar</button>
                </div>
            </form>
            <!-- Mostrar mensaje aquí -->
            <?php echo $mensaje; ?>
        </div>
    </div>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
