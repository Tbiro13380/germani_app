<?php 
	session_start();
	ob_start();

	include_once('../config/conexao.php');
	include_once('../config/funcoes.php');

	date_default_timezone_set('America/Sao_Paulo');

	if(getIpBlock($conn) == true)
		die('Falha ao carregar o site, tente novamente mais tarde. Failed to load the site, please try again later.');

	$pastaModels = 'model';

	$pageView  = @seo(false, 1).".php";

	if(file_exists($pastaModels."/".$pageView)){
		include_once($pastaModels."/".$pageView);
	} else {
		header("Location: ../login");
	}

?>