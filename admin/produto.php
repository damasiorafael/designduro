<?php
  include("inc/config.php");

  $id = $_GET["id"];
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
            Produtos
            <small>Design Duro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Produto</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <?php
                  $sqlConsultaProduto     = "SELECT DISTINCT
                                              produtos.id,
                                              produtos.nome AS produto,
                                              produtos.material,
                                              produtos.preco,
                                              produtos.peso,
                                              produtos.texto AS descricao,
                                              produtos.link,
                                              produtos.video,
                                              categorias.nome AS categoria
                                            FROM
                                              produtos
                                            LEFT JOIN
                                              categorias ON produtos.id_categoria = categorias.id
                                            WHERE
                                              produtos.id = $id";
                  $resultConsultaProduto  = consulta_db($sqlConsultaProduto);
                  while($consultaProduto  = mysql_fetch_object($resultConsultaProduto)){
                ?>
                    <div class="box-header">
                      <h3 class="box-title"><?php echo $consultaProduto->nome; ?></h3>
                      <a class="btn-add btn btn-app btn-warning pull-right" href="produtos-edit.php?id=<?php echo $consultaProduto->id; ?>"><i class="fa fa-pencil"></i> Editar</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="box-body">
                            <div id="accordion" class="box-group">
                              <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseOne" data-parent="#accordion" aria-expanded="true" class="">
                                      Informações Gerais
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseOne" aria-expanded="true" style="">
                                  <div class="box-body">
                                    <dl class="dl-horizontal">
                                      <dt>Nome</dt>
                                      <dd><?php echo $consultaProduto->produto; ?></dd>

                                      <dt>Categoria</dt>
                                      <dd>
                                        <?php echo $consultaProduto->categoria; ?>
                                      </dd>

                                      <dt>Material</dt>
                                      <dd>
                                        <?php echo $consultaProduto->material; ?>
                                      </dd>

                                      <dt>Peso</dt>
                                      <dd><?php echo $consultaProduto->peso; ?> kg</dd>

                                      <dt>Preço</dt>
                                      <dd>R$ <?php echo $consultaProduto->preco; ?></dd>

                                      <dt>Descrição</dt>
                                      <dd><?php echo $consultaProduto->descricao; ?></dd>

                                      <dt>Link do Pay Pal</dt>
                                      <dd><a href="<?php echo $consultaProduto->link; ?>" target="_blank"><?php echo $consultaProduto->link; ?></a></dd>

                                      <dt>Vídeo</dt>
                                      <dd class="dd-video"><?php echo $consultaProduto->video; ?></dd>

                                      <dt>Imagens</dt>
                                      <dd class="dd-imagens">
                                        <?php
                                            $sqlConsultaImagens   = "SELECT * FROM produtos_imagens WHERE id_produto = $consultaProduto->id ORDER by id ASC";
                                            $resultConsultaImagens  = consulta_db($sqlConsultaImagens);
                                            while($consultaImagens = mysql_fetch_object($resultConsultaImagens)){
                                            ?>
                                                  
                                             <img src="../uploads/<?php echo $consultaImagens->imagem; ?>" width="200" alt="" title="<?php echo $consultaProduto->produto; ?>" rel="<?php echo $consultaImagens->id; ?>" />
                                        <?php
                                            }
                                        ?>
                                      </dd>
                                    </dl>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </div><!-- /.box-body -->

                        </div>
                      </div>
                    </div><!-- /.box-body -->
                <?php
                  }
                ?>
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include("inc/footer.php"); ?>

    </div><!-- ./wrapper -->

    <?php include("inc/footer-scripts.php"); ?>
    </script>
  </body>
</html>
