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

	if(!@$sendmail){
		die(json_encode(array("status" => false, "message" => "Selecione a opção de email")));
	}

	if($conn->query($sql)->rowCount()){
		die(json_encode(array("status" => false, "message" => "Esse email já está cadastrado")));
	}

	insert($conn, array("nome", "email", "senha", "data_cadastro"), array($nome, $email, md5($senha), date('Y-m-d')), "clientes");

	if($sendmail == 'sim'){
		require_once '../../../config/PHPMailer/PHPMailer.php';

		$msgMail = '
			<div style="font-family: Arial, sans-serif;; color: #666; font-size: 14px;">
				Olá, 

				<br><br>

				Sejá bem-vindo a Germani, seu cadastro foi realizado em nosso sistema e voce já pode acompanhar o 
				andamento do seu serviço contratado a qualquer momento. Abaixo as informações de login: 

				<br><br>

				<div>E-mail: <strong>'.utf8_encode($email).'</strong>.</div>

				<br>

				<div>Senha: <strong>'.utf8_decode($senha).'</strong></div>

				<br><br>

				Não se esqueça de alterar a sua senha assim que fizer o login pela primeira vez para garantir a segurança da sua conta.

				<br><br>

				Para fazer o login, acesse <a href="'.URL_SITE.'">o nosso site</a> ou baixe o aplicativo pela <a href="'.URL_SITE.'">Play Store</a> e insira o seu e-mail e senha.

				<br><br>

				Se você tiver alguma dúvida ou precisar de ajuda, estamos sempre à disposição para ajudá-lo.

				<br><br>

				Atenciosamente, <br>
				'.sistema($conn, "titulo").'

			</div>
		';

		try {
			sendMail(
				$nome,
				'guilherme.tiburcio.ferreira@gmail.com', 
				'guilherme.tiburcio.fereira@gmail.com',
				"Cadastro realizado - Germani Implementos", 
				$msgMail,
				$conn
			);
		} catch (Exception $e){
			die(json_encode(array("status" => false, "message" => $e)));
		}
	}

	die(json_encode(array("status" => true, "message" => "Cliente adicionado com sucesso!")));