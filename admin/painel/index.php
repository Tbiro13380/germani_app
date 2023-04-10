<?php

	session_start();
	ob_start();
	include_once("../../config/conexao.php");
	include_once("../../config/funcoes.php");
	include_once("includes/validaSession.php");

	date_default_timezone_set('America/Sao_Paulo');
	
	if(getIpBlock($conn) == true)
		die('<h1>Falha ao carregar o site, tente novamente mais tarde.</h1><h2>Failed to load the site, please try again later.</h2>');


//   $stmt = $conn->query("SELECT l.ID, l.nome, l.nome_loja, l.registro, l.cpf, l.celular, img.imagem,
//   l.email, l.data_cadastro, l.cep, l.endereco, l.id_recebedor, l.numero, l.complemento, l.bairro, pl.id_plano,
//   plano.nome AS plano_nome, pl.status AS plano_status, plano.valor, plano.pagarmeID, pl.assinaturaID,
//   plano.dias_gratis, plano.limite, plano.chamada_checkout, plano.descricao
//   FROM lojistas AS l
//   LEFT OUTER JOIN lojista_imagem AS img ON img.lojistaID = l.ID
//   LEFT OUTER JOIN plano_lojistas AS pl ON pl.id_lojista = l.ID
//   LEFT OUTER JOIN planos AS plano ON plano.ID = pl.id_plano WHERE l.ID = {$_SESSION['lojista']['lojistaID']}
//   ");

