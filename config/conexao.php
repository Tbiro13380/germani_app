<?php


// Conexão Site
define("HOST", "localhost");
define("BANCO", "germani_app");
define("USER", "root");
define("PASS", "");
// Configuração de SSL
define("SSL", false);
// Base do site (Não colocar a última barra no domínio e sem http)
define("BASE_SITE", "germani_app.localhost");
define("URL_SITE", "http://".BASE_SITE);
// Número de pasta na base do site

define('SYSTEM_SITE_DIR', str_replace(DIRECTORY_SEPARATOR,'/',dirname(dirname(__FILE__))));

define("PASTA", "");
define("PASTA_PAINEL", "painel");

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
