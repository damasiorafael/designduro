<?php
  include("inc/config.php");
  if((!isset($_SESSION['username']) == true) and (!isset($_SESSION['senha']) == true)) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
  <?php include("inc/head.php"); ?>
  <body class="skin-blue">
    <div class="wrapper">
      
      <?php include("inc/header.php"); ?>
      
      <?php include("inc/sidebar.php"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Design Duro
            <small>Admin</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Admin</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">

            <div class="col-md-12">
              <!-- LISTA DE PROGRAMAS RECENTES -->
              <div class="box box-primary box-programas-recentes">
                <div class="box-header with-border">
                  <h3 class="box-title">Produtos adicionados recentemente</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <ul class="products-list product-list-in-box">
                    <?php
                      $sqlConsultaProdutos  = "SELECT DISTINCT
                                                `produtos`.id AS id,
                                                `produtos`.nome AS produto,
                                                `produtos`.texto AS descricao,
                                                MAX(`produtos_imagens`.imagem) AS imagem,
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
                                                `produtos_imagens`.id_produto = `produtos`.id
                                               ORDER BY
                                                `produtos`.id
                                               DESC LIMIT 8";
                      $resultConsultaProdutos  = consulta_db($sqlConsultaProdutos);
                      $numRowProdutos = mysql_num_rows($resultConsultaProdutos);
                      if($numRowProdutos > 0){
                        while($consultaProdutos  = mysql_fetch_object($resultConsultaProdutos)){
                    ?>
                          <li class="item">
                            <div class="product-img">
                              <img src="../uploads/<?php echo $consultaProdutos->imagem; ?>" />
                            </div>
                            <div class="product-info">
                              <a class="product-title" href="produto.php?id=<?php echo $consultaProdutos->id; ?>">
                                <?php echo $consultaProdutos->produto; ?>
                                <span class="label label-warning pull-right"><?php echo $consultaProdutos->categoria; ?></span>
                              </a>
                              <span class="product-description">
                                <?php echo substr(strip_tags($consultaProdutos->descricao),0,300); ?>
                              </span>
                            </div>
                          </li><!-- /.item -->
                    <?php
                        }
                      } else {
                    ?>
                          <li class="item">
                            <div class="product-img">
                              <img src="http://placehold.it/50x50/d2d6de/ffffff" />
                            </div>
                            <div class="product-info">
                              <a class="product-title" href="#">Nenhum registro encontrado</a>
                              <span class="product-description">
                                Nenhum registro encontrado
                              </span>
                            </div>
                          </li><!-- /.item --> 
                    <?php
                      }
                    ?>
                  </ul>
                </div><!-- /.box-body -->
                <div class="box-footer text-center">
                  <a class="uppercase" href="produtos.php">Ver todos os produtos</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include("inc/footer.php"); ?>
    </div><!-- ./wrapper -->

    <?php include("inc/footer-scripts.php"); ?>
  </body>
</html>