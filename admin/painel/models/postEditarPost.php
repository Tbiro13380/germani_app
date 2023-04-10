<?php

session_start();
include_once("../../../config/conexao.php");
include_once("../../../config/funcoes.php");
include_once("../includes/validaSession.php");

extract($_POST);

if(strlen($descricao) > 25){
	die(json_encode(array("status" => false, "message" => "Tamanho limite de 25 caracteres atingido")));
}

update(	$conn, 
	array("descricao"),
	array($descricao),
	"posts",
	"WHERE ID = {$postID}"
);

die(json_encode(array("status" => true, "message" => "Post atualizado")));