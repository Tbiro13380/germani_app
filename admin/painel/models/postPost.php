<?php 

	session_start();
	include_once("../../../config/conexao.php");
	include_once("../../../config/funcoes.php");
	include_once("../includes/validaSession.php");

	extract($_POST);

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	if(!$descricao){
		die(json_encode(array("status" => false, "message" => "Escreva a descrição do post")));
	}

	if(strlen($descricao) > 30){
		die(json_encode(array("status" => false, "message" => "Tamanho limite de 30 caracteres atingido")));
	}

	if(@$_FILES["fotos_post"]["name"] == false){
		die(json_encode(array("status" => false, "message" => "Envie a foto do post")));
	} else {

		$file_ary = reArrayFiles($_FILES['fotos_post']);

		foreach($file_ary as $file) {
			if(pegaExt(@$file["name"]) <> "jpg" and pegaExt(@$file["name"]) <> "jpeg" and pegaExt(@$file["name"]) <> "png" and pegaExt(@$file["name"]) <> "gif" and pegaExt(@$file["name"]) <> "webp"){
				die(json_encode(array("status" => false, "message" => "A imagem de capa deve estar nos formatos JPG, PNG, WEBP ou GIF")));
			}
		}

	}

	$postID = insert($conn, array("descricao", "data", "clienteID"), array($descricao, date('Y-m-d H:i:s'), $clienteID), "posts");

	foreach($file_ary as $file) {
			$nomeArquivo = str_replace(pegaExt(@$file["name"]), "", tira_acentos($file["name"])).rand(0, time()).".".pegaExt(@$file["name"]);	
			include_once('../../../upload.lib/WideImage.inc.php');
			enviaFoto($file, $nomeArquivo, "../../../uploads/posts/", "resize", "", "700", "", "");
			insert($conn, array("postID", "imagem"), array($postID, $nomeArquivo), "posts_imagem");
	}

	die(json_encode(array("status" => true, "message" => "Post enviado com sucesso!")));
	