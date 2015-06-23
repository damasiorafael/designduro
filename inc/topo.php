<!-- PRELOADER -->
	<div class="page-loader">
		<div class="loader">Loading...</div>
	</div>
	<!-- /PRELOADER -->

	<!-- NAVIGATION -->
	<nav class="navbar navbar-custom navbar-transparent navbar-fixed-top" role="navigation">

			<div class="container">
		
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.php"></a>
				</div>
		
				<div class="collapse navbar-collapse" id="custom-collapse">

					<ul class="nav navbar-nav navbar-right">
		
						<li><a href="index.php#sobre">Sobre</a></li>
						
						<?php
							$sqlListaCategoriasMenu = "SELECT * FROM categorias";
							$resultListaCategoriasMenu = consulta_db($sqlListaCategoriasMenu);
							while($consultaListaCategoriasMenu = mysql_fetch_object($resultListaCategoriasMenu)){
						?>
								<!-- <?php echo $consultaListaCategorias->nome; ?> -->
								<li><a href="produtos.php?categoria=<?php echo $consultaListaCategoriasMenu->id; ?>"><?php echo strtoupper($consultaListaCategoriasMenu->nome); ?></a></li>
								<!-- End Produtos -->
						<?php } ?>
		
						<li><a href="#contato">Contato</a></li>
		
					</ul>
				</div>
		
			</div>

	</nav>
	<!-- /NAVIGATION -->