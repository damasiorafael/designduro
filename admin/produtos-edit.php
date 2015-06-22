<?php
  include("inc/config.php");
  if((!isset($_SESSION['username']) == true) and (!isset($_SESSION['senha']) == true)) header('Location: login.php');
  $id = $_GET['id'];
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
            <li class="active">Produtos</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Editar Produto</h3>
                </div><!-- /.box-header -->
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
                                              produtos.ordem_video,
                                              categorias.nome AS categoria,
                                              categorias.id AS id_categoria
                                            FROM
                                              produtos
                                            LEFT JOIN
                                              categorias ON produtos.id_categoria = categorias.id
                                            WHERE
                                              produtos.id = $id LIMIT 1";
                  $resultConsultaProduto  = consulta_db($sqlConsultaProduto);
                  $consultaProduto  = mysql_fetch_object($resultConsultaProduto)
                ?>
                  <div class="box-body">
                    <div class="row">
                      <form action="produtos-acoes-edit.php" enctype="multipart/form-data" id="programas-add" class="programas-add" method="post" validate>
                        <input type="hidden" id="id" name="id" value="<?php echo $consultaProduto->id; ?>" class="display-none">

                        <div class="form-group col-xs-4">
                          <label for="id_categoria">Categoria</label>
                          <select id="id_categoria" name="id_categoria" class="form-control" required>
                            <option value="">-- Selecione --</option>
                            <?php
                              $sqlConsultaCategorias      = "SELECT * FROM categorias";
                              $resultConsultaCategorias   = consulta_db($sqlConsultaCategorias);
                              while($consultaCategorias   = mysql_fetch_object($resultConsultaCategorias)){
                            ?>
                                <option value="<?php echo $consultaCategorias->id; ?>" <?php if($consultaProduto->id_categoria == $consultaCategorias->id) echo "selected"; ?>><?php echo utf8_encode($consultaCategorias->nome); ?></option>
                            <?php
                              }
                            ?>
                          </select>
                        </div>

                        <div class="form-group col-xs-8">
                          <label for="nome">Nome</label>
                          <input type="text" id="nome" name="nome" placeholder="Nome do Produto" class="form-control" value="<?php echo $consultaProduto->produto; ?>" required>
                        </div>

                        <div class="form-group col-xs-4">
                          <label for="materia">Material</label>
                          <input type="text" id="material" name="material" placeholder="Material" class="form-control" value="<?php echo $consultaProduto->material; ?>" required>
                        </div>

                        <div class="form-group col-xs-4">
                          <label for="preco">Preço (R$)</label>
                          <input type="text" id="preco" name="preco" placeholder="Preço" class="form-control" value="<?php echo $consultaProduto->preco; ?>" required>
                        </div>

                        <div class="form-group col-xs-4">
                          <label for="peso">Peso (KG)</label>
                          <input type="text" id="peso" name="peso" placeholder="Peso" class="form-control" value="<?php echo $consultaProduto->peso; ?>" required>
                        </div>

                        <div class="form-group col-xs-12">
                          <label for="link">Link do Pay Pal</label>
                          <input type="text" id="link" name="link" placeholder="Link do Pay Pal" class="form-control" value="<?php echo $consultaProduto->link; ?>" required>
                        </div>

                        <div class="form-group col-xs-10">
                          <label for="video">Embed de vídeo</label>
                          <input type="text" id="video" name="video" placeholder="Embedo de vídeo" class="form-control" value="<?php echo $consultaProduto->video; ?>" required>
                        </div>

                        <div class="form-group col-xs-2">
                          <label for="ordem_video">Ordem do vídeo</label>
                          <input type="text" id="ordem_video" name="ordem_video" placeholder="Ordem do vídeo" class="form-control" value="<?php echo $consultaProduto->ordem_video; ?>" required>
                        </div>

                        <div class="form-group form-group-textarea col-xs-12">
                          <label for="texto">Descrição</label>
                          <textarea class="form-control textarea" id="texto" name="texto" placeholder="Descrição" required><?php echo $consultaProduto->descricao; ?></textarea>
                        </div>

                        <div class="form-group form-group-textarea col-xs-12">
                          <button type="submit" class="btn btn-lg btn-success pull-right">
                            <i class="fa fa-check"></i>Salvar
                          </button>
                        </div>
                      </form>
                    </div>
                  </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include("inc/footer.php"); ?>

    </div><!-- ./wrapper -->

    <?php include("inc/footer-scripts.php"); ?>

  </body>
</html>
