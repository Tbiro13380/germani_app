<?php


session_start();
include_once("../../../config/conexao.php");
include_once("../../../config/funcoes.php");
include_once("../includes/validaSession.php");

extract($_POST);

if(!$id){
	die(json_encode(array("status" => false, "message" => "Erro")));
}

if(!$status){
	die(json_encode(array("status" => false, "message" => "Erro")));
}

if($status == 'ativo'){
	$ativo = 'Sim';
} else {
	$ativo = 'Nao';
}

update(	$conn, 
	array("ativo"),
	array($ativo),
	"posts",
	"WHERE ID = {$id}"
);

die(json_encode(array("status" => true, "message" => "Post atualizado")));