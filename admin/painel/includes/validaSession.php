<?php 
	date_default_timezone_set('America/Sao_Paulo');
	// Verifica se existe a sess達o
	if($_SESSION['emailAdmin'] == true or $_SESSION['senhaAdmin'] == true)
	{
		// Se existir a sess達o, verifica se os dados da sess達o existe no banco
		$consulta = "SELECT * FROM admin WHERE email = '".anti_inject($_SESSION['emailAdmin'])."' AND senha = '".anti_inject($_SESSION['senhaAdmin'])."'";
		if($conn->query($consulta)->rowCount() == true)
		{
			$ln = $conn->query($consulta)->fetch(PDO::FETCH_OBJ);
			// Compara os dados
			if(strtolower($ln->email) != anti_inject($_SESSION['emailAdmin']) or $ln->senha != anti_inject($_SESSION['senhaAdmin']) or $ln->status == "Inativo")
			{
				header("Location: ".URL_SITE."/admin/painel/includes/sair.php");
			}
		}
		else
		{
			header("Location: ".URL_SITE."/admin/painel/includes/sair.php");
		}
	}
	else
	{
		header("Location: ".URL_SITE."/admin/painel/includes/sair.php");
	}
?>