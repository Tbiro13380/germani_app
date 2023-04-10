<div class="d-flex justify-content-between align-items-center">
	<p class="fs-2 mb-0">Editar fotos post</p>
	<div>
		<a href="/admin/painel/adicionar-foto?ID=<?php echo $_GET['ID'] ?>&clienteID=<?php echo $_GET['clienteID'] ?>" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-plus" ></i></a>
		<a href="/admin/painel/posts-clientes?ID=<?php echo $_GET['clienteID'] ?>" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left" ></i></a>
	</div>
</div>

<?php 
	$sql = "SELECT * FROM posts_imagem WHERE postID = {$_GET['ID']}";

	if($conn->query($sql)->rowCount() == false) {
		echo '<div class="alert mt-3 alert-warning" role="alert">
			Nenhuma foto encontrada, post não sendo exibido
		</div>';
	} else { 
?>
	<div class="row mt-3">
		<script>
			$(document).ready(function(){
				$('.deletar-img').click(function(){
					var imagemID = $(this).attr("data-img-id");
					var confirmacao = confirm("Deseja realmente deletar essa foto?");
					if(confirmacao == true){
						$.ajax({ 
							dataType: 'jsonp',
							url: "models/postDeletarImagem.php?ID="+imagemID,
							data: $("form").serialize(),
							success: function(result){
								if(result.RETORNO == "sucesso"){
									location.reload();
								}else{
									alert("Erro ao deletar esse cliente.");
								}
							} 
						});
					}else{
						return false;
					}
				});

			});
		</script>
		<?php foreach($conn->query($sql)->fetchAll(PDO::FETCH_OBJ) as $ln){  ?>
		<div class="col-lg-3 col-md-6 col-xs-12" style="min-height: 330px;">
			<div class="thumbnail">
				<img class="img-fluid rounded" src="../../../thumb.php?tipo=nor&amp;w=700&amp;h=500&amp;img=uploads/posts/<?php echo $ln->imagem ?>" alt="" />
				<form method="post" action="#" name="formFoto">
					<div class="caption">
					<br />
					<a href="javascript:;" class="btn btn-danger deletar-img" data-img-id="<?php echo $ln->ID ?>" role="button"><span class="glyphicon glyphicon-remove-circle"></span> Deletar</a>
				</form>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
<?php } ?>