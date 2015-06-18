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
                        <th class="col-name">Descricao</th>
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
                                                          categorias.nome AS categoria
                                                        FROM
                                                          produtos
                                                        LEFT JOIN
                                                          categorias ON categorias.id = produtos.id_categoria
                                                        LEFT JOIN
                                                          produtos_imagens ON produtos_imagens.id_produto = produtos.id
                                                        ORDER BY
                                                        id ASC";
                        $resultConsultaProdutos  = consulta_db($sqlConsultaProdutos);
                        while($consultaProdutos  = mysql_fetch_object($resultConsultaProdutos)){
                      ?>
                          <tr>
                            <td><?php echo $consultaProdutos->id; ?></td>
                            <td><?php echo $consultaProdutos->nome; ?></td>
                            <td>
                              <?php
                                $sqlConsultaInstituicao     = "SELECT * FROM instituicoes WHERE status = 1 AND id = $consultaProgramas->id_instituicao LIMIT 1";
                                $resultConsultaInstituicao  = consulta_db($sqlConsultaInstituicao);
                                while($consultaInstituicao  = mysql_fetch_object($resultConsultaInstituicao)){
                                  echo $consultaInstituicao->nome;
                                }
                              ?>
                              /<?php echo $consultaProgramas->cidade; ?> - <?php echo strtoupper($consultaProgramas->estado); ?></td>
                            <td>
                              <div class="content-tags type-tags col-md-12">
                                <?php
                                  if($consultaProgramas->fl_mestrado == 1){
                                ?>
                                    <span class="tag tag-mestrado col-md-12">MESTRADO</span>
                                <?php
                                  }
                                ?>
                                <?php
                                  if($consultaProgramas->fl_doutorado == 1){
                                ?>
                                    <span class="tag tag-doutorado col-md-12">DOUTORADO</span>
                                <?php
                                  }
                                ?>
                              </div>
                            </td>
                            <td>
                              <?php echo formata_data($consultaProgramas->data); ?>
                            </td>
                            <td>
                              <?php
                                if($consultaProgramas->status == 1){
                              ?>
                                  <a href="programas-acoes-status.php?id=<?php echo $consultaProgramas->id; ?>&status=<?php echo $consultaProgramas->status; ?>" class="btn btn-block btn-success btn-xs btn-status">ATIVO</a>
                              <?php
                                } else {
                              ?>
                                  <a href="programas-acoes-status.php?id=<?php echo $consultaProgramas->id; ?>&status=<?php echo $consultaProgramas->status; ?>" class="btn btn-block btn-danger btn-xs btn-status">INATIVO</a>
                              <?php
                                }
                              ?>
                            </td>
                            <td>
                              <a href="programa.php?id=<?php echo $consultaProgramas->id; ?>" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Ver mais</a>
                              <?php 
                                if($_SESSION['nivel_acesso'] == "SUPER ADMIN" || $_SESSION['nivel_acesso'] == "ADMIN" || $_SESSION['nivel_acesso'] == "PUBLISHER"){
                              ?>
                                  <a href="programas-edit.php?id=<?php echo $consultaProgramas->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                              <?php
                                }
                                if($_SESSION['nivel_acesso'] == "SUPER ADMIN" || $_SESSION['nivel_acesso'] == "ADMIN"){
                              ?>
                                  <a href="programas-acoes-delete.php?id=<?php echo $consultaProgramas->id; ?>" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-times"></i> Excluir</a>
                              <?php } ?>
                            </td>
                          </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="col-id">ID</th>
                        <th class="col-name">Nome</th>
                        <th class="col-instituicao">Material</th>
                        <th class="col-tipo">Peso</th>
                        <th class="col-data">Texto</th>
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

        $(".btn-status").on("click", function(e){
            <?php 
              if($_SESSION['nivel_acesso'] == "VIEWER"){
            ?>
                e.stopPropagation();
                e.preventDefault();
                return false;
            <?php } ?>
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
