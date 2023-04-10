<?php 
	session_start();
	ob_start();
	
	include_once("../../config/conexao.php");
	include_once("../../config/funcoes.php");

	unset($_SESSION["emailUsuario"]);
	unset($_SESSION["senhaUsuario"]);
	unset($_SESSION["usuarioID"]);

	header("Location: ../../login");

?>