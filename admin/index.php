<?php
	session_start();
	ob_start();

	include_once("../config/conexao.php");
	include_once("../config/funcoes.php");
	include_once("../config/Mobile_Detect.php");
	
	date_default_timezone_set('America/Sao_Paulo');
    
	//registraVisitaNavegador($conn);
	//registraVisita($conn);
	//registraReferencia($conn);
	// define("HOST_SMTP", sistema($conn, "emailHost"));
	// define("PORTA_SMTP", sistema($conn, "emailPorta"));
	// define("EMAIL_SMTP", sistema($conn, "emailUsuario"));
	// define("SENHA_SMTP", sistema($conn, "emailSenha"));

	if(getIpBlock($conn) == true)
		die('<h1>Falha ao carregar o site, tente novamente mais tarde.</h1><h2>Failed to load the site, please try again later.</h2>');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="description" content="<?php echo sistema($conn, "descricao"); ?>">
	<meta name="author" content="Guilherme Tiburcio - https://github.com/Tbiro13380">
	<meta name="keywords" content="<?php echo sistema($conn, "palavrasChave"); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta property="og:title" content="<?php echo sistema($conn, "titulo"); ?>">

    <title><?php echo sistema($conn, "titulo"); ?></title>

	<base href="<?php echo getProtocol().BASE_SITE."/"; ?>">

    <!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
      crossorigin="anonymous"
    />
    <!-- Icon -->
    <link rel="stylesheet" href="../assets/fonts/line-icons.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="../assets/css/slicknav.css">
    <!-- Owl carousel -->
    <!--<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.css">-->

    <!-- <link href="https://www.dafontfree.net/embed/ZXN0cmFuZ2Vsby1lZGVzc2EtcmVndWxhciZkYXRhLzQ5L2UvMzgyODUvZXN0cmUudHRm" rel="stylesheet" type="text/css"/> -->
    
    <link rel="stylesheet" href="../assets/css/magnific-popup.css">
    <!--<link rel="stylesheet" href="assets/css/nivo-lightbox.css">-->
    <!-- Animate -->
    <link rel="stylesheet" href="../assets/css/animate.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="../assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="../assets/js/sweetalert2/sweetalert2.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body style="min-height: 100vh; display: flex; flex-direction: column;">
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../assets/js/jquery-min.js"></script>
    <script src="../assets/js/popper.min.js"></script> 
    <!-- Bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"
    ></script>
    <!--<script src="assets/js/owl.carousel.min.js"></script>-->
    <script src="../assets/js/jquery.mixitup.js"></script>
    <script src="../assets/js/wow.js"></script>
    <script src="../assets/js/jquery.nav.js"></script>
    <script src="../assets/js/scrolling-nav.js"></script>
    <script src="../assets/js/jquery.easing.min.js"></script>
    <!--<script src="assets/js/jquery.counterup.min.js"></script>-->
    <!--<script src="assets/js/nivo-lightbox.js"></script>-->
    <!-- Sweet Alert -->
    <script src="../assets/js/sweetalert2/sweetalert2.min.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>     
    <script src="../assets/js/waypoints.min.js"></script>   
    <script src="../assets/js/jquery.slicknav.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/form-validator.min.js"></script>
    <script src="../assets/js/contact-form-script.min.js"></script>
    <script src="../assets/js/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>

    <?php 

	$pastaView = 'views';
    $pastaModels = 'models';

	$pageView  = @seo(false, 0).".php";

	if(file_exists($pastaView."/".$pageView)){
		include_once($pastaView."/".$pageView);
        echo "<script>console.log('".$pastaView."/".$pageView."')</script>";
	} else{
		include_once("views/login.php");
        echo "<script>console.log('".$pastaView."/".$pageView."')</script>";
	}
	
	?>

    <script>
        $(document).ready(function(){
            $('.maskData').mask('00/00/0000');
            $('.maskCelular').mask('(00) 0 0000-0000');
            $('.maskCPF').mask('000.000.000-00')
        });

    </script>


  </body>
</html>
