<?php

	session_start();
	include_once("../../../config/conexao.php");
	include_once("../../../config/funcoes.php");
	include_once("../includes/validaSession.php");
	date_default_timezone_set('America/Sao_Paulo');
	extract($_POST);

	$sql = "SELECT * FROM clientes WHERE email = '{$email}'";

	if(!$nome){
		die(json_encode(array("status" => false, "message" => "Insira o nome")));
	}

	if(!$email){
		die(json_encode(array("status" => false, "message" => "Insira o email")));
	}

	if(!$senha){
		die(json_encode(array("status" => false, "message" => "Insira a senha")));
	}

	if($conn->query($sql)->rowCount()){
		die(json_encode(array("status" => false, "message" => "Esse email já está cadastrado")));
	}

	insert($conn, array("nome", "email", "senha", "data_cadastro"), array($nome, $email, md5($senha), date('Y-m-d')), "clientes");

	die(json_encode(array("status" => true, "message" => "Cliente adicionado com sucesso!")));