<?php 

	session_start();
	include_once("../../../config/conexao.php");
	include_once("../../../config/funcoes.php");

	extract($_POST);

	update(	$conn, 
		array("help"),
		array($help),
		"sistema",
		"WHERE ID = 1"
		);

?>
<div class="alert alert-success alerts">Help atualizado</div>