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
                  <h3 class="box-title">Adicionar Produto</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="row">
                    <form action="produtos-acoes.php" enctype="multipart/form-data" id="programas-add" class="programas-add" method="post" validate>

                      <div class="form-group col-xs-4">
                        <label for="id_categoria">Categoria</label>
                        <select id="id_categoria" name="id_categoria" class="form-control" required>
                          <option value="">-- Selecione --</option>
                          <?php
                            $sqlConsultaCategorias      = "SELECT * FROM categorias";
                            $resultConsultaCategorias   = consulta_db($sqlConsultaCategorias);
                            while($consultaCategorias   = mysql_fetch_object($resultConsultaCategorias)){
                          ?>
                              <option value="<?php echo $consultaCategorias->id; ?>" <?php if(isset($_SESSION['id_categoria']) && $_SESSION['id_categoria'] == $consultaCategorias->id) echo "selected"; ?>><?php echo utf8_encode($consultaCategorias->nome); ?></option>
                          <?php
                            }
                          ?>
                        </select>
                      </div>

                      <div class="form-group col-xs-8">
                        <label for="nome">Nome</label>
                        <input type="text" id="nome" name="nome" placeholder="Nome do Produto" class="form-control" value="<?php if(isset($_SESSION['nome'])) echo $_SESSION['nome']; ?>" required>
                      </div>

                      <div class="form-group col-xs-4">
                        <label for="materia">Material</label>
                        <input type="text" id="material" name="material" placeholder="Material" class="form-control" value="<?php if(isset($_SESSION['material'])) echo $_SESSION['material']; ?>" required>
                      </div>

                      <div class="form-group col-xs-4">
                        <label for="preco">Preço (R$)</label>
                        <input type="text" id="preco" name="preco" placeholder="Preço" class="form-control" value="<?php if(isset($_SESSION['preco'])) echo $_SESSION['preco']; ?>" required>
                      </div>

                      <div class="form-group col-xs-4">
                        <label for="peso">Peso (KG)</label>
                        <input type="text" id="peso" name="peso" placeholder="Peso" class="form-control" value="<?php if(isset($_SESSION['peso'])) echo $_SESSION['peso']; ?>" required>
                      </div>

                      <div class="form-group col-xs-12">
                        <label for="link">Link do Pay Pal</label>
                        <input type="text" id="link" name="link" placeholder="Link do Pay Pal" class="form-control" value="<?php if(isset($_SESSION['link'])) echo $_SESSION['link']; ?>" required>
                      </div>

                      <div class="form-group form-group-textarea col-xs-12">
                        <label for="imagem_destaque">Imagem de Destaque</label>
                        <input type="file" id="imagem_destaque" name="imagem_destaque" required>
                        <p class="help-block">A imagem deve ter no máximo 500kb!</p>
                      </div>

                      <div class="form-group form-group-textarea col-xs-12">
                        <label for="texto">Descrição</label>
                        <textarea class="form-control textarea" id="texto" name="texto" placeholder="Descrição" required><?php if(isset($_SESSION['texto'])) echo $_SESSION['texto']; ?></textarea>
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
