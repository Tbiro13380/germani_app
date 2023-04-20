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

	if(@$status == false){
		die(json_encode(array("status" => false, "message" => "Selecione um status")));
	}

	if($senha && $senhac){
		$sql = "SELECT * FROM admin WHERE ID = {$id}";

		$admin = $conn->query($sql)->fetch(PDO::FETCH_OBJ);

		if(md5($senhac) == $admin->senha){
			update($conn, "senha", md5($senha), "admin", "WHERE ID = {$id}");
		}
	}

	update($conn, array("nome", "email", "status"), array($nome, $email, $status), "admin", "WHERE ID = {$id}");

	die(json_encode(array("status" => true, "message" => "Atualizações salvas")));
	
