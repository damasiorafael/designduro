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
            Slides
            <small>Design Duro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Slides</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Slides</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="col-id">ID</th>
                        <th class="col-data">Título</th>
                        <th class="col-categoria">Texto</th>
                        <th class="col-name">Imagem</th>
                        <th class="col-data">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sqlConsultaSlides     = "SELECT * FROM slides ORDER BY id ASC";
                        $resultConsultaSlides  = consulta_db($sqlConsultaSlides);
                        while($consultaSlides  = mysql_fetch_object($resultConsultaSlides)){
                      ?>
                          <tr>
                            <td><?php echo $consultaSlides->id; ?></td>
                            <td><?php echo $consultaSlides->titulo; ?></td>
                            <td><?php echo $consultaSlides->texto; ?></td>
                            <td>
                              <img src="../uploads/<?php echo $consultaSlides->imagem; ?>" width="150" />
                            </td>
                            <td>                              
                              <a href="slides-edit.php?id=<?php echo $consultaSlides->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                            </td>
                          </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="col-id">ID</th>
                        <th class="col-data">Título</th>
                        <th class="col-categoria">Texto</th>
                        <th class="col-name">Imagem</th>
                        <th class="col-data">&nbsp;</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <?php include("inc/footer.php"); ?>

    </div><!-- ./wrapper -->

    <?php include("inc/footer-scripts.php"); ?>

    <!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
        
        $(".btn-delete").on("click", function(){
            var conf = confirm("Tem certeza que deseja excluir este registro?");
            if(conf){
                return true;
            } else {
                return false;
            }
        });

        $('#example2').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false
        });
      });
    </script>

  </body>
</html>
