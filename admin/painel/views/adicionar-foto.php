<div class="d-flex justify-content-between align-items-center">
	<p class="fs-2 mb-0">Adicionar foto</p>
	<a href="/admin/painel/post-fotos?ID=<?php echo $_GET['ID'] ?>&clienteID=<?php echo $_GET['clienteID'] ?>" class="btn btn-success px-3" style="border-radius: 8px;"><i class="fa-solid fa-arrow-left" ></i></a>
</div>

<form class="formPost mt-3" name="formPost" enctype="multipart/form-data">
	<input type="hidden" name="clienteID" value="<?php echo $_GET['clienteID'] ?>">
	<input type="hidden" name="postID" value="<?php echo $_GET['ID'] ?>">

	<div class="form-group w-md-50 w-100">
		<label for="fotos" class="form-label">Fotos</label>
		<input multiple class="inputfotos form-control" id="fotos" name="fotos_post[]" id="fotos_post[]" type="file" />
	</d iv>
	<button onClick="return false;" id="addPost" class="btn btn-success w-md-50 w-100  mt-4" type="submit" name="enviar">ADICIONAR</button>
</form>

<script>
	$('#addPost').click(function(){

		var formData = new FormData($(".formPost")[0]);

		$.ajax({ 
			type: "POST",
			dataType: 'json',
			url: "models/postPostFotos.php",
			data: formData,
			processData: false,
      		contentType: false,
			success: function(result){
				if(result.status){
					Swal.fire({title: 'Sucesso', text: result.message, icon: 'success'}).then(function(){
						window.location = '/admin/painel/post-fotos?ID=<?php echo $_GET['ID'] ?>&clienteID=<?php echo $_GET['clienteID'] ?>';
					});
				} else {
					Swal.fire({title: 'Atenção!', text: result.message, icon: 'error'})
				}
			} 
		});
	});
</script>