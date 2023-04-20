<?php

session_start();
include_once("../../../config/conexao.php");
include_once("../../../config/funcoes.php");
include_once("../includes/validaSession.php");
date_default_timezone_set('America/Sao_Paulo');
$ID = @$_GET["ID"];
if($ID == false)
	exit;

$sql = "SELECT * FROM admin WHERE ID = '".$ID."'";
$row = $conn->query($sql)->rowCount();
if($row == true){
	$ln = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
		
	$conn->query("DELETE FROM admin WHERE ID = $ID");
	$result = '(' . "{'RETORNO' : 'sucesso'}" . ')';
}else{
	$result = '(' . "{'RETORNO' : 'erro'}" . ')';
}
echo $_GET['callback'].$result;