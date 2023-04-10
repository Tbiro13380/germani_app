<div class="d-flex justify-content-between align-items-center">
	<p class="fs-2 mb-0">Editar post</p>
	<a href="/admin/painel/posts-clientes?ID=<?php echo $_GET['clienteID'] ?>" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left" ></i></a>
</div>

<?php

	$sql = "SELECT * FROM posts WHERE ID = {$_GET['ID']}";

	$post = $conn->query($sql)->fetch(PDO::FETCH_OBJ);

?>

<form class="formPost mt-3" name="formPost" enctype="multipart/form-data">
	<input type="hidden" name="postID" value="<?php echo $_GET['ID'] ?>">

	<div class="form-group w-md-50 w-100">
		<label for="descricao">Descrição</label>
		<input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $post->descricao ?>" />
	</div>

	<button onClick="return false;" id="editPost" class="btn btn-success w-md-50 w-100  mt-4" type="submit" name="enviar">EDITAR</button>
</form>

<script>
	$('#editPost').click(function(){

		$.ajax({ 
			type: "POST",
			dataType: 'json',
			url: "models/postEditarPost.php",
			data: $('.formPost').serialize(),
			success: function(result){
				if(result.status){
					Swal.fire({title: 'Sucesso', text: result.message, icon: 'success'}).then(function(){
						window.location = '/admin/painel/posts-clientes?ID=<?php echo $_GET['clienteID'] ?>';
					});
				} else {
					Swal.fire({title: 'Atenção!', text: result.message, icon: 'error'})
				}
			} 
		});
	});
</script>