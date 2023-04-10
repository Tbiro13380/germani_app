(function($) {
  
  "use strict";  

	$(window).on('load', function() {


		/*Page Loader active
		========================================================*/
		$('#preloader').fadeOut();
        $('#preloader2').hide();

		// Sticky Nav
		$(window).on('scroll', function() {
			if ($(window).scrollTop() > 100) {
				$('.scrolling-navbar').addClass('top-nav-collapse');
			} else {
				$('.scrolling-navbar').removeClass('top-nav-collapse');
			}
		});

		/* Auto Close Responsive Navbar on Click
		========================================================*/
		function close_toggle() {
			if ($(window).width() <= 768) {
				$('.navbar-collapse a').on('click', function () {
					$('.navbar-collapse').collapse('hide');
				});
			}
			else {
				$('.navbar .navbar-inverse a').off('click');
			}
		}
		close_toggle();
		$(window).resize(close_toggle);

		// one page navigation 
		$('.navbar-nav').onePageNav({currentClass: 'active'});

		/* slicknav mobile menu active  */
		$('.mobile-menu').slicknav({
			prependTo: '.navbar-header',
			parentTag: 'liner',
			allowParentLinks: true,
			duplicate: true,
			label: '',
			closedSymbol: '<i class="lni-chevron-right"></i>',
			openedSymbol: '<i class="lni-chevron-down"></i>',
		});

		  /* WOW Scroll Spy
		========================================================*/
		 var wow = new WOW({
			mobile: false //disabled for mobile
		});
		wow.init();

		/* 
	   VIDEO POP-UP
	   ========================================================================== */
		$('.video-popup').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false,
		});

		/* Back Top Link active
		========================================================*/
		var offset = 200;
		var duration = 500;
		$(window).scroll(function() {
			if ($(this).scrollTop() > offset) {
				$('.back-to-top').fadeIn(400);
			} else {
				$('.back-to-top').fadeOut(400);
			}
		});

		$('.back-to-top, .navbar-brand').on('click',function(event) {
			event.preventDefault();
			$('html, body').animate({scrollTop: 0}, 600);
			return false;
		});

		$(".getCEP").click(function(){
		
			//var cepCode = $(this).val();
			var cepCode = $("#cep").val();
			if(cepCode.length <= 0) return false;
	
			 $.ajax({
				type: 'GET',
				url: "posts/getEndereco.php?cep="+cepCode,
				dataType: 'json',
				success: function(result) {
					
					if(result.cep == false){
						alert("<strong>Não conseguimos encontrar o seu endereço.</strong><br />Por favor tente novamente.");
						
						$("#labelEndereco").hide().html('');
						$("#labelBairro").hide().html('');
						$("#labelCidade").hide().html('');
						$("#labelUf").hide().html('');
						
						$("input#endereco").val('');
						$("input#bairro").val('');
						$("input#cidade").val('');
						$("input#uf").val('');
	
						return false;
					}else{
						/*var nameField = $("#uf").attr("data-name-field");
						$.ajax({ 
							type: "POST",
							url: "posts/postCidades.php?estadoUF="+result.uf+"&cidadeSelected="+unescape(result.cidade)+"&nameField="+nameField,
							data: $("form").serialize(),
							success: function(result){
								$(".show-cidades").html(result);
							}
						});*/
						$("input#numero").show();
						$("input#complemento").show();
						
						
						$("#labelEndereco").show().html('<strong>Endereço:</strong> '+result.logradouro);
						$("#labelBairro").show().html('<strong>Bairro:</strong> '+result.bairro);
						$("#labelCidade").show().html('<strong>Cidade:</strong> '+result.cidade);
						$("#labelUf").show().html('<strong>Estado:</strong> '+result.uf);
						//$("input#cep").val(result.cep);
						//$('#uf option:contains("'+result.uf+'")').prop('selected', true);
						$("input#endereco").val(result.logradouro);
						$("input#bairro").val(result.bairro);
						$("input#cidade").val(result.cidade);
						$("input#uf").val(result.uf);
						
						
						swal({
							title: "Sucesso!",
							html: "Endereço encontrado!",
							type: "success",
							showCancelButton: false,
							closeOnConfirm: false
						});
						
					}
	
				},
				error: function(result) {
					swal({
						title: "Erro",
						html: "Não conseguimos encontrar o seu endereço<br>Por favor preencha os campos manualmente",
						type: "error",
						showCancelButton: false,
						closeOnConfirm: false
					});
	
	
					$("input#numero").hide();
					$("input#complemento").hide();
					$("#labelEndereco").hide().html('');
					$("#labelBairro").hide().html('');
					$("#labelCidade").hide().html('');
					$("#labelUf").hide().html('');
					
					$("input#endereco").val('');
					$("input#bairro").val('');
					$("input#cidade").val('');
					$("input#uf").val('');
	
				},
			});
			
		});

		$(".getCEP-cliente").click(function(){
		
			//var cepCode = $(this).val();
			var cepCode = $("#cep").val();
			if(cepCode.length <= 0) return false;
	
			 $.ajax({
				type: 'GET',
				url: "../posts/getEndereco.php?cep="+cepCode,
				dataType: 'json',
				success: function(result) {
					
					if(result.cep == false){
						alert("<strong>Não conseguimos encontrar o seu endereço.</strong><br />Por favor tente novamente.");
						
						$("#labelEndereco").hide().html('');
						$("#labelBairro").hide().html('');
						$("#labelCidade").hide().html('');
						$("#labelUf").hide().html('');
						
						$("input#endereco").val('');
						$("input#bairro").val('');
						$("input#cidade").val('');
						$("input#uf").val('');
	
						return false;
					}else{
						/*var nameField = $("#uf").attr("data-name-field");
						$.ajax({ 
							type: "POST",
							url: "posts/postCidades.php?estadoUF="+result.uf+"&cidadeSelected="+unescape(result.cidade)+"&nameField="+nameField,
							data: $("form").serialize(),
							success: function(result){
								$(".show-cidades").html(result);
							}
						});*/
						$("input#numero").show();
						$("input#complemento").show();
						
						
						$("#labelEndereco").show().html('<strong>Endereço:</strong> '+result.logradouro);
						$("#labelBairro").show().html('<strong>Bairro:</strong> '+result.bairro);
						$("#labelCidade").show().html('<strong>Cidade:</strong> '+result.cidade);
						$("#labelUf").show().html('<strong>Estado:</strong> '+result.uf);
						//$("input#cep").val(result.cep);
						//$('#uf option:contains("'+result.uf+'")').prop('selected', true);
						$("input#endereco").val(result.logradouro);
						$("input#bairro").val(result.bairro);
						$("input#cidade").val(result.cidade);
						$("input#uf").val(result.uf);
						
						
						swal({
							title: "Sucesso!",
							html: "Endereço encontrado!",
							type: "success",
							showCancelButton: false,
							closeOnConfirm: false
						});
						
					}
	
				},
				error: function(result) {
					swal({
						title: "Erro",
						html: "Não conseguimos encontrar o seu endereço<br>Por favor preencha os campos manualmente",
						type: "error",
						showCancelButton: false,
						closeOnConfirm: false
					});
	
	
					$("input#numero").hide();
					$("input#complemento").hide();
					$("#labelEndereco").hide().html('');
					$("#labelBairro").hide().html('');
					$("#labelCidade").hide().html('');
					$("#labelUf").hide().html('');
					
					$("input#endereco").val('');
					$("input#bairro").val('');
					$("input#cidade").val('');
					$("input#uf").val('');
	
				},
			});
			
		});

	});      

}(jQuery));