<?php 
include 'includes/conecta.php';
session_start(); // Asegúrate de iniciar la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['login'])) {
    header("Location: login.php"); // Redirigir al login si no ha iniciado sesión
    exit;
}

// Consulta inicial para obtener todos los artistas
$consulta = "SELECT * FROM artista";
$guardar = $conecta->query($consulta);

// Manejo de errores
if ($guardar === false) {
    die("Error en la consulta: " . $conecta->error);
}

// Verifica si se ha enviado una búsqueda
$searchTerm = '';
if (isset($_POST['search'])) {
    $searchTerm = $conecta->real_escape_string($_POST['search']);
    $consulta = "SELECT * FROM artista WHERE 
        Artista LIKE '%$searchTerm%' OR 
        Nombre_de_la_cancion LIKE '%$searchTerm%' OR 
        Album LIKE '%$searchTerm%'";
    $guardar = $conecta->query($consulta);
}

// Manejar el cierre de sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy(); // Destruir la sesión
    header("Location: login.php"); // Redirigir al login
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANTALLA PRINCIPAL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <div class="col-12">
        <h3 class="text-center mb-4">Biblioteca de Música</h3>
        
        <!-- Mensaje de bienvenida -->
        <div class="alert alert-info text-center">
            Bienvenido, <?php echo htmlspecialchars($_SESSION['Nombre_de_usuario']); ?>
        </div>

        <!-- Botón de cerrar sesión -->
        <form method="POST" class="mb-3">
            <div class="d-flex justify-content-end">
                <button class="btn btn-danger" type="submit" name="cerrar_sesion">Cerrar Sesión</button>
            </div>
        </form>

        <!-- Formulario de búsqueda -->
        <form method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar artista, canción o álbum" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="tablaConsulta">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center">Artista</th>
                        <th class="text-center">Nombre de la canción</th>
                        <th class="text-center">Fecha de lanzamiento</th>
                        <th class="text-center">Álbum</th>
                        <th class="text-center">Link</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $guardar->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center"><?php echo htmlspecialchars($row['Artista']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['Nombre_de_la_cancion']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['Fecha_de_lanzamiento']); ?></td>
                            <td class="text-center"><?php echo htmlspecialchars($row['Album']); ?></td>
                            <td class="text-center"><a href="<?php echo htmlspecialchars($row['Link']); ?>" target="_blank">Escuchar</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
