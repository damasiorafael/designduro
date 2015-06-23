<?php include("inc/config.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
	include("inc/head.php");
	$produto = $_REQUEST["produto"];
?>
<body>

	<?php include("inc/topo.php"); ?>

	<?php
		$sqlIdProduto = "SELECT id_categoria FROM produtos WHERE id = $produto";
		$resultIdProduto = consulta_db($sqlIdProduto);
		$consultaIdProduto = mysql_fetch_object($resultIdProduto);
		$sqlListaCategoriasProduto = "SELECT * FROM categorias WHERE id = $consultaIdProduto->id_categoria";
		$resultListaCategoriasProduto = consulta_db($sqlListaCategoriasProduto);
		$consultaListaCategoriasProduto = mysql_fetch_object($resultListaCategoriasProduto);
	?>

	<!-- HOME -->
	<section id="home" class="module-hero module-parallax module-fade bg-dark-50" data-background="uploads/<?php echo $consultaListaCategoriasProduto->imagem; ?>">

		<div class="hs-caption container">
			<div class="caption-content">
				<div class="hs-title-size-3 font-alt m-b-20">
					<?php echo $consultaListaCategoriasProduto->nome; ?>
				</div>
				<div class="hs-title-size-1 font-inc">
					<?php echo $consultaListaCategoriasProduto->texto; ?>
				</div>
			</div>
		</div>

	</section >
	<!-- /HOME -->

	<!-- WRAPPER -->
	<div class="wrapper">

		<?php
			$sqlProduto = "SELECT * FROM produtos WHERE id = $produto";
			$resultProduto = consulta_db($sqlProduto);
			$consultaProduto = mysql_fetch_object($resultProduto);
		?>

		<!-- PORTFOLIO DESCRIPTION -->
		<section class="module-small">

			<div class="container">

				<div class="row">

					<div class="col-sm-6">

						<div class="work-details">
							<h3 class="work-details-title font-alt"><?php echo $consultaProduto->nome; ?></h3>
							<ul class="details-product">
								<li class="font-inc"><strong>Material: </strong><?php echo $consultaProduto->material; ?></li>
								<li class="font-inc"><strong>Preço: </strong>R$ <?php echo $consultaProduto->preco; ?></li>
								<li class="font-inc"><strong>Peso: </strong><?php echo $consultaProduto->peso; ?>kg</li>
							</ul>
							<p><a href="<?php echo $consultaProduto->link; ?>" class="btn btn-g btn-round" target="_blank">Comprar</a></p>
						</div>

					</div>

					<div class="col-sm-6">
						<?php echo $consultaProduto->texto; ?>
					</div>

				</div>

			</div>

		</section>

		<!-- /PORTFOLIO DESCRIPTION -->

		<!-- PORTFOLIO CONTENT -->
		<section class="module p-t-0 p-b-0">


			<!-- PORTFOLIO LIST -->
			<ul id="works-grid" class="works-grid works-grid-masonry works-grid-2 works-hover-w">

			<?php 
				$sqlImagens = "SELECT * FROM produtos_imagens WHERE id_produto = $consultaProduto->id";
				$resultImagens = consulta_db($sqlImagens);
				while($consultaImagens = mysql_fetch_object($resultImagens)){
			?>

					<!-- PORTFOLIO ITEM -->
					<li class="work-item">
						<a href="uploads/<?php echo $consultaImagens->imagem; ?>" class="popup" title="<?php echo $consultaProduto->nome; ?>">
							<div class="work-image">
								<img src="uploads/<?php echo $consultaImagens->imagem; ?>" alt="">
							</div>
							<div class="work-caption">
								<h3 class="work-title font-alt">
									<span class="icon-magnifying-glass"></span>
								</h3>
							</div>
						</a>
					</li>
					<!-- /PORTFOLIO ITEM -->

			<?php } ?>

			</ul>

		</section>
		<!-- /PORTFOLIO CONTENT -->

		<!-- DIVIDER -->
		<hr class="divider-w">
		<!-- /DIVIDER -->

		<?php include("inc/rodape.php"); ?>

	</div>
	<!-- /WRAPPER -->

	<?php include("inc/footer.php"); ?>

	<?php if($consultaProduto->video != ""){ ?>
		<script type="text/javascript">
			var video = "<?php echo $consultaProduto->video; ?>";
			var order = "<?php echo $consultaProduto->ordem_video; ?>";
			var qtLis = $("#works-grid li").size();
			$("#works-grid li").eq((parseInt(order)-1)).before("<li class='work-item'>"+video+"</li>");
		</script>
	<?php } ?>

</body>
</html>