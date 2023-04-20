<?php
	$sql = "SELECT * FROM clientes WHERE ID = {$_SESSION['usuarioID']}";

	$cliente = $conn->query($sql)->fetch(PDO::FETCH_OBJ);

?>
<section class="fixed-top">
	<nav class="navbar shadow" style="background-color: #e2e0df">
		<div class="container d-flex">
			<div class="navbar-brand d-flex align-items-center">
				<a href="app/home" style="text-decoration: none">
					<img id="brand-logo" src="../../assets/img/logo.png" style="width: 6.5%; border-right: 1px solid white;" class="pe-md-2 pe-1 img-fluid">
					<img id="brand-logotext" src="../../assets/img/logo-textblack.png" style="width: 17.5%" class="img-fluid ps-md-2 ps-1" >
				</a>

				<li style="list-style: none;" class="nav-item ms-auto dropdown no-arrow">
					<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
						data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<h3 class="brand-name">Olá, <?php echo $cliente->nome ?></h3>
					</a>
					<!-- Dropdown - User Information -->
					<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
						aria-labelledby="userDropdown">
						<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#perfilModal">
							<i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>
							Perfil
						</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
							<i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>
							Sair
						</a>
					</div>
				</li>

			</div>
		</div>
	</nav>
	<div id="radius-nav" class="blue text-center w-50 mx-auto radius-top">
		<p class="my-auto py-2">SIGA O ANDAMENTO DO SERVIÇO CONTRATADO</p>
	</div>
</section>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content text-muted">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">Clique em sair se quiser mesmo encerrar a sua sessão.</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
				<a class="btn btn-primary" href="app/includes/sair.php">Sair</a>
			</div>
		</div>
	</div>
</div>

<!-- Modal Perfil -->

<div class="modal fade" id="perfilModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content text-muted">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><?php 
				$hora_atual = date("H");

				if ($hora_atual >= 6 && $hora_atual < 12) {
					echo "Bom dia! " . $cliente->nome;
				} elseif ($hora_atual >= 12 && $hora_atual < 18) {
					echo "Boa tarde! " . $cliente->nome;
				} else {
					echo "Boa noite! " . $cliente->nome;
				}

				?></h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close">
				</button>
			</div>
			<div class="modal-body">
				<h5>Altere seus dados</h5>

				<form class="formPerfil">
					<input type="hidden" name="id" value="<?php echo $cliente->ID ?>">
					<div class="form-group w-md-50 w-100">
						<label for="nome">Nome</label>
						<input type="text" class="form-control" id="nome" name="nome" value="<?php echo $cliente->nome ?>" />
					</div>
					<div class="form-group w-md-50 w-100">
						<label for="email">Email</label>
						<input type="text" class="form-control" id="email" name="email" value="<?php echo $cliente->email ?>" />
					</div>
					<div class="form-group w-md-50 w-100">
						<label for="senha">Senha atual</label>
						<input type="password" class="form-control" id="senha" name="senha" />
					</div>
					<div class="form-group w-md-50 w-100">
						<label for="csenha">Senha nova</label>
						<input type="password" class="form-control" id="csenha" name="csenha" />
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
				<a id="editPerfil" class="btn btn-primary">Editar</a>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#editPerfil').on("click", function(){
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: 'app/models/postPerfil.php',
				data: $('.formPerfil').serialize(),
				success: function(result){
					if(result.status){
						Swal.fire({title: "Sucesso", html: result.message, icon: "success"}).then(function(){
							location.reload();
						})
					} else {
						Swal.fire({title: "Atenção!", html: result.message, icon: "error"});
					}
				}
			})
		})
	})
</script>