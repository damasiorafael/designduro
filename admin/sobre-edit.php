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
            Sobre
            <small>Design Duro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Sobre</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Editar Sobre</h3>
                </div><!-- /.box-header -->
                <?php
                  $sqlConsultaSobre     = "SELECT * FROM sobre WHERE id = $id";
                  $resultConsultaSobre  = consulta_db($sqlConsultaSobre);
                  $consultaSobre = mysql_fetch_object($resultConsultaSobre);
                ?>
                  <div class="box-body">
                    <div class="row">
                      <form action="sobre-acoes-edit.php" enctype="multipart/form-data" id="programas-add" class="programas-add" method="post" validate>
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>" class="display-none">

                        <div class="form-group col-xs-12">
                          <label for="frase">Frase</label>
                          <input type="text" id="frase" name="frase" placeholder="Frase" class="form-control" value="<?php echo $consultaSobre->frase; ?>" require>
                        </div>

                        <div class="form-group col-xs-12">
                          <label for="texto">Texto</label>
                          <input type="text" id="texto" name="texto" placeholder="Texto" class="form-control" value="<?php echo $consultaSobre->texto; ?>">
                        </div>

                        <div class="form-group form-group-textarea col-xs-4">
                          <label for="imagem">Imagem</label>
                          <input type="file" id="imagem" name="imagem">
                          <img src="../uploads/<?php echo $consultaSobre->imagem; ?>" width="200" />
                          <p class="help-block">A imagem deve ter no máximo 500kb!</p>
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

    <!-- Bootstrap Color Picker -->
    <link href="plugins/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>

    <!-- bootstrap color picker -->
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(function () {
        //Colorpicker
        $(".colorpicker-banner").colorpicker({
          format: 'hex',
          color: '<?php echo $cor; ?>'
        });
      });
    </script>

  </body>
</html>
