<?php 
	date_default_timezone_set('America/Sao_Paulo');
	// Verifica se existe a sessão
	if($_SESSION['emailUsuario'] == true or $_SESSION['senhaUsuario'] == true)
	{
		// Se existir a sessão, verifica se os dados da sessão existe no banco
		$consulta = "SELECT * FROM clientes WHERE email = '".anti_inject($_SESSION['emailUsuario'])."' AND senha = '".anti_inject($_SESSION['senhaUsuario'])."'";

		if($conn->query($consulta)->rowCount() == true)
		{
			$ln = $conn->query($consulta)->fetch(PDO::FETCH_OBJ);
			// Compara os dados
			if($ln->email != anti_inject($_SESSION['emailUsuario']) or $ln->senha != anti_inject($_SESSION['senhaUsuario']))
			{
				header("Location: ".URL_SITE."/app/includes/sair.php");
			}
		}
		else
		{
			header("Location: ".URL_SITE."/app/includes/sair.php");
		}
	}
	else
	{
		header("Location: ".URL_SITE."/app/includes/sair.php");
	}
?>