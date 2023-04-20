<style>
	@media(min-width: 967px){
		#info-post {
			margin-right: 25%;
		}
	}

	.carousel {
		cursor: grab;
	}

	.sombreado {
		position: absolute;
		top: 0;
		left: 0;
		background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 50%, rgba(0, 0, 0, 0.8) 100%);
	}
	
</style>
<section class="home mb-3">
	<div class="sombreado"></div>
	<div class="container">
		<?php 
			$sqlPosts = "SELECT * FROM posts WHERE clienteID = {$_SESSION['usuarioID']} AND ativo = 'Sim' ORDER BY data DESC";

			if($conn->query($sqlPosts)->rowCount()) {
				foreach($conn->query($sqlPosts)->fetchAll(PDO::FETCH_OBJ) as $post) {
					$sqlImagens = "SELECT * FROM posts_imagem WHERE postID = {$post->ID}";
						if($conn->query($sqlImagens)->rowCount()) {		
							if($conn->query($sqlImagens)->rowCount() == 1) {	
								$img = $conn->query($sqlImagens)->fetch(PDO::FETCH_OBJ);
		?>
								<div class="d-flex mt-3 mb-5 justify-content-center flex-column ">
									<div id="info-post" class="d-flex ms-0 ms-md-auto align-items-end">
										<div class="d-flex ms-2 align-items-center mb-2">
											<i class="fas fa-play me-2" style="color: rgba(0,180,232,1); font-size: 10px;"></i>
											<p class="mb-0"><?php
												$data_obj = new DateTime($post->data);

												echo $data_obj->format('d/m/Y');
											
											?></p>
										</div>
										<div id="radius-nav" class="ms-5 px-2 me-2 text-center radius-bottom blue">
											<p class="py-2 px-1 mb-0"><?php echo $post->descricao ?></p>
										</div>
									</div>
									<div class="photo mx-auto">
										<img src="../../thumb.php?tipo=nor&amp;w=700&amp;h=500&amp;img=uploads/posts/<?php echo $img->imagem ?>" class="img-fluid pinca rounded shadow">
									</div>
								</div>
							<?php } else { ?>
								<style>
									li button:before,
									li.slick-active button:before {
										color: transparent !important;
										opacity: 1 !important;
									}

									li button:before{
										background-color: transparent;
										border: 4px solid #fff;
										border-radius: 50%;
										display: inline-block;
										height: 13px !important;
										width: 13px !important;

									}

									li.slick-active button:before {
										background-color: #fff;
									}
									
								</style>

								<div class="d-flex mt-3 mb-5 justify-content-center flex-column">
									<div id="info-post" class="d-flex ms-0 ms-md-auto align-items-end">
										<div class="d-flex ms-2 align-items-center mb-2">
											<i class="fas fa-play me-2" style="color: rgba(0,180,232,1); font-size: 10px;"></i>
											<p class="mb-0"><?php
												$data_obj = new DateTime($post->data);

												echo $data_obj->format('d/m/Y');
											?></p>
										</div>
										<div id="radius-nav" class="ms-5 px-2 me-2 text-center radius-bottom blue">
											<p class="py-2 px-1 mb-0"><?php echo $post->descricao ?></p>
										</div>
									</div>
									<div class="photo carousel">
										<?php
											foreach($conn->query($sqlImagens)->fetchAll(PDO::FETCH_OBJ) as $img) {
										?>
											<div><img src="../../thumb.php?tipo=nor&amp;w=700&amp;h=500&amp;img=uploads/posts/<?php echo $img->imagem ?>" class="img-fluid pinca rounded shadow mx-auto"></div>
										<?php } ?>
									</div>
								</div>

								<script>
									$(document).ready(function(){
										$('.carousel').slick({
											adaptiveHeight: true,
											lazyLoad: 'progressive',
											arrows: false,
											dots: true
											
										});
									});

									var myImage = $('.pinca');

									myImage.hammer();

									myImage.on('pinch', function(event) {
										// aumenta ou diminui o tamanho da imagem
										var scale = event.scale;
										myImage.css('transform', 'scale(' + scale + ')');
									});
								</script>
						 	<?php } 
						} else { ?>
							<div class="alert alert-warning text-center">
								Olá, <?php echo $_SESSION['usuarioNome'] ?>. Parece que ainda não foram feitas postagens em sua conta.
							</div>
						<?php }
					}
			} else { ?>
				<div class="alert alert-warning text-center">
					Olá, <?php echo $_SESSION['usuarioNome'] ?>. Parece que ainda não foram feitas postagens em sua conta.
				</div>
		<?php } ?>
	</div>
</section>



