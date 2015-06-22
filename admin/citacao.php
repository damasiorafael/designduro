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
            Citação
            <small>Design Duro</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Citação</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Citação</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="col-name">Texto</th>
                        <th class="col-data">Autor</th>
                        <th class="col-data">Status</th>
                        <th class="col-data">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sqlConsultaCitacao     = "SELECT * FROM citacao ORDER BY id ASC";
                        $resultConsultaCitacao  = consulta_db($sqlConsultaCitacao);
                        while($consultaCitacao  = mysql_fetch_object($resultConsultaCitacao)){
                      ?>
                          <tr>
                            <td><?php echo $consultaCitacao->texto; ?></td>
                            <td><?php echo $consultaCitacao->autor; ?></td>
                            <td>
                              <?php
                                if($consultaCitacao->status == 1){
                              ?>
                                  <a href="citacao-acoes-status.php?id=<?php echo $consultaCitacao->id; ?>&status=<?php echo $consultaCitacao->status; ?>" class="btn btn-block btn-success btn-xs btn-status">ATIVO</a>
                              <?php
                                } else {
                              ?>
                                  <a href="citacao-acoes-status.php?id=<?php echo $consultaCitacao->id; ?>&status=<?php echo $consultaCitacao->status; ?>" class="btn btn-block btn-danger btn-xs btn-status">INATIVO</a>
                              <?php
                                }
                              ?>
                            </td>
                            <td>                              
                              <a href="citacao-edit.php?id=<?php echo $consultaCitacao->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                            </td>
                          </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="col-name">Texto</th>
                        <th class="col-categoria">Autor</th>
                        <th class="col-data">Status</th>
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

        $(".btn-status").on("click", function(e){
            var conf = confirm("Tem certeza que deseja alterar este registro?");
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
