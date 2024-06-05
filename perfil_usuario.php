<?php
session_start();

// Verificar la autenticación del usuario
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

$servidor = "localhost";
$usuariodb = "id22217406_tabla_galeria";
$passdb = "Diego2018@";
$db = "id22217406_tabla_galeria";
$conexion = new mysqli($servidor, $usuariodb, $passdb, $db);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (isset($_GET['usuario_id'])) {
    $usuario_id = intval($_GET['usuario_id']);
    
    $sql = "SELECT nombre FROM usuarios WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nombre_usuario = $row["nombre"]; 
    } else {
        echo "Usuario no encontrado.";
        exit(); 
    }

    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}

echo "<title>Perfil Publico de $nombre_usuario</title>";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imágenes de <?php echo $nombre_usuario; ?></title>
    <link rel="stylesheet" href="css/perfil_usuario.css">
</head>
<body>
    <h2>Imágenes de <?php echo $nombre_usuario; ?></h2>
    <div id="gallery">
        <?php
        $sql_imagenes = "SELECT nombre_archivo FROM subida WHERE usuario_id = ?";
        $stmt_imagenes = $conexion->prepare($sql_imagenes);
        $stmt_imagenes->bind_param("i", $usuario_id);
        $stmt_imagenes->execute();
        $result_imagenes = $stmt_imagenes->get_result();

        if ($result_imagenes->num_rows > 0) {
            while ($row_imagen = $result_imagenes->fetch_assoc()) {
                $archivo = $row_imagen['nombre_archivo'];
                echo "<img class='imagen' src='imagenes/" . $archivo . "' alt='Imagen'>";
            }
        } else {
            echo "<p>No hay imágenes asociadas con este usuario.</p>";
        }

        $stmt_imagenes->close();
        ?>
    </div>
</body>
</html>

<?php
$conexion->close();
?>
