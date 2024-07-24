<?php
include 'conexao.php';
$id = $_REQUEST['txtid'];
$CodEtecAPI = $_REQUEST['txtcodetec'];
$EmailAPI = $_REQUEST['txtemail'];
$RMAPI = $_REQUEST['txtrm'];
$SenhaAPI = $_REQUEST['txtsenha'];

$sql = "update produto set CodigoEtec=$CodEtecAPI, Email=$EmailAPI, rm=$RMAPI, senha=$SenhaAPI where id = $id";
$resultado = mysqli_query($con, $sql);
echo $resultado;
mysqli_close($con);

?>