<?php 
	session_start();
	ob_start();
	
	include_once("../../../config/conexao.php");
	include_once("../../../config/funcoes.php");

	if(seo(true, 2) == "sessao-expirada"){
		saveLog($conn, "O sistema desconectou ".dadosAdmin($conn, "nome", $_SESSION["emailAdmin"])." por inatividade");
	}

	unset($_SESSION["emailAdmin"]);
	unset($_SESSION["senhaAdmin"]);
	unset($_SESSION['adminID']);
	unset($_SESSION['adminNome']);

	header("Location: /admin");

?>