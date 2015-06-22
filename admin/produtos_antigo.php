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
                  <h3 class="box-title">Produtos</h3>
                  <a href="produtos-add.php" class="btn-add btn btn-app btn-success pull-right"><i class="fa fa-plus"></i> Adicionar</a>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="col-id">ID</th>
                        <th class="col-categoria">Categoria</th>
                        <th class="col-name">Nome</th>
                        <th class="col-descricao">Descricao</th>
                        <th class="col-preco">Preço</th>
                        <th class="col-data">Imagem</th>
                        <th class="col-acoes">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sqlConsultaProdutos     = "SELECT DISTINCT
                                                          produtos.id AS id,
                                                          produtos.nome AS produto,
                                                          produtos.texto AS descricao,
                                                          produtos.preco AS preco,
                                                          produtos.imagem_destaque AS imagem_destaque,
                                                          categorias.nome AS categoria
                                                        FROM
                                                          produtos
                                                        LEFT JOIN
                                                          categorias ON categorias.id = produtos.id_categoria
                                                        ORDER BY
                                                        id ASC";
                        $resultConsultaProdutos  = consulta_db($sqlConsultaProdutos);
                        while($consultaProdutos  = mysql_fetch_object($resultConsultaProdutos)){
                      ?>
                          <tr>
                            <td><?php echo $consultaProdutos->id; ?></td>
                            <td><?php echo $consultaProdutos->categoria; ?></td>
                            <td><?php echo $consultaProdutos->produto; ?></td>
                            <td><?php echo $consultaProdutos->descricao; ?></td>
                            <td>R$<?php echo $consultaProdutos->preco; ?></td>
                            <td>
                              <img src="../uploads/<?php echo $consultaProdutos->imagem_destaque; ?>" width="150" />
                            </td>
                            <td>
                              <a href="produto.php?id=<?php echo $consultaProdutos->id; ?>" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Ver mais</a>
                              <a href="produtos-edit.php?id=<?php echo $consultaProdutos->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                              <a href="produtos-acoes-delete.php?id=<?php echo $consultaProdutos->id; ?>" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-times"></i> Excluir</a>
                            </td>
                          </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="col-id">ID</th>
                        <th class="col-categoria">Categoria</th>
                        <th class="col-name">Nome</th>
                        <th class="col-descricao">Descricao</th>
                        <th class="col-preco">Preço</th>
                        <th class="col-data">Imagem</th>
                        <th class="col-acoes">&nbsp;</th>
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