//   $cliente = $stmt->fetch(PDO::FETCH_OBJ);

	$stmt = $conn->query("SELECT * FROM admin WHERE ID = {$_SESSION['adminID']} ");

	$admin = $stmt->fetch(PDO::FETCH_OBJ);


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo sistema($conn, "titulo")." | ADMIN"?></title>
	<base href="<?php echo URL_SITE."/admin/painel/"; ?>">
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="description" content="<?php echo sistema($conn, "descricao"); ?>">
	<meta name="author" content="Guilherme Tiburcio - https://github.com/Tbiro13380">
	<meta name="keywords" content="<?php echo sistema($conn, "palavrasChave"); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta property="og:title" content="<?php echo sistema($conn, "titulo"); ?>">

	<!-- Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
      crossorigin="anonymous"
    />
    <!-- Icon -->
    <link rel="stylesheet" href="../../assets/fonts/line-icons.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="../../assets/css/slicknav.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css" integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Owl carousel -->
    <!--<link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.css">-->

    <!-- <link href="https://www.dafontfree.net/embed/ZXN0cmFuZ2Vsby1lZGVzc2EtcmVndWxhciZkYXRhLzQ5L2UvMzgyODUvZXN0cmUudHRm" rel="stylesheet" type="text/css"/> -->
    
    <link rel="stylesheet" href="../../assets/css/magnific-popup.css">
    <!--<link rel="stylesheet" href="assets/css/nivo-lightbox.css">-->
    <!-- Animate -->
    <link rel="stylesheet" href="../../assets/css/animate.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="../editor/css/froala_editor.min.css">
    <!-- Responsive Style -->
    <!-- <link rel="stylesheet" href="../../assets/css/responsive.css"> -->
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="../../assets/js/sweetalert2/sweetalert2.min.css">

    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../../assets/js/jquery-min.js"></script>
    <script src="../../assets/js/popper.min.js"></script> 
    <!-- Bootstrap -->
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8"
      crossorigin="anonymous"
    ></script>
    <!--<script src="assets/js/owl.carousel.min.js"></script>-->
    <script src="../../assets/js/jquery.mixitup.js"></script>
    <script src="../../assets/js/wow.js"></script>
    <script src="../../assets/js/jquery.nav.js"></script>
    <script src="../../assets/js/scrolling-nav.js"></script>
    <script src="../../assets/js/jquery.easing.min.js"></script>
    <!--<script src="assets/js/jquery.counterup.min.js"></script>-->
    <!--<script src="assets/js/nivo-lightbox.js"></script>-->
    <!-- Sweet Alert -->
    <script src="../editor/js/froala_editor.min.js"></script>
    <script src="../../assets/js/jquery.mixitup.js"></script>
    <script src="../../assets/js/highcharts/highcharts.js?v=<?php echo rand(); ?>"></script>
    <script src="../../assets/js/chart.min.js"></script>
    <script src="../../assets/js/highcharts-canvas-tools.js"></script>

    <script src="../../assets/js/sweetalert2/sweetalert2.min.js"></script>
    <script src="../../assets/js/jquery.magnific-popup.min.js"></script>     
    <script src="../../assets/js/waypoints.min.js"></script>   
    <script src="../../assets/js/jquery.slicknav.js"></script>
    <script src="../../assets/js/main.js"></script>
    <script src="../../assets/js/form-validator.min.js"></script>
    <script src="../../assets/js/contact-form-script.min.js"></script>
    <script src="../../assets/js/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>


	<section class="home d-flex">
      <div class="sidebar pe-4" id="side_nav">
        <div class="header-box px-3 pt-3 pb-1 d-flex justify-content-between">
          <p class="fs-5 my-3"><span style="font-size: 32px;" class="text-white">PAINEL</span></p>
          <button class="btn d-md-none d-block close-btn px-2 my-3 py-0 pb-2 text-white">
            <i style="font-size: 22px;" class="fa-solid fa-bars-staggered"></i>
          </button>
        </div>

        <ul class="list-unstyled px-2">
			    <li class="<?php echo seo(false, 2) == 'home' ? 'active' : '' ?>">
            <a href="/admin/painel/home" class="text-decoration-none px-2 py-2 d-block"
              ><i class="fa-solid fa-home pe-2"></i>Home</a
            >
          </li>
          <li class="<?php echo seo(false, 2) == 'configuracoes' ? 'active' : '' ?>">
            <a href="/admin/painel/configuracoes" class="text-decoration-none px-2 py-2 d-block"
              ><i class="fa-solid fa-gear pe-2"></i>Config</a
            >
          </li>
          <li class="<?php echo seo(false, 2) == 'clientes' ? 'active' : '' ?>">
            <a href="/admin/painel/clientes" class="text-decoration-none px-2 py-2 d-block"
              ><i class="fa-solid fa-users pe-2"></i>Clientes</a
            >
          </li>
          </li>
		      <li>
            <a href="includes/sair.php" class="text-decoration-none px-2 mt-5 py-2 d-block"
              ><i class="fa-solid fa-right-from-bracket pe-2"></i>Sair</a
            >
          </li>
          </li>
		      <li>
            <a href="../../login" target="_blank" class="text-decoration-none px-2 py-2 d-block"
              ><i class="fa-solid fa-right-from-bracket pe-2"></i>Ir para site</a
            >
          </li>
        </ul>

      </div>
      <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light py-4" style="border-bottom: 2px solid rgba(0,0,0,0.15);">
          <div class="container-fluid">
            <div class="d-flex justify-content-between d-md-none d-block">
              <a class="navbar-brand fs-4" href="#">ADMINISTRATIVO</a>
              <button style="border: none; outline: none;" class="btn px-0 py-1 pt-2 open-btn text-black">
                <i style="font-size: 16px;" class="fa-solid fa-bars-staggered"></i>
              </button>
            </div>
            <!-- <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button> -->
            <div class="d-none d-md-block">
              <p class="ps-3 mb-0 fs-6">Olá, <?php echo $admin->nome; ?></p>
            </div>
          </div>
        </nav>
        <div class="my-5 p-2 p-md-5 p-xl-5 container bg-white" style="width: 100%; border-radius: 8px; -webkit-box-shadow: 5px 5px 10px 5px rgba(0,0,0,0.15); box-shadow: 5px 5px 10px 5px rgba(0,0,0,0.15);" id="<?php echo seo(true, 0); ?>">
        <?php 
          $pasta = 'views';
          $page  = @seo(false, 2).".php";
          if(file_exists($pasta."/".$page) == true){
            include_once($pasta."/".$page);
            echo "<script>console.log('".$pasta."/".$page."')</script>";
          }else{
            include_once("views/home.php");
            echo "<script>console.log('".$pasta."/".$page."')</script>";
          } 
        ?>		
        </div>
      </div>
    </section>
	<script>


		$(".sidebar ul li").on("click", function () {
			$(".sidebar ul li.active").removeClass("active");
			$(this).addClass("active");
		});

		$(".open-btn").on("click", function () {
			$(".sidebar").addClass("active");
		});

		$(".close-btn").on("click", function () {
			$(".sidebar").removeClass("active");
		});

		$(document).ready(function(){
			$('.maskData').mask('00/00/0000');
			$('.maskCelular').mask('(00) 0 0000-0000');
			$('.maskCPF').mask('000.000.000-00');
		});
    
    </script>
</body>
</html>