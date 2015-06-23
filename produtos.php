<?php include("inc/config.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<?php
	include("inc/head.php");
	$categoria = $_REQUEST["categoria"];
?>
<body>

	<?php include("inc/topo.php"); ?>

	<!-- WRAPPER -->
	<div class="wrapper">

		<?php
			$sqlListaCategoriasProdutos = "SELECT * FROM categorias WHERE id = $categoria";
			$resultListaCategoriasProdutos = consulta_db($sqlListaCategoriasProdutos);
			$consultaListaCategoriasProdutos = mysql_fetch_object($resultListaCategoriasProdutos);
		?>

		<!-- HOME -->
		<section class="module module-header bg-dark bg-dark-50" data-background="uploads/<?php echo $consultaListaCategoriasProdutos->imagem; ?>">

			<div class="container">

				<!-- MODULE TITLE -->
				<div class="row">

					<div class="col-sm-6 col-sm-offset-3">

						<h1 class="module-title font-alt align-center"><?php echo $consultaListaCategoriasProdutos->nome; ?></h1>

						<div class="module-subtitle font-inc align-center">
							<?php echo $consultaListaCategoriasProdutos->texto; ?>
						</div>

					</div>

				</div>
				<!-- /MODULE TITLE -->

			</div>

		</section >
		<!-- /HOME -->

		<!-- PORTFOLIO -->
		<section class="module-small p-t-20 p-b-60">

			<div class="container">

				<!-- PORTFOLIO LIST -->
				<ul id="works-grid" class="works-grid works-grid-gut works-grid-3 works-hover-w">

					<?php
						$sqlProdutos = "SELECT DISTINCT
											`produtos`.id,
											`produtos`.nome,
											MIN(`produtos_imagens`.id) AS id_imagem,
											`categorias`.nome AS categoria
										FROM
											`produtos`
										LEFT JOIN
											`categorias`
										ON 
											`produtos`.id_categoria = `categorias`.id
										LEFT JOIN
											`produtos_imagens`
										ON 
											`produtos`.id = `produtos_imagens`.id_produto
										WHERE
											`categorias`.id = $categoria
										ORDER BY 
											`produtos`.id
										ASC";
						$resultProdutos = consulta_db($sqlProdutos);
						while($consultaProdutos = mysql_fetch_object($resultProdutos)){
					?>

							<!-- PORTFOLIO ITEM -->
							<li class="work-item <?php echo strtolower($consultaProdutos->categoria); ?>">
								<a href="produto-detalhe.php?produto=<?php echo $consultaProdutos->id; ?>">
									<div class="work-image">
										<?php
											$sqlImagemProduto = "SELECT imagem FROM produtos_imagens WHERE id = $consultaProdutos->id_imagem";
											$resultImagemProduto = consulta_db($sqlImagemProduto);
											$consultaimagemProduto = mysql_fetch_object($resultImagemProduto);
										?>
											<img src="uploads/<?php echo $consultaimagemProduto->imagem; ?>" alt="">
									</div>
									<div class="work-caption">
										<h3 class="work-title font-alt"><?php echo $consultaProdutos->nome; ?></h3>
										<div class="work-descr font-inc">
											<?php echo $consultaProdutos->categoria; ?>
										</div>
									</div>
								</a>
							</li>
							<!-- /PORTFOLIO ITEM -->

					<?php
						}
					?>

				</ul>
				<!-- /PORTFOLIO LIST -->

			</div>

		</section>
		<!-- /PORTFOLIO -->

		<?php /*
		<!-- PAGINATION -->
		<section class="module-small p-t-0">

			<div class="container">
			
				<div class="pagination font-inc text-uppercase">
			
					<a href="#"><i class="fa fa-angle-left"></i> Prev</a>
					<a href="#">Next <i class="fa fa-angle-right"></i></a>
			
				</div>
			
			</div>

		</section>
		<!-- /PAGINATION -->
		*/ ?>

		<!-- DIVIDER -->
		<hr class="divider-w">
		<!-- /DIVIDER -->

		<?php include("inc/rodape.php"); ?>

	</div>
	<!-- /WRAPPER -->

	<?php include("inc/footer.php"); ?>

</body>
</html>