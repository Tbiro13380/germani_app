<?php


// Conexão Site
define("HOST", "localhost");
define("BANCO", "germani_app");
define("USER", "root");
define("PASS", "");
// SMTP
//define("HOST_SMTP", "localhost");
//define("EMAIL_SMTP", "noreply@lojasandalmaq.com.br");
//define("SENHA_SMTP", "valente14");
//define("PORTA_SMTP", 587);
// Configuração de SSL
define("SSL", false);
// Base do site (Não colocar a última barra no domínio e sem http)
define("BASE_SITE", "germani_app.localhost");
define("URL_SITE", "http://".BASE_SITE);
// Número de pasta na base do site

define('SYSTEM_SITE_DIR', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));

define("PASTA", "");
define("PASTA_PAINEL", "painel");
define("TOKEN_PS", "5F8D870487F64CDF9D5C851B851FE2E0");
define("EMAIL_PS", "sac@lojasandalmaq.com.br");
define("URL_RETORNO_PS", URL_SITE."/compra-finalizada");
// Configurações do painel administrativo
define("TITULO", "Painel Administrativo");
define("AGENCIA", "Mega Peres");
define("TELEFONE_AGENCIA", "(44)3031-4068");
define("SITE_AGENCIA", "megaperes.com.br");
define("NOME_SITE", "Plano Pag");
define("PROGRAMADOR", "Guilherme Tiburcio");
define("EMAIL_SUPORTE", "sac@planopag.com.br");
define("EMAIL_SUPORTE_LOJA", "sac@planopag.com.br");
// Configuração dos módulos TRUE OU FALSE
define("CONFIGURACOES_PAINEL", true);
define("CHAVE_ATIVACAO", true);
define("MODULO_RELATORIOS", true);
define("MODULO_ATENDIMENTO", true);



try{
	$conn = new PDO("mysql:host=".HOST.";dbname=".BANCO."", USER, PASS);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$conn->exec("set names utf8");
}catch(PDOException $e){
	echo "Erro na conexão com banco de dados: " . $e->getMessage();
}

function uniqueSelect(PDO $conn, $table, $where, $field){
	try{
		$sql = $conn->query("SELECT $field FROM $table $where");
		$ln  = $sql->fetch();
		return $ln["$field"];
	}catch(PDOException $e){
		return $e->getMessage();
	}
}

/*
* função para inserir registros no banco de dados
*
* @param string $field O nome da coluna
* @param string $value A informação
* @param string $table O nome da tabela

Inserir vários campos
insert(array("nome","idade","profissao"), array("renan",22,"programador"),"cadastro");

inserir dados em uma única coluna
insert("nome","Renan","cadastro");
*
*/
function insert(PDO $conn, $field,$value,$table){
	if((is_array($field)) and (is_array($value))){
		if(count($field) == count($value)){
			$sql = $conn->query("INSERT INTO {$table} (".implode(', ', $field).") VALUES ('".implode('\', \'', $value)."')");
			if($sql)
				return $conn->lastInsertId();
		}
	}else{
		$sql = $conn->query("INSERT INTO {$table} ({$field}) VALUES ({$value})");
		if($sql)
			return $conn->lastInsertId();
	}
	return false;
}


/*
* função para atualizar registros no banco de dados
*
*
* @param string $field O nome do campo
* @param string $value O novo valor
* @param string $table O nome da tabela
* @param string $where Onde será atualizado
* @return TRUE em caso de sucesso

update(array("tipo","texto"), array("vinicius","nunes"),"textos","WHERE ID = 7");
*/
function update(PDO $conn, $field, $value, $table, $where){
	if((is_array($field)) and (is_array($value))){
		if(count($field) == count($value)){
			$field_value = NULL;
			for ($i=0;$i<count($field);$i++)
				$field_value .= " {$field[$i]} = '{$value[$i]}',";
			$field_value = substr($field_value,0,-1);
			$update = $conn->query("UPDATE {$table} SET {$field_value} {$where}");
			if($update)
				return true;
		}
	}else{
		$update = $conn->query("UPDATE {$table} SET {$field} = '{$value}' {$where}");
		if($update)
			return true;
	}
	return false;
}

function deleteSql(PDO $conn, $table, $where){
	$conn->query("DELETE FROM {$table} {$where}");
}