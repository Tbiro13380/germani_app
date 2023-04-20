<?php 

	function validateCard($numeroCartao, $type){

		if($type == "american"){
			$pattern = "/^([34|37]{2})([0-9]{13})$/";//American Express
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}elseif($type == "diners"){
			$pattern = "/^([30|36|38]{2})([0-9]{12})$/";//Diner's Club
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}elseif($type == "discover"){
			$pattern = "/^([6011]{4})([0-9]{12})$/";//Discover Card
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}elseif($type == "mastercard"){
			$pattern = "/^([51|52|53|54|55]{2})([0-9]{14})$/";//Mastercard
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}elseif($type == "visa"){
			$pattern = "/^([4]{1})([0-9]{12,15})$/";//Visa
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}
		elseif($type == "hiper"){
			$pattern = "/^(3841\d{10}(\d{3})?)|(3841\d{15})$/";//Hipercad
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}elseif($type == "elo"){
			$pattern = "/^([6362]{4})([0-9]{12})$/";//Elo
			if(preg_match($pattern,$numeroCartao)){
				$verified = true;
			}else{
				$verified = false;
			}
		}elseif($type == "aura"){
			$verified = true;
		}
		return $verified;

	}

	function valida_cartao($cartao, $cvc = false){
		$cartao = preg_replace("/[^0-9]/", "", $cartao);
		if($cvc) $cvc = preg_replace("/[^0-9]/", "", $cvc);
		$cartoes = array(
			'visa' => array('len' => array(13,16), 'cvc' => 3),
			'master' => array('len' => array(16), 'cvc' => 3),
			'diners' => array('len' => array(14,16), 'cvc' => 3),
			'elo' => array('len' => array(16), 'cvc' => 3),
			'amex' => array('len' => array(15), 'cvc' => 4),
			'discover' => array('len' => array(16), 'cvc' => 4),
			'aura' => array('len' => array(16), 'cvc' => 3),
			'jcb' => array('len' => array(16), 'cvc' => 3),
			'hipercard'  => array('len' => array(13,16,19), 'cvc' => 3),
		);

		switch($cartao){
			case (bool) preg_match('/^(636368|438935|504175|451416|636297)/', $cartao) :
			$bandeira = 'elo';
			break;

			case (bool) preg_match('/^(606282)/', $cartao) :
			$bandeira = 'hipercard';
			break;

			case (bool) preg_match('/^(5067|4576|4011)/', $cartao) :
			$bandeira = 'elo';
			break;

			case (bool) preg_match('/^(3841)/', $cartao) :
			$bandeira = 'hipercard';
			break;

			case (bool) preg_match('/^(6011)/', $cartao) :
			$bandeira = 'discover';
			break;

			case (bool) preg_match('/^(622)/', $cartao) :
			$bandeira = 'discover';
			break;

			case (bool) preg_match('/^(301|305)/', $cartao) :
			$bandeira = 'diners';
			break;

			case (bool) preg_match('/^(34|37)/', $cartao) :
			$bandeira = 'amex';
			break;

			case (bool) preg_match('/^(36,38)/', $cartao) :
			$bandeira = 'diners';
			break;

			case (bool) preg_match('/^(64,65)/', $cartao) :
			$bandeira = 'discover';
			break;

			case (bool) preg_match('/^(50)/', $cartao) :
			$bandeira = 'aura';
			break;

			case (bool) preg_match('/^(35)/', $cartao) :
			$bandeira = 'jcb';
			break;

			case (bool) preg_match('/^(60)/', $cartao) :
			$bandeira = 'hipercard';
			break;

			case (bool) preg_match('/^(4)/', $cartao) :
			$bandeira = 'visa';
			break;

			case (bool) preg_match('/^(5)/', $cartao) :
			$bandeira = 'master';
			break;
		}

		$dados_cartao = $cartoes[$bandeira];
		if(!is_array($dados_cartao))
			return array(false, false, false);

		$valid = true;
		$valid_cvc = false;
		if(!in_array(strlen($cartao), $dados_cartao['len']))
			$valid = false;
		if($cvc AND strlen($cvc) <= $dados_cartao['cvc'] AND strlen($cvc) !=0)
			$valid_cvc = true;
		return array($bandeira, $valid, $valid_cvc);
	}
	
	function getIpBlock($conn){
		return $conn->query("SELECT * FROM ipsbloqueados WHERE ip = '".$_SERVER["REMOTE_ADDR"]."'")->rowCount() ? true : false;
	}

	function antiSpam($conn, $pageInfo, $valorCampo){
		$ip = $_SERVER["REMOTE_ADDR"];
		$navegador = getBrowser();
		$os = getOS();
		$data = date("Y-m-d H:i:s");
		insert($conn, array("data", "ip", "pageInfo", "navegador", "os", "valorCampo"),array($data, $ip, $pageInfo, $navegador, $os, $valorCampo), "anti_spam");
		insert($conn, array("data", "ip"), array($data, $ip), "ipsbloqueados");
	}

	function vip_list($conn, $cliente_id){
		
		
		$result = $conn->query("SELECT ID FROM lojistas WHERE bonificado = 1 ORDER BY nome ASC")->fetchAll(PDO::FETCH_OBJ);
		$vip_list = array();
		foreach($result as $ln) {
			$vip_list[$ln->ID] = true;
		}
				
		/*$vip_list = array(
			//"10027" => true,  //Jair
			//"10072" => true,  //Luciana
			//"10058" => true,  //Tom
			//"10059" => true,  //Rosimeiry
			//"10412" => true,  //Marcus
			//"10418" => true,  //Jaysla
			//"10486" => true,  //Érika
			//"10442" => true,  //Andressa Vilela
			//"10575" => true,  //Gabriel Bento Gotardo
			//"10247" => true,  //Rodrigo Goncalves Martins (pedido temporário)
			//"10615" => true,  //Mayara Rojas Cândido Castilho (pedido temporário)
			//"10616" => true,  //Lucas Favotto Castilho (pedido temporário)
			
			//"10398" => true,  //Claudinei França (pedido temporário)
			//"10286" => true, //	DANIEL BERNARDI NETO  (pedido temporário)
			//"10537" => true,  //Silva Réia até 27/07
			//"10284" => true,  //Marcia Levorato (caso temporario)
			//"10526" => true,  //Juliana Soler: isenção em 16/02 (boleto?)
			//"10529" => true,  //Gleicy Ferreira: isenção em 16/02
			//"10451" => true,  ///Cecilia Paredes: isenção até 21/04
			
			//"10359" => true, //Gerson
			//"10240" => true, //Viviane 
			//"10373" => true //SAMARA DE SOUSA OLIVEIRA (caso temporario)
			
		);*/
		if(@$vip_list[$cliente_id])
			return true;
		return false;
	}

	function checar_pagamento($conn, $cliente_id, $return_payment_status = false){
		if(vip_list($conn, $cliente_id))
			return true;
		
		
		$assinaturaID = uniqueSelect($conn, "plano_lojistas", "WHERE id_lojista = {$cliente_id} ORDER BY id DESC", 'assinaturaID');
		//$status = uniqueSelect($conn, "planos_alunos", "WHERE id_aluno = $cliente_id ORDER BY id DESC", 'status');
		//TODO check pagar.me
		
		$pagarme_token = sistema($conn, "pagarmeToken");
		require_once SYSTEM_SITE_DIR."/config/pagarme/vendor/autoload.php";
		$pagarme = new PagarMe\Client($pagarme_token);
	
		try {
		
			$subscription = $pagarme->subscriptions()->get(['id' => $assinaturaID ]);
	
	
		} catch (Exception $e) {
			//		print_r($e->getErrorMessage());
			/*echo '<pre>';
			//print_r($e);
			print_r($e->getErrorMessage());
			die();*/
			//die(json_encode(array('status' => false, 'message' => ucfirst($e->getErrorMessage()))));
			//die(json_encode(array('status' => false, 'message' => $e->getMessage())));
			return false;
	
		}
		
		
		/*echo '<pre>';
		print_r($subscription);
		echo '</pre>';
		die('????');*/
		
		//if(@$paidTransactions[0]->status)
		if(@$subscription->status == 'paid' || @$subscription->status == 'trialing')
			return true;
		
		return false;
		//return $status;
	}

	function validateEmail($email)
	{
		//filter_var($value, FILTER_VALIDATE_EMAIL)
		if(preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function checar_pagamento_cliente($conn, $cliente_id, $return_payment_status = false){
		if(vip_list($conn, $cliente_id))
			return true;
		
		
		$assinaturaID = uniqueSelect($conn, "plano_clientes", "WHERE ID = {$cliente_id} ORDER BY id DESC", 'assinaturaID');
		//$status = uniqueSelect($conn, "planos_alunos", "WHERE id_aluno = $cliente_id ORDER BY id DESC", 'status');
		//TODO check pagar.me
		
		$pagarme_token = sistema($conn, "pagarmeToken");
		require_once SYSTEM_SITE_DIR."/config/pagarme/vendor/autoload.php";
		$pagarme = new PagarMe\Client($pagarme_token);
	
		try {
		
			$subscription = $pagarme->subscriptions()->get(['id' => $assinaturaID ]);
	
	
		} catch (Exception $e) {
			//		print_r($e->getErrorMessage());
			/*echo '<pre>';
			//print_r($e);
			print_r($e->getErrorMessage());
			die();*/
			//die(json_encode(array('status' => false, 'message' => ucfirst($e->getErrorMessage()))));
			//die(json_encode(array('status' => false, 'message' => $e->getMessage())));
			return false;
	
		}
		
		
		/*echo '<pre>';
		print_r($subscription);
		echo '</pre>';
		die('????');*/
		
		//if(@$paidTransactions[0]->status)
		if(@$subscription->status == 'paid' || @$subscription->status == 'trialing')
			return true;
		

		

		return false;
		//return $status;
	}

	function getOS(){
	    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
	    $os_platform    =   "Unknown OS Platform";
	    $os_array       =   array(
	                            '/windows nt 6.3/i'     =>  'Windows 8.1',
	                            '/windows nt 6.2/i'     =>  'Windows 8',
	                            '/windows nt 6.1/i'     =>  'Windows 7',
	                            '/windows nt 6.0/i'     =>  'Windows Vista',
	                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
	                            '/windows nt 5.1/i'     =>  'Windows XP',
	                            '/windows xp/i'         =>  'Windows XP',
	                            '/windows nt 5.0/i'     =>  'Windows 2000',
	                            '/windows me/i'         =>  'Windows ME',
	                            '/win98/i'              =>  'Windows 98',
	                            '/win95/i'              =>  'Windows 95',
	                            '/win16/i'              =>  'Windows 3.11',
	                            '/macintosh|mac os x/i' =>  'Mac OS X',
	                            '/mac_powerpc/i'        =>  'Mac OS 9',
	                            '/linux/i'              =>  'Linux',
	                            '/ubuntu/i'             =>  'Ubuntu',
	                            '/iphone/i'             =>  'iPhone',
	                            '/ipod/i'               =>  'iPod',
	                            '/ipad/i'               =>  'iPad',
	                            '/android/i'            =>  'Android',
	                            '/blackberry/i'         =>  'BlackBerry',
	                            '/webos/i'              =>  'Mobile'
	                        );
	    foreach ($os_array as $regex => $value){ 
	        if (preg_match($regex, $user_agent))
	            $os_platform = $value;
	    }   
	    return $os_platform;
	}

	function getBrowser(){
	    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
	    $browser        =   "Unknown Browser";
	    $browser_array  =   array(
	                            '/msie/i'       =>  'Internet Explorer',
	                            '/firefox/i'    =>  'Firefox',
	                            '/safari/i'     =>  'Safari',
	                            '/chrome/i'     =>  'Chrome',
	                            '/opera/i'      =>  'Opera',
	                            '/netscape/i'   =>  'Netscape',
	                            '/maxthon/i'    =>  'Maxthon',
	                            '/konqueror/i'  =>  'Konqueror',
	                            '/mobile/i'     =>  'Handheld Browser'
	                        );
	    foreach ($browser_array as $regex => $value){ 
	        if (preg_match($regex, $user_agent)){
	            $browser    =   $value;
	        }
	    }
	    return $browser;
	}
		
	function buscaCEP($cep, $metodo = 'all', $testing = 0){
		if(trim($metodo) == ''){ $metodo = 'all'; }
		$cep = trim(str_replace('-', '', $cep));
		$dados = array('resultado'=> 0);
		// métido 1 via cep
		if($metodo == 'all' or $metodo == 1){
			$dadosvia = @json_decode(@file_get_contents('http://viacep.com.br/ws/'.$cep.'/json/'), true);
			if($dadosvia['localidade'] != ''){
				$dados = array(
					'resultado'=> 1,
					'uf'=> ($dadosvia['uf']),
					'cidade'=> ($dadosvia['localidade']),
					'bairro'=> ($dadosvia['bairro']),
					'logradouro'=> ($dadosvia['logradouro']),
					'cep'=> $cep,
					'metodo'=> 1
				);
			}else{
				$dados = array('resultado'=> 0, 'metodo'=> 2);
			}
			if($testing == 1){ print_r($dados); }elseif($dados['resultado'] == 1){ return $dados; die(); }
		}
		
		// métido 2 html correios
		if($dados['resultado'] == 0 AND ($metodo == 'all' or $metodo == 2)){
			
			include('phpQuery-onefile.php');
			function simple_curl($url,$post=array(),$get=array()){
				$url = explode('?',$url,2);
				if(count($url)===2){
					$temp_get = array();
					parse_str($url[1],$temp_get);
					$get = array_merge($get,$temp_get);
				}
			
				$ch = curl_init($url[0]."?".http_build_query($get));
				curl_setopt ($ch, CURLOPT_POST, 1);
				curl_setopt ($ch, CURLOPT_POSTFIELDS, http_build_query($post));
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				return curl_exec ($ch);
			}
			
			$html = simple_curl('http://m.correios.com.br/movel/buscaCepConfirma.do',array(
				'cepEntrada'=>$cep,
				'tipoCep'=>'',
				'cepTemp'=>'',
				'metodo'=>'buscarCep'
			));
			
			phpQuery::newDocumentHTML($html, $charset = 'UTF-8');
			$errCEP= array('erro'=> trim(pq('.erro:eq(0)')->html()));
			
			if(empty($errCEP["erro"])){
				
				// multiplos locais
				$logradouro = trim(pq('.caixacampobranco .resposta:contains("Logradouro: ") + .respostadestaque:eq(0)')->html());
				if($logradouro != ''){
					$logradouro = explode(' - ', $logradouro);
					$logradouro = trim($logradouro[0]);
				}else{
					$logradouro = trim(pq('.caixacampobranco .resposta:contains("Ender") + .respostadestaque:eq(0)')->html());
					$logradouro = explode(',', $logradouro);
					$logradouro = trim($logradouro[0]);
				}
				
				$cidadeuf = trim(pq('.caixacampobranco .resposta:contains("Localidade / UF: ") + .respostadestaque:eq(0)')->html());
				if($cidadeuf == ''){ $cidadeuf = trim(pq('.caixacampobranco .resposta:contains("Localidade/UF: ") + .respostadestaque:eq(0)')->html()); }
				
				$dados = array(
					'resultado'=> 1,
					'uf'=> '',
					'cidade'=> '',
					'bairro'=> trim(pq('.caixacampobranco .resposta:contains("Bairro: ") + .respostadestaque:eq(0)')->html()),
					'logradouro'=> $logradouro,
					'cidade/uf'=> $cidadeuf,
					'cep'=> trim(pq('.caixacampobranco .resposta:contains("CEP: ") + .respostadestaque:eq(0)')->html()),
					'metodo'=> 2
				);
				
				
				$dados['cidade/uf'] = explode('/',$dados['cidade/uf']);
				$dados['cidade'] = trim($dados['cidade/uf'][0]);
				$dados['uf'] = trim($dados['cidade/uf'][1]);
				unset($dados['cidade/uf']);
			
			}else{
				$dados = array('resultado'=> 0, 'metodo'=> 2);
			}
			if($testing == 1){ print_r($dados); }elseif($dados['resultado'] == 1){ return $dados; die(); }
		}
		// metodo 3 - republica virtal
		if($dado['resultado'] == 0 AND ($metodo == 'all' or $metodo == 3)){
			
		    $dados = json_decode(file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.($cep).'&formato=JSON'), true);
		    $dados['logradouro'] = $dados['tipo_logradouro'].' '.$dados['logradouro'];
		    unset($dados['tipo_logradouro'], $dados['resultado_txt']);
		    
		    $dados['cep'] = $cep;
		    $dados['metodo'] = 3;
		    if($testing == 1){ print_r($dados); }else{ return $dados; die(); }
		}
	    return $dados;
	}
	

	function TrataValor($valor) {
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.', $valor);
		return($valor);
	}

	function encode($q){
		$cryptKey = '1';
		//$qEncoded = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		return base64_encode($q);
	}

	function decode($q){
		$cryptKey = '1';
		//$qDecoded = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return base64_decode($q);
	}

	function dadosLogista($conn, $email, $campo){
		return @$conn->query("SELECT $campo FROM logista WHERE email = '$email'")->fetch(PDO::FETCH_OBJ)->$campo;
	}
	
	function authCliente($conn, $emailCliente, $senhaCliente){
		if(($emailCliente && $senhaCliente) == true){
			$row = $conn->query("SELECT * FROM clientes WHERE email = '$emailCliente' AND senha = '$senhaCliente'")->rowCount();
			if($row)
				return true;
		}
		return false;
	}
	
	
	function getProtocol(){
		if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
			return 'https://';
		return 'http://';
	}

	function checkSSL($ssl, $page, $protocol, $request) {
		if($ssl == true) {
			// Solicitação de adicionar SSL na página
			if($request == "put" and $protocol == "http://") {
				Header("HTTP/1.1 301 Moved Permanently");
				Header("Location: https://".BASE_SITE."/".$page);
			}
			// Solicitação de remover SSL na página
			else if($request == "clear" and $protocol == "https://") {
				Header("HTTP/1.1 301 Moved Permanently");
				Header("Location: http://".BASE_SITE."/".$page);
			}
		} else {
			return false;
		}
	}
	
	#$fotoForm = foto recebida do formulário $_FILES
	#$formatoRedir = resize ou crop (se resize, colocar apenas largura máxima para redimencionar) (se crop, colocar posição, largura e altura fixa)
	#$pasta = diretório que ficará a imagem (após a pasta uploads)
	
	function enviaFoto($fotoForm, $nome_foto, $pasta, $formatoRedir, $posicao, $larguraMaxima, $larguraFixa, $alturaFixa){
		
		$foto = $fotoForm;
		$dir = './';
		$name = $foto['name'];
		$tmpName = $foto['tmp_name'];
		move_uploaded_file($tmpName, $dir.$name);
		$image = wiImage::load("./".$name."");
		if($formatoRedir == "resize"){
			$image = $image->resize($larguraMaxima);	
		}
		elseif($formatoRedir == "crop"){	
			$image = $image->crop($posicao, $posicao, $larguraFixa, $alturaFixa);	
		}

		$image->saveToFile($pasta.$nome_foto);
		unlink("./".$name."");
		return $nome_foto . '.jpg';	
	}

	function reArrayFiles(&$file_post){
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = @array_keys($file_post);
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }
	    return $file_ary;
	}

	function apiMailMega($email, $nome, $celular, $cidade, $estado, $referencia)
	{
		$email      = $email;
		$nome       = str_replace(" ", "+", @$nome);
		$celular    = $celular;
		$cidade     = str_replace(" ", "+", @$cidade);
		$estado     = str_replace(" ", "+", @$estado);
		$referencia = $referencia;

		$api = @file_get_contents("https://mails.jairperes.com.br/api.php?acao=inserir&email=$email&nome=$nome&celular=$celular&cidade=$cidade&estado=$estado&referencia=$referencia");

		// $json = @json_decode($api, true);
		 
		// foreach($json as $key)
		// {
		//     return @$key["retorno"];
		// }
	}

	function MontarLink($texto)
	{
	    if (!is_string ($texto))
	        return $texto;
	      
	    $er = "/(http:\/\/(www\.|.*?\/)?|www\.)([a-zA-Z0-9]+|_|-)+(\.(([0-9a-zA-Z]|-|_|\/|\?|=|&)+))+/i";
	    preg_match_all ($er, $texto, $match);
	    
	    foreach ($match[0] as $link)
	    {
	        //coloca o 'http://' caso o link não o possua
	        $link_completo = (stristr($link, "https://") === false) ? "https://" . $link : $link;
	        
	        $link_len = strlen ($link);
	        
	        
	        //troca "&" por "&amp;", tornando o link válido pela W3C
	       $web_link = str_replace ("&", "&amp;", $link_completo);
	       $texto = str_ireplace ($link, "<a href=\"" . strtolower($web_link) . "\" target=\"_blank\"><strong>". (($link_len > 60) ? substr ($web_link, 0, 25). "...". substr ($web_link, -15) : $web_link) ."</strong></a>", $texto);
	     
	    }
	    
	    return $texto;
	    
	}

	function chaveSite($conn){
		$chave = uniqueSelect($conn, "sistema", "chave", "WHERE ID = 1");
		if($chave == "inativo" and @$_SESSION["emailAdmin"] == false)
			die(header("Location: manutencao"));
	}
	/*
	function registraReferencia($conn){
		$referencia = @parse_url($_SERVER["HTTP_REFERER"])["host"];
		// Busca o registro da referencia e a data de hoje
		$sql = "SELECT * FROM visitas_referencias WHERE site = '$referencia' AND data = '".date("Y-m-d")."'";
		$result = $conn->query($sql)->rowCount();
		$ln = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
		//  Se não existir no banco e não tiver sessão
		if($result == false and @$_SESSION['ContadorReferencias'] == false and $referencia == true){
			$_SESSION['ContadorReferencias'] = md5(uniqid());
			insert($conn, array("site", "visitas", "data"), array($referencia, "1", date("Y-m-d")), "visitas_referencias");
		}
		// Se não existir no banco mas tiver sessão
		elseif($result == false and @$_SESSION['ContadorReferencias'] == true and $referencia == true){
			$_SESSION['ContadorReferencias'] = md5(uniqid());
			insert($conn, array("site", "visitas", "data"), array($referencia, "1",  date("Y-m-d")), "visitas_referencias");
		}
		// Se a sessão não existir mas existir o registro
		elseif(@$_SESSION['ContadorReferencias'] == false and $referencia == true){
			$_SESSION['ContadorReferencias'] = md5(uniqid());
			$novaVisita = $ln->visitas+1;
			update($conn, array("visitas"), array($novaVisita), "visitas_referencias", "WHERE site = '$referencia'");
		}

	}
	
	function registraVisitaNavegador($conn){
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if(preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)){
			$browser_version = $matched[1];
			$browser = 'Internet Explorer';
		}elseif(preg_match('|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)){
			$browser_version = $matched[1];
			$browser = 'Opera';
		}elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)){
			$browser_version = $matched[1];
			$browser = 'Firefox';
		}elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)){
			$browser_version = $matched[1];
			$browser = 'Chrome';
		}elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)){
			$browser_version = $matched[1];
			$browser = 'Safari';
		}else{
			$browser_version = 0;
			$browser= 'Outro';
		}

		if($browser == "Internet Explorer")
			$navegador = $browser." ".$browser_version;
		else
			$navegador = $browser;

		$detect = new Mobile_Detect;
		if($detect->isMobile()){
			if($detect->isAndroidOS())
				$mobile = "Android Mobile";
			if($detect->isiOS())
				$mobile = "IOS Mobile";
		}else{
			$mobile = "";
		}

		// Busca o registro do navegador e a data de hoje
		$sql = "SELECT * FROM visitas_navegador WHERE nome = '".$navegador." ".$mobile."'";
	    $result = $conn->query($sql)->rowCount();
		$ln = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
	   	//  Se não existir no banco e não tiver sessão
	    if($result == false and @$_SESSION['ContadorVisitasNavegador'] == false){
	    	$_SESSION['ContadorVisitasNavegador'] = md5(uniqid());
	    	insert($conn, array("nome", "visitas"), array(($navegador." ".$mobile), "1"), "visitas_navegador");
	    }
	    // Se não existir no banco mas tiver sessão
	    elseif($result == false and @$_SESSION['ContadorVisitasNavegador'] == true){
	    	$_SESSION['ContadorVisitasNavegador'] = md5(uniqid());
	    	insert($conn, array("nome", "visitas"), array(($navegador." ".$mobile), "1"), "visitas_navegador");
	    }
	    // Se a sessão não existir mas existir o registro
	    elseif(@$_SESSION['ContadorVisitasNavegador'] == false){
	    	$_SESSION['ContadorVisitasNavegador'] = md5(uniqid());
	    	$novaVisita = $ln->visitas+1;
	    	update($conn, array("visitas"), array($novaVisita), "visitas_navegador", "WHERE nome = '$navegador'");
	    }
	   
	}

	function registraVisita($conn) {
	    global $_CV;
		$resultado = $conn->query("SELECT COUNT(*) FROM visitas WHERE `data` = CURDATE()")->fetch(PDO::FETCH_ASSOC);
	    // Verifica se é uma visita (do visitante)
	    $nova = (!isset($_SESSION['ContadorVisitas'])) ? true : false;
	    // Verifica se já existe registro para o dia
	    if ($resultado == 0) {
	        $sql = "INSERT INTO visitas VALUES (NULL, CURDATE(), 1, 1)";
	    } else {
	        if ($nova == true) {
	            $sql = "UPDATE visitas SET `uniques` = (`uniques` + 1), `pageviews` = (`pageviews` + 1) WHERE `data` = CURDATE()";
	        } else {
	            $sql = "UPDATE visitas SET `pageviews` = (`pageviews` + 1) WHERE `data` = CURDATE()";
	        }
	    }
	    // Registra a visita
		$conn->query($sql);

	    // Cria uma variavel na sessão
	    $_SESSION['ContadorVisitas'] = md5(time());
	}*/

	/**
	 * Função que retorna o total de visitas
	 *
	 * @param string $tipo - O tipo de visitas a se pegar: (uniques|pageviews)
	 * @param string $periodo - O período das visitas: (hoje|mes|ano)
	 *
	 * @return int - Total de visitas do tipo no período
	 */
	 function pegaVisitas($tipo = 'uniques', $periodo = 'hoje') {
	    global $_CV;

	    switch($tipo) {
	        default:
	        case 'uniques':
	            $campo = 'uniques';
	            break;
	        case 'pageviews':
	            $campo = 'pageviews';
	            break;
	    }

	    switch($periodo) {
	        default:
	        case 'hoje':
	            $busca = "`data` = CURDATE()";
	            break;
	            break;
	        case 'mes':
	            $busca = "`data` BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())";
	            break;
	        case 'ano':
	            $busca = "`data` BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01') AND DATE_FORMAT(CURDATE(), '%Y-12-31')";
	            break;
	    }

	    // Faz a consulta no MySQL em função dos argumentos
	    if ($periodo == "ontem") {
	        $sql = "SELECT $campo FROM visitas WHERE `data` = '".date('Y-m-d', strtotime("-1 days"))."'";
	    } elseif ($periodo == "total") {
	        $sql = "SELECT SUM(`".$campo."`) FROM visitas";
	    } else {
	        $sql = "SELECT SUM(`".$campo."`) FROM visitas WHERE ".$busca;
	    }
		$resultado = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);

	    // Retorna o valor encontrado ou zero
	    return (!empty($resultado)) ? (int)$resultado[0] : 0;
	 }

	// // Pega o total de visitas únicas geral
	// $total = pegaVisitas('uniques', 'total');

	// // Pega o total de visitas únicas de ontem
	// $total = pegaVisitas('uniques', 'ontem');

	// // Pega o total de visitas únicas de hoje
	// $total = pegaVisitas();

	// // Pega o total de visitas únicas desde o começo do mês
	// $total = pegaVisitas('uniques', 'mes');

	// // Pega o total de visitas únicas desde o começo do ano
	// $total = pegaVisitas('uniques', 'ano');

	// // Pega o total de pageviews geral
	// $total = pegaVisitas('pageviews', 'total');

	// // Pega o total de pageviews de ontem
	// $total = pegaVisitas('pageviews', 'ontem');

	// // Pega o total de pageviews de hoje
	// $total = pegaVisitas('pageviews');

	// // Pega o total de pageviews desde o começo do mês
	// $total = pegaVisitas('pageviews', 'mes');

	// // Pega o total de pageviews desde o começo do ano
	// $total = pegaVisitas('pageviews', 'ano');

	/*function UsuariosOnline($key){
		$sql = "SELECT * FROM usuarios_online ORDER BY timeEnd DESC";
		if($conn->query($sql)->rowCount() == true){
			if($key == "total"){
				return $conn->query($sql)->rowCount();
			}elseif($key == true){
				$ln = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
				return $ln->$campo;
			}
		}else{
			return '0';
		}
	}*/
	
	function insertVisitor($conn){
		
		$resultado = $conn->query("SELECT COUNT(*) FROM sys_visitors WHERE 1=1 AND `data` = CURDATE()")->fetch(PDO::FETCH_NUM);
		$nova = (!isset($_SESSION['ContadorVisitas'])) ? true : false; // Verifica se é uma visita (do visitante)
		if($resultado[0] == 0){ // Verifica se já existe registro para o dia
			$sql = "INSERT INTO sys_visitors (uniques, data) VALUES (1, CURDATE())";
		}else{
			if ($nova == true)
				$sql = "UPDATE sys_visitors SET `uniques` = (`uniques` + 1) WHERE `data` = CURDATE()";
		}
		if(isset($sql))
			$conn->query($sql); // Registra a visita
		$_SESSION['ContadorVisitas'] = md5(time()); // Cria uma variavel na sessão
	}

	function sistema($conn, $campo){
		return @$conn->query("SELECT * FROM sistema")->fetch(PDO::FETCH_OBJ)->$campo;
	}
    
    function sendMail($nomeDestino, $emailDestino, $emailRemetente, $assunto, $msg, PDO $conn, $arquivo = ""){
        $montaMsg = '<div style="text-align: left"><img src="../assets/img/logo.png"></div>';
    
        $montaMsg .= '<br /><div style="font-family: Arial; color: #666; font-size: 14px;">'.$msg.'<br /><br />';
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->SMTPDebug   = 1;
		$mail->Debugoutput = 'html';
		$mail->Host        = sistema($conn, "emailHost"); 
		$mail->Port        = sistema($conn, "emailPorta"); 
		$mail->SMTPAuth    = true;
		$mail->Username    = sistema($conn, "emailUsuario"); 
		$mail->Password    = sistema($conn, "emailSenha"); 
		$mail->addReplyTo($emailRemetente, utf8_decode(sistema($conn, "emailNome")));
		$mail->SetFrom("noreply@sandalmaq.com.br", utf8_decode(sistema($conn, "emailNome")));
		$mail->AddAddress($emailDestino, utf8_decode($nomeDestino));
		$mail->Subject = utf8_decode($assunto);
		$mail->msgHTML(utf8_decode($montaMsg));
		if($arquivo == true)
			$mail->AddAttachment($arquivo);

		if(!$mail->send()){
			saveLog($conn, "Falha envio de e-mail: ".$mail->ErrorInfo);
			return false;
		}else{
			return true;
		}
	}

	// function sendMail($nomeDestino, $emailDestino, $nomeRemetente, $emailRemetente, $assunto, $msg, $arquivo = "") {
		
	// 	#$nomeDestino = Nome de quem vai receber
	// 	#$emailDestino = E-mail de quem vai receber
	// 	#$nomeRemetente = Nome de quem está enviando
	// 	#$emailRemetente = E-mail de quem está enviando
	// 	#$assunto = Assunto do e-mail
	// 	#$msg = Mensagem do e-mail
		
	// 	// Monta o e-mail com o header e rodapé
	// 	$montaMsg = '<div style="text-align: left"><img src="'.URL_SITE.'/img/mailHeader.jpg" alt="Header" /></div>';
	// 	$montaMsg .= '<br /><div style="font-family: Arial; color: #666; font-size: 14px;">'.$msg.'<br /><br />';
		
	// 	$mail             = new PHPMailer();		
	// 	$mail->isSMTP();
	// 	$mail->SMTPDebug = 1;
	// 	$mail->Debugoutput = 'html';
	// 	$mail->Host = HOST_SMTP;
	// 	$mail->Port = PORTA_SMTP;
	// 	$mail->SMTPAuth = true;
	// 	$mail->Username = EMAIL_SMTP;
	// 	$mail->Password = SENHA_SMTP;
	// 	$mail->SetFrom(EMAIL_SMTP, $nomeRemetente);
	// 	$mail->addReplyTo($emailRemetente, $nomeRemetente);
	// 	$mail->AddAddress($emailDestino, $nomeDestino);
	// 	$mail->Subject = $assunto;
	// 	$mail->msgHTML($montaMsg);

	// 	if($arquivo == true) {
	// 		$mail->AddAttachment($arquivo);
	// 	}

	// 	if(!$mail->send()) {
	// 		return false;
	// 	} else {
	// 		return true;
	// 	}
	// }

	function dadosAdmin($conn, $campo, $email){
		return $conn->query("SELECT * FROM admin WHERE email = '$email'")->fetch(PDO::FETCH_OBJ)->$campo;
	}

	//Logs
	function saveLog($conn, $log){
		if($log == true){
			if(@$_SESSION["emailAdmin"] == "suporte@megaperes.com.br"){
				$conn->query("INSERT INTO logspainel (ip, data, log, root) VALUES ('".$_SERVER["REMOTE_ADDR"]."', '".date("Y-m-d H:i:s")."', '$log', 'true')");
			}else{
				$conn->query("INSERT INTO logspainel (ip, data, log) VALUES ('".$_SERVER["REMOTE_ADDR"]."', '".date("Y-m-d H:i:s")."', '$log')");
			}
		}
	}

	function verificaSenha($pass){
		$len = strlen($pass);
		$count = 0;
		$array = array("[[:lower:]]+", "[[:upper:]]+", "[[:digit:]]+", "[!#_-]+");
		foreach($array as $a){
			if(ereg($a, $pass))
				$count++;
		}
		if($len > 10)
			$count++;
		return $count;
	}

	#Função para forçar o usuário a digitar letras e números na senha
	function forcaSenha($senha){
		$senhaDigitada = intval(preg_match('/^[a-z\d]+$/i', $senha) && preg_match('/[a-z]/i', $senha) && preg_match('/\d/', $senha));
		if($senhaDigitada == 1)
			return true;
		else
			return false;
	}

	function sql_textos($conn, $tipo, $limite, $replaces){
	    //Verifica se a solicitação da função possuí todos os dados.
	    if($tipo && $limite == false){
			//Se não tiver os dados, imprime mensagem de erro.
		      return htmlentities('Os campos necessários não foram informados!');
		}else{
			//Caso a solicitação estiver correta, busca os dados no banco.
		      $sql = "SELECT * FROM textos WHERE tipo = '$tipo'";
			//Busca o total de linhas para os dados recebidos.
			$cont = @$conn->query($sql)->rowCount();
			//Se a contagem de linha retornar em zero, imprime mensagem de erro.
			if($cont == false){
			    echo htmlentities('As informações recebidas não foram suficiente para retornar os dados do banco de dados');
			}else{
				//Caso a contagem de linhas retornar em "true", busca a linha solicitada.
				  $ln = $conn->query($sql)->fetch(PDO::FETCH_OBJ);
				//Se a solicitação for para mostrar os dados sem tags html.
			       if($replaces == true){
				       return strip_tags(truncate($ln->texto, $limite));
				}else{
				       return truncate($ln->texto, $limite);
				}
			}
		}
	}
	
	function anti_inject($campo, $adicionaBarras = false) {
		$campo = preg_replace("/(from|alter table|select|insert|delete|update|where|drop table|show tables|#|\*|--|\\\\)/i","",$campo);
		$campo = trim($campo);
		$campo = strip_tags($campo);
		//if($adicionaBarras || !get_magic_quotes_gpc())
		$campo = addslashes($campo);
		return $campo;
	}
 
	function tira_acentos($string){
		 $slug = trim($string); // trim the string
		 $slug= preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
		 $slug= str_replace(' ','-', $slug); // replace spaces by dashes
		 $slug= strtolower($slug);  // make it lowercase
		 return $slug;
	}

	function validaCPF($cpf){
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf ); // Extrai somente os números
		if (strlen($cpf) != 11) { // Verifica se foi informado todos os digitos corretamente
			return false;
		}

		if (preg_match('/(\d)\1{10}/', $cpf)) { // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
			return false;
		}

		for ($t = 9; $t < 11; $t++) { // Faz o calculo para validar o CPF
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return false;
			}
		}
		return true;
	}

	function validaCNPJ($cnpj){
		$pontos = array(',','-','.','','/');
		$cnpj = str_replace($pontos,'',$cnpj);
		$cnpj = trim($cnpj);
		if(empty($cnpj) || strlen($cnpj) != 14) return FALSE;
		else {
			if(check_fake($cnpj,14)) return FALSE;
			else {
				$rev_cnpj = strrev(substr($cnpj, 0, 12));
				for ($i = 0; $i <= 11; $i++) {
					$i == 0 ? $multiplier = 2 : $multiplier;
					$i == 8 ? $multiplier = 2 : $multiplier;
					$multiply = ($rev_cnpj[$i] * $multiplier);
					$sum = $sum + $multiply;
					$multiplier++;
	
				}
				$rest = $sum % 11;
				if ($rest == 0 || $rest == 1)  $dv1 = 0;
				else $dv1 = 11 - $rest;
				
				$sub_cnpj = substr($cnpj, 0, 12);
				$rev_cnpj = strrev($sub_cnpj.$dv1);
				unset($sum);
				for ($i = 0; $i <= 12; $i++) {
					$i == 0 ? $multiplier = 2 : $multiplier;
					$i == 8 ? $multiplier = 2 : $multiplier;
					$multiply = ($rev_cnpj[$i] * $multiplier);
					$sum = $sum + $multiply;
					$multiplier++;
	
				}
				$rest = $sum % 11;
				if ($rest == 0 || $rest == 1)  $dv2 = 0;
				else $dv2 = 11 - $rest;
	
				if ($dv1 == $cnpj[12] && $dv2 == $cnpj[13]) return true; //$cnpj;
				else return false;
			}
		}
	}

	function validaCep($cep) {
		$cep = trim($cep);
		$avaliaCep = @ereg("^[0-9]{5}-[0-9]{3}$", $cep);
		if(!$avaliaCep)           
			return false;
		return true;
		
	}

	function validaEmail($email){
		if(preg_match ("/^[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*@[A-Za-z0-9]+([_.-][A-Za-z0-9]+)*\\.[A-Za-z0-9]{2,4}$/", $email))
			return true;
		return false;
	}

	#Função para inverter data do formato 2013-06-19 para 19/06/2013
	function inverteData($data, $separar = '-', $juntar = '-'){
		return str_replace("-", "/", implode($juntar, array_reverse(explode($separar, $data))));
	}

	#Função para inverter data do formato 19/06/2013 para 2013-06-19
	function inverteDataSql($data){
		return implode("-",array_reverse(explode("/",$data)));
	}

	function dataToMysql($data) {
		$data = explode("/", $data);
		return $data[2].'-'.$data[1].'-'.$data[0];
	}
	
	function checkData($data) {
		$data = explode("-", $data);
		return checkdate($data[1], $data[2], $data[0]);
	}

	function changeMaskTel($number, $format = true) {
		// chunk_split("AAAAABBBBBCCCCCDDDDD", 5, '.');
        $newNumb = '';
		$replaces = array(")", "(", "-", " ");
		$number   = str_replace($replaces, "", $number);
		if(strlen($number) == 11) {
			if($format == true) {
				$newNumb  = "(".substr($number, 0, -9).") "; // Só DDD
				$newNumb .= substr($number, 2, -8)." "; // Só o nono
				$newNumb .= substr($number, 3, -4)."-"; // 4 primeiros
				$newNumb .= substr($number, -4); // Últimos 4
			} else {
				$newNumb  = substr($number, 0, -9); // Só DDD
				$newNumb .= substr($number, 2, -8); // Só o nono
				$newNumb .= substr($number, 3, -4); // 4 primeiros
				$newNumb .= substr($number, -4); // Últimos 4
			}
		} else if(strlen($number) == 10) {
			if($format == true) {
				$newNumb  = "(".substr($number, 0, -8).") "; // Só DDD
				$newNumb .= substr($number, 2, -4)."-"; // 4 primeiros
				$newNumb .= substr($number, -4); // Últimos 4
			} else {
				$newNumb  = substr($number, 0, -8); // Só DDD
				$newNumb .= substr($number, 2, -4); // 4 primeiros
				$newNumb .= substr($number, -4); // Últimos 4
			}
		}

		return $newNumb;
	}


	function pegaExt($nome_arq){
		$ext = explode('.',$nome_arq);
		$ext = array_reverse($ext);
			return $ext[0];
	}
	
	function validateCPF($cpf){
		$cpf = preg_replace( '/[^0-9]/is', '', $cpf ); // Extrai somente os números
		if (strlen($cpf) != 11) // Verifica se foi informado todos os digitos corretamente
			return false;

		if (preg_match('/(\d)\1{10}/', $cpf)) // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
			return false;

		for ($t = 9; $t < 11; $t++) { // Faz o calculo para validar o CPF
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf[$c] * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf[$c] != $d) {
				return false;
			}
		}
		return true;
	}

	function changeCPF($cpf, $mask) {
		$maskared = '';
		$k = 0;

		for($i = 0; $i<=strlen($cpf)-1; $i++) {
			if($cpf[$i] == '#') {
				if(isset($val[$k]))
					$maskared .= $cpf[$k++];
			} else {
				if(isset($mask[$i]))
					$maskared .= $mask[$i];
			}
		}
		return $maskared;
	}


	function paginaInicial($conn, $campo){
		return @$conn->query("SELECT * FROM tela_inicial")->fetch(PDO::FETCH_OBJ)->$campo;
	}

	#Retorna o tamanho de um arquivo
	function tamanhoArquivo($arquivo) 
	{
		$tamanhoarquivo = $arquivo;
		/* Medidas */
		$medidas = array('KB', 'MB', 'GB', 'TB');
		/* Se for menor que 1KB arredonda para 1KB */
		if($tamanhoarquivo < 999)
		{
			$tamanhoarquivo = 1000;
		}
		for ($i = 0; $tamanhoarquivo > 999; $i++)
		{
			$tamanhoarquivo /= 1024;
		}
		return round($tamanhoarquivo) . $medidas[$i - 1];
	}

	#Função para cortar textos.	
	function truncate($text, $len){
        if (strlen($text) < $len) {
            return $text;
        }
        $text_words = explode(' ', $text);
        $out = null;


        foreach ($text_words as $word) {
            if ((strlen($word) > $len) && $out == null) {

                return substr($word, 0, $len) . "...";
            }
            if ((strlen($out) + strlen($word)) > $len) {
                return $out . "...";
            }
            $out.=" " . $word;
        }
        return $out;
	}
	
	#Função para apagar pasta completa
	function deletaPasta($rootDir){
		if (!is_dir($rootDir)){
			return false;
		}
		if (!preg_match("/\\/$/", $rootDir)){
			$rootDir .= '/';
		}
		$dh = opendir($rootDir);
		while (($file = readdir($dh)) !== false){
			if ($file == '.'  ||  $file == '..'){
				continue;
			}
			if (is_dir($rootDir . $file)){
				removeTreeRec($rootDir . $file);
			}elseif (is_file($rootDir . $file)){
				unlink($rootDir . $file);
			}
		}
		closedir($dh);
		rmdir($rootDir);
		return true;
	}
	
	
	/* URL AMIGAVEL */
	function slug($string){
		 $slug = trim($string); // trim the string
		 $slug= preg_replace('/[^a-zA-Z0-9 -]/','',$slug ); // only take alphanumerical characters, but keep the spaces and dashes too...
		 $slug= str_replace(' ','-', $slug); // replace spaces by dashes
		 $slug= strtolower($slug);  // make it lowercase
		 return $slug;
	}
	
	
	// Configurando URL Amigável
	function seo($admin, $params){
		
		$seo = explode("/", str_replace(strrchr($_SERVER["REQUEST_URI"], "?"), "", $_SERVER["REQUEST_URI"]));
		array_shift($seo);
		$replaces = array(".html", ".mega");
		if($admin == true)
		{
			return @str_replace($replaces, "", @$seo[$params+PASTA+1]); // Se url amigável for solicitado no admin soma as pastas e adiciona mais um, justamente a pasta "admin".
		}	
		else
		{	
			return @str_replace($replaces, "", @$seo[$params+PASTA]); // Se url amigável for solicitado no site, soma apenas as pastas.
		}
	}
	
	#Função para criar url curta
	function urlCurta($GetUrl){
		$url = urlencode($GetUrl);
		# Posta URL via GET para o Migre.me (verifique se o seu servidor possui suporte à função "file_get_contents")
		$return = @file_get_contents ("https://migre.me/api.json?url={$url}");
		# Converte JSON em array
		$return = json_decode($return);
		# Obtém URL curta
		return $return->migre;
	}
	
	#soNumeros: Deixa somente números em uma string
	function soNumeros($fonte) {
		return preg_replace("/[^0-9]/","",$fonte);
	}
	
	#formataValor: Formata um número para reais (1000.00 -> 1.000,00)
	function formataValor($valor){
		if (!empty($valor)){
			return number_format($valor,2,',','.');
		} else {
			return "0,00";
		}
	}
	
	#nomeMes: retorna o mês do ano
	function nomeMes($mes) { 
		switch($mes) {
			case 1: return "Janeiro"; break;
			case 2: return "Fevereiro"; break;
			case 3: return "Março"; break;
			case 4: return "Abril"; break;
			case 5: return "Maio"; break;
			case 6: return "Junho"; break;
			case 7: return "Julho"; break;
			case 8: return "Agosto"; break;
			case 9: return "Setembro"; break;
			case 10: return "Outubro"; break;
			case 11: return "Novembro"; break;
			case 12: return "Dezembro"; break;
		}			
	}
	
	#nomeDia: retorna o dia da semana (1-dom , 7-sáb)
	function nomeDia($dia) { 
		switch($dia) {
			case 1: return "Domingo"; break;
			case 2: return "Segunda-feira"; break;
			case 3: return "Terça-feria"; break;
			case 4: return "Quarta-feira"; break;
			case 5: return "Quinta-feira"; break;
			case 6: return "Sexta-feira"; break;
			case 7: return "Sábado"; break;
		}			
	}
	
	function diaMes($q){
		$meses = array (1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
		$diasdasemana = array (1 => "Segunda-Feira",2 => "Terça-Feira",3 => "Quarta-Feira",4 => "Quinta-Feira",5 => "Sexta-Feira",6 => "Sábado",0 => "Domingo");
		$hoje = getdate();
		$dia = $hoje["mday"];
		$mes = $hoje["mon"];
		$nomemes = $meses[$mes];
		$ano = $hoje["year"];
		$diadasemana = $hoje["wday"];
		$nomediadasemana = $diasdasemana[$diadasemana];
		
		if($q == "dia"){
			return $nomediadasemana;
		}elseif($q == "mes"){
			return $nomemes;
		}else{
			return false;
		}
	}
	
	function senhaAleatoria($tamanho) {
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 1;
		$pass = '' ;
		while ($i <= $tamanho) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}

	function limpaCPF($valor){
		$valor = trim($valor);
		$valor = str_replace(".", "", $valor);
		$valor = str_replace(",", "", $valor);
		$valor = str_replace("-", "", $valor);
		$valor = str_replace("/", "", $valor);
		return $valor;
	}
	
	#ListaDiretorio: lista o conteúdo de um diretório									
	function ListaDiretorio($diretorio, $tipoarquivo=null){ 
		$d = dir($diretorio); // Abrindo diretório 
		// Fazendo buscar por um arquivo ou diretorio de cada vez que estejam dentro da pasta especificada 
		while (false !== ($entry = $d->read())) {
			if ($tipoarquivo == '') {
				$array[] = $entry;
			}
			else if ($tipoarquivo == 'dir') {  
				// Verificando se o que foi encontrado é um diretorio 
				if (substr_count($entry, '.') == 0){
					// Se sim colocando na matriz 
					$array[] = $entry;
				}
			}
			else { 
				// Verificando se o que foi encontrado um arquivo especifico 
				if (substr_count($entry, $tipoarquivo) == 1) {
					// Se sim colocando na matriz 
					$array[] = $entry; 
				} // end if
			} // end if
		} // end while
	
		//Fechando diretorio 
		$d->close(); 
		if ($array=='') { 
			$array = false; 
		}
		else { 			
			sort ($array); // Colocando em ordem alfabetica 
			reset ($array); // Voltando o ponteiro para o inicio da matriz 
		} 
		return $array; // Retornado resultado final 
	}
	
	
	function parcelamento($preco, $parcela, $valor_minimo = false, $juros = false){
		if($preco >= $valor_minimo){
			if($juros){ //e.g. 1.4
				$j = ($juros/100)*$preco; 
				return $preco/$parcela+$j;
			}
			return $preco/$parcela;
		}
		return false;
	}
	
	function wibank_status($conn, $credito = false){
		return @$conn->query("SELECT valor FROM site_seletocard WHERE chave = 'status'")->fetch(PDO::FETCH_OBJ)->valor;
	}
	
	function wibank($conn, $valor_total){
		$response = array();
		$response['porcentagem'] = @$conn->query("SELECT valor FROM site_seletocard WHERE chave = 'porcentual'")->fetch(PDO::FETCH_OBJ)->valor;
		@$response['valor_final'] = round($valor_total-(($response['porcentagem']/100)*$valor_total), 2);
		$response['credito_usado'] = $valor_total-$response['valor_final'];
		return $response;
	}
	
	
	
	function wibank_user($id){
		
		/*$dados = '{
			"MerchantOrderId": "2014113245231706",
			"Customer": "Comprador rec programada"
		}';

		
		$ch = curl_init("http://sandbox.seletocard.com.br/api/rest/check_user/?cpf=02701732930");
		//$ch = curl_init("http://seletocard2.localhost/api/rest/check_user/?cpf=02701732930");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: '.strlen($dados),
				'Accept: json'
			)
		);

		$result = curl_exec($ch);
		//$res = json_decode($result);
		curl_close($ch);
		var_dump($result);
		echo '----------------';
		//return $res;*/
		

		//echo 'http://seletocard2.localhost/api/rest/check_user/?cpf=02701732930';
		//$result = file_get_contents("https://www.pricefit.com.br/api/rest/academias/");
		//$result = file_get_contents("http://seletocard2.localhost/api/rest/check_user/?cpf=02701732930");
		//$result = file_get_contents("http://sandbox.seletocard.com.br/api/rest/check_user/?cpf=02701732930");
		


		?><li><a href="#">Seu crédito atual é  <span class="pull-right label label-danger">R$20,00</span></a></li><?php
	}
	
	
	function update_fatura_seletocard($post_fatura){
		
		
		
	
		$postdata = http_build_query($post_fatura);
		$opts = array('http' =>
			array(
				'method'  => 'POST',
				'header'  => 'Content-Type: application/x-www-form-urlencoded',
				//'header'  => 'Content-Type: application/json',
				'content' => $postdata
			)
		);
		
		$context  = stream_context_create($opts);
		$result = file_get_contents('https://wibank.com.br/api/rest/update_fatura/', false, $context);
		//$result = json_decode(file_get_contents('http://sandbox.seletocard.com.br/api/rest/update_fatura', false, $context), true); //not working yet
		
		return $result;
	}
	
	
	function check_user($cpfUser){
		$result = json_decode(file_get_contents('https://wibank.com.br/api/rest/check_user/?cpf='.$cpfUser));
		if($result->status)
			return $result->body;
		return false;
	}
	