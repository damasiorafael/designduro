<?php include("inc/config.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include("inc/head.php"); ?>
<body>

	<?php include("inc/topo.php"); ?>

	<!-- HOME -->
	<section id="home" class="module-hero module-parallax module-fade module-full-height">

		<div class="hero-slider">
			<ul class="slides">

				<?php
					$sqlSlides = "SELECT * FROM slides";
					$resultSlides = consulta_db($sqlSlides);
					while($consultaSlides = mysql_fetch_object($resultSlides)){
				?>

						<!-- SLIDE -->
						<li class="bg-dark <?php if($consultaSlides->id == 2){ ?> bg-light <?php } ?>">

							<div class="slidebg slide-zoom bg-dark-30 <?php if($consultaSlides->id == 2){ ?> bg-light-30 <?php } if($consultaSlides->id == 3){ ?> bg-dark-50 <?php } ?>" style="background-image:url(uploads/<?php echo $consultaSlides->imagem; ?>)"></div>

							<div class="hs-caption container">
								<div class="caption-content <?php if($consultaSlides->id == 2){ ?> left <?php } if($consultaSlides->id == 3){ ?> right <?php } ?>">
									<div class="hs-title-size-3 font-alt m-b-20">
										<?php echo $consultaSlides->titulo; ?>
									</div>
									<div class="hs-title-size-1 font-inc">
										<?php echo $consultaSlides->texto; ?>
									</div>
								</div>
							</div>

						</li>

				<?php } ?>

			</ul>
		</div>

	</section >
	<!-- /HOME -->

	<!-- WRAPPER -->
	<div class="wrapper">

		<!-- PORTFOLIO -->
		<section class="module-small p-t-20 p-b-60">

			<div class="container">

				<!-- PORTFOLIO FILTER -->
				<div class="row">
					<div class="col-sm-12">

						<ul id="filters" class="filter font-inc hidden-xs">
							<li><a href="#" data-filter="*" class="current wow fadeInUp">All</a></li>
							<?php
								$contSegundos = 2;
								$sqlListaCategorias = "SELECT nome FROM categorias";
								$resultListaCategorias = consulta_db($sqlListaCategorias);
								while($consultaListaCategorias = mysql_fetch_object($resultListaCategorias)){
							?>
									<li><a href="#" data-filter=".<?php echo strtolower(str_replace(' ', '', $consultaListaCategorias->nome)); ?>" class="wow fadeInUp" data-wow-delay="0.<?php echo $contSegundos; ?>s"><?php echo $consultaListaCategorias->nome; ?></a></li>
							<?php
									$contSegundos++;
									$contSegundos++;
								}
							?>
						</ul>

					</div>
				</div>
				<!-- /PORTFOLIO FILTER -->

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
										ORDER BY 
											`produtos`.id
										ASC";
						$resultProdutos = consulta_db($sqlProdutos);
						while($consultaProdutos = mysql_fetch_object($resultProdutos)){
					?>

							<!-- PORTFOLIO ITEM -->
							<li class="work-item <?php echo strtolower($consultaProdutos->categoria); ?>">
								<a href="produto-detalhe.php?id=<?php echo $consultaProdutos->id; ?>">
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

		<!-- TESTIMONIAL -->
		<section class="module-small">

			<div class="container">

				<div class="row">

					<!-- MODULE TITLE -->
					<div class="col-sm-6">
						<h2 class="module-title font-alt">Uma citação</h2>
					</div>
					<!-- /MODULE TITLE -->

					<!-- BLOCKQUOTE -->
					<div class="col-sm-6">
						<blockquote class="font-serif align-right">
							<?php
								$sqlCitacao = "SELECT * FROM citacao";
								$resultCitacao = consulta_db($sqlCitacao);
								$consultaCitacao = mysql_fetch_object($resultCitacao);
							?>
							<p>"<?php echo $consultaCitacao->texto; ?>"</p>
							<p class="font-inc font-uppercase">- <?php echo $consultaCitacao->autor; ?></p>
						</blockquote>
					</div>
					<!-- /BLOCKQUOTE -->

				</div>

			</div>

		</section>
		<!-- /TESTIMONIAL -->


		<?php
			$sqlSobre = "SELECT * FROM sobre";
			$resultSobre = consulta_db($sqlSobre);
			$consultaSobre = mysql_fetch_object($resultSobre);
		?>
		<!-- ABOUT -->
		<section id="sobre" class="module p-t-0 p-b-0" data-background="uploads/<?php echo $consultaSobre->imagem; ?>">

			<div class="container-fluid">

				<div class="row relative">

					<div class="col-sm-12 col-md-6 col-md-offset-6 col-bg">

						<h2 class="module-title font-alt">Sobre</h2>

						<div class="module-subtitle font-inc">
							<?php echo $consultaSobre->frase; ?>
						</div>

						<?php echo $consultaSobre->texto; ?>

						<!-- <ul class="social-list">
							<li><a href="#"><span class="icon-facebook"></span></a></li>
							<li><a href="#"><span class="icon-twitter"></span></a></li>
							<li><a href="#"><span class="icon-googleplus"></span></a></li>
						</ul> -->

					</div>

				</div>

			</div>

		</section>
		<!-- /ABOUT -->

		<?php include("inc/rodape.php"); ?>

	</div>
	<!-- /WRAPPER -->

	<?php include("inc/footer.php"); ?>

</body>
</html>