<?php
$servidor = "localhost";
$usuariodb = "root";
$passdb = "";
$db = "tabla_galeria";

$conn = mysqli_connect($servidor,$usuariodb,$passdb,$db);
if(isset($conn)){
    echo "Conexion establecida";
}
mysqli_close($conn);
?>