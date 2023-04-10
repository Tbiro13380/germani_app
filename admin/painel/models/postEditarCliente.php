<?php

session_start();
include_once("../../../config/conexao.php");
include_once("../../../config/funcoes.php");
include_once("../includes/validaSession.php");

extract($_POST);

update(	$conn, 
	array("nome", "email"),
	array($nome, $email),
	"clientes",
	"WHERE ID = {$ID}"
);

die(json_encode(array("status" => true, "message" => "Cliente atualizado")));