<?php

	session_start();
	include_once("../../../config/conexao.php");
	include_once("../../../config/funcoes.php");
	include_once("../includes/validaSession.php");
	date_default_timezone_set('America/Sao_Paulo');
	extract($_POST);

	$replaces = array('<script type="text/javascript">', '</script>');
	$ga =  addslashes(str_replace($replaces, "", @$google_analytics));
	if($titulo == false){
		die(json_encode(array("status" => false, "message" => "Preencha o titulo")));
	}
	if($descricao == false)
	{
		die(json_encode(array("status" => false, "message" => "Preencha a descrição")));
	}

	update($conn, 	
		array(
			"titulo", 
			"palavrasChave", 
			"descricao",   
			"google_analytics",
			"emailNome",
			"emailHost",
			"emailPorta",
			"emailUsuario",
			"emailSenha",
			), 
		array(
			$titulo, 
			$palavrasChave, 
			$descricao, 
			$ga,
			$emailNome,
			$emailHost,
			$emailPorta,
			$emailUsuario,
			$emailSenha,
			), 
		"sistema", 
		"WHERE ID = '1'"
		);

	// saveLog($conn, dadosAdmin($conn, "nome", $_SESSION["emailAdmin"])." atualizou as informações de configurações do site.");
	die(json_encode(array("status" => true, "message" => "Configurações salvas")));
