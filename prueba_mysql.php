<?php
$servidor = "localhost";
$usuariodb = "id22217406_tabla_galeria";
$passdb = "Diego2018@";
$db = "id22217406_tabla_galeria";

$conn = mysqli_connect($servidor,$usuariodb,$passdb,$db);
if(isset($conn)){
    echo "Conexion establecida";
}
mysqli_close($conn);
?>