<?php 
 #0 = root
 #1 = thumb.php
 #2 = 
include_once ('config/Class.thumb.php');
if(isset($_GET["tipo"])){
	if($_GET["tipo"] == "red"){
		$img    = $_GET["img"];
		$largura    = $_GET["w"];
		$altura     = $_GET["h"];
		$oImg = new m2brimagem($img);
		$valida = $oImg->valida();
		if ($valida == 'OK') {
		    $oImg->rgb( 0, 0, 0 );
		    $oImg->redimensiona($largura,$altura,'fill');
		    $oImg->grava('', 70);
		} else {
		    die($valida);
		}
		exit;
	}
	if($_GET["tipo"] == "nor"){
		$img    = $_GET["img"];
		$largura    = $_GET["w"];
		$altura     = $_GET["h"];
		$oImg = new m2brimagem($img);
		$valida = $oImg->valida();
		if ($valida == 'OK') {
		    $oImg->redimensiona($largura,$altura,'crop');
		    $oImg->grava('', 70);
		} else {
		    die($valida);
		}
		exit;
	}
}