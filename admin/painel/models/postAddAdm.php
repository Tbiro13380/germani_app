<?php

	session_start();

	include_once("../../../config/conexao.php");	
	include_once("../../../config/funcoes.php");
	include_once("../includes/validaSession.php");

	extract($_POST);

	if(!$nome){
		die(json_encode(array("status" => false, "message" => "Insira o nome")));
	}

	if(!$email){
		die(json_encode(array("status" => false, "message" => "Insira o email")));
	}

	if(!$senha){
		die(json_encode(array("status" => false, "message" => "Insira a senha")));
	}

	if(@$status == false){
		die(json_encode(array("status" => false, "message" => "Selecione um status")));
	}


	insert($conn, array("nome", "email", "senha", "status"), array($nome, $email, md5($senha), $status), "admin");

	die(json_encode(array("status" => true, "message" => "Admin adicionado")));