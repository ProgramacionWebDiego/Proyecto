<?php
session_start();

$servidor = "localhost";
$usuariodb = "root";
$passdb = "";
$db = "tabla_galeria";

$usuario = $_POST["user"];
$contrasena = $_POST["pass"];
$email = $_POST["email"];
$plan = $_POST["plan"]; 

$conexion = mysqli_connect($servidor, $usuariodb, $passdb, $db);

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$consulta_usuario = "SELECT * FROM usuarios WHERE nombre = ?";
$stmt_usuario = mysqli_prepare($conexion, $consulta_usuario);
mysqli_stmt_bind_param($stmt_usuario, "s", $usuario);
mysqli_stmt_execute($stmt_usuario);
mysqli_stmt_store_result($stmt_usuario);
$existe_usuario = mysqli_stmt_num_rows($stmt_usuario) > 0;

$consulta_email = "SELECT * FROM usuarios WHERE correo_electronico = ?";
$stmt_email = mysqli_prepare($conexion, $consulta_email);
mysqli_stmt_bind_param($stmt_email, "s", $email);
mysqli_stmt_execute($stmt_email);
mysqli_stmt_store_result($stmt_email);
$existe_email = mysqli_stmt_num_rows($stmt_email) > 0;

if($existe_usuario || $existe_email) {
    $_SESSION['registrar_error'] = 'Error: El usuario o correo electrónico ya existe.';
    header("Location: registrar.php"); 
    exit; 
} else {
    $consulta_insertar = "INSERT INTO usuarios (nombre, correo_electronico, contrasena, plan) VALUES (?, ?, ?, ?)";
    $stmt_insertar = mysqli_prepare($conexion, $consulta_insertar);
    mysqli_stmt_bind_param($stmt_insertar, "ssss", $usuario, $email, $contrasena, $plan);

    if(mysqli_stmt_execute($stmt_insertar)){
        $_SESSION['registro_exitoso'] = true;
        header("Location: index.php");
    } else {
        echo "Error al registrar usuario: " . mysqli_error($conexion);
    }
}

mysqli_stmt_close($stmt_usuario);
mysqli_stmt_close($stmt_email);
mysqli_stmt_close($stmt_insertar);
mysqli_close($conexion);
?>
