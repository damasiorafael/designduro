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
                  <h3 class="box-title">Sobre</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>                        
                        <th class="col-name">Frase</th>
                        <th class="col-name">Texto</th>
                        <th class="col-categoria">Imagem</th>
                        <th class="col-data">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sqlConsultaSobre     = "SELECT * FROM sobre";
                        $resultConsultaSobre  = consulta_db($sqlConsultaSobre);
                        while($consultaSobre  = mysql_fetch_object($resultConsultaSobre)){
                      ?>
                          <tr>
                            <td><?php echo $consultaSobre->frase; ?></td>
                            <td><?php echo $consultaSobre->texto; ?></td>
                            <td>
                              <img src="../uploads/<?php echo $consultaSobre->imagem; ?>" width="150" />
                            </td>
                            <td>                              
                              <a href="sobre-edit.php?id=<?php echo $consultaSobre->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                            </td>
                          </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="col-name">Frase</th>
                        <th class="col-name">Texto</th>
                        <th class="col-categoria">Imagem</th>
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
