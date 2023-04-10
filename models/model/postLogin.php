<?php

	if(seo(false, 2) == 'admin') {

		extract($_POST);

		if(!anti_inject($email)){
			die(json_encode(array('status' => false, 'message' => 'Preencha o seu email')));
		}

		if(!anti_inject($senha)){
			die(json_encode(array('status' => false, 'message' => 'Preencha a sua senha')));
		}

		$stmt = $conn->query("SELECT * FROM admin WHERE email = '".$email."' AND senha = '".md5($senha)."'");


		$admin = $stmt->fetch(PDO::FETCH_OBJ);

		if($admin){
			$_SESSION['adminID'] = $admin->ID;
			$_SESSION['adminNome'] = $admin->nome;
			$_SESSION['emailAdmin'] = strtolower($admin->email);
			$_SESSION['senhaAdmin'] = md5($senha); 

			die(json_encode(array("status" => true)));
		} else {
			die(json_encode(array("status" => false, "message" => "Dados informados estão incorretos.")));
		}	


	}


	extract($_POST);

	if(!anti_inject($email)){
		die(json_encode(array('status' => false, 'message' => 'Preencha o seu email')));
	}

	if(!anti_inject($senha)){
		die(json_encode(array('status' => false, 'message' => 'Preencha a sua senha')));
	}

	$stmt = $conn->query("SELECT * FROM clientes WHERE email = '".$email."' AND senha = '".md5($senha)."'");


	$cliente = $stmt->fetch(PDO::FETCH_OBJ);

	if($cliente){
		$_SESSION['usuarioID'] = $cliente->ID;
		$_SESSION['usuarioNome'] = $cliente->nome;
		$_SESSION['emailUsuario'] = strtolower($cliente->email);
		$_SESSION['senhaUsuario'] = md5($senha); 

		die(json_encode(array("status" => true)));
	} else {
		die(json_encode(array("status" => false, "message" => "Dados informados estão incorretos.")));
	}	