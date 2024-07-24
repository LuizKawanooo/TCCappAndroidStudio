<?php
include 'conexao.php';
$lista = array();
$sql = "select * from estudante";
$resultado = mysqli_query($con, $sql);
while($produto = mysqli_fetch_object($resultado)){
$lista[] = $produto;
}
echo json_encode($lista);
mysqli_close($con);
