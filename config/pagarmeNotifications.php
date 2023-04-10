<?php

	/*

	Quando a postback_url é passada, a transação é retornada com status
	processing, e as mudanças de status são enviadas para o seu servidor na URL
	de postback. Isso é feito através de um request HTTP POST com os seguintes parâmetros:

	"id" - ID da transação.	
	"event" - A qual evento o postback se refere.	
		Transações: "transaction_status_changed"
		Assinatura: "subscription_status_changed"
		Link de Pagamento: "order_status_changed"
		Recebedor: "recipient_status_changed"
	"old_status" - Status anterior da transação.	
	"desired_status" - Status ideal para objetos deste tipo, em um fluxo normal, onde autorização e captura são feitos com sucesso, por exemplo.	
	"current_status" - Status para o qual efetivamente mudou.	
	"object" - Qual o tipo do objeto referido.	
		Transações: "transaction"
		Assinaturas: "subscription"
		Link de Pagamento: "order"
		Recebedor: "recipient"
	"transaction" - Possui todas as informações do objeto. Para acessar objetos internos basta acessar a chave transaction[objeto1][objeto2]. Ex: para acessar o ddd: transaction[phone][ddd]

	*/

	session_start();
	include_once("conexao.php");
	include_once("funcoes.php");

	if($_POST['transaction']['status'] == 'paid'){
		update($conn, array("status"), array("Pagamento confirmado"), "compras", "WHERE transacao = '".$_POST['transaction']['tid']."'");
	}

	insert($conn, array("log", "data", "usuario", "secao"), array(serialize($_POST), date('Y-m-d H:i:s'), '', 'notificação'), "logs_checkout");

	http_response_code(200);
	exit();