<?php

	session_start();
	include_once("../../config/conexao.php");
	include_once("../../config/funcoes.php");
	include_once("../includes/validaSession.php");

	extract($_POST);

	if(!$nome) {
		die(json_encode([
			"status" => false,
			"message" => "Insira o seu nome"
		]));
	}

	if(!$email) {
		die(json_encode([
			"status" => false,
			"message" => "Insira o seu email"
		]));
	}

	if(!$csenha && $senha){
	    die(json_encode(array("status" => false, "message" => "Preencha sua senha atual")));
	}
	
	if($csenha && !$senha){
	    die(json_encode(array("status" => false, "message" => "Preencha sua senha")));
	}

	if($csenha && $senha){
	    $sql = "SELECT * FROM clientes WHERE ID = {$id} LIMIT 1";
	    
	    $senhaloj = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
	    
	    if(md5($senha) !== $senhaloj->senha){
	        die(json_encode(array("status" => false, "message" => "Senha atual está errada.")));
	    }
	    
	    $conn->query("UPDATE clientes SET senha = '".md5($csenha)."' WHERE ID = {$id}");
	}

	update($conn, array("nome", "email"), array($nome, $email), "clientes", "WHERE ID = {$id}");

	die(json_encode(array("status" => true, "message" => "Dados alterados.")));
