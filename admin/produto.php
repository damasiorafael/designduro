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
            Programa
            <small>Kroton Portal Stricto Sensu</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Programa</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <?php
                  $sqlConsultaPrograma     = "SELECT * FROM programas WHERE status = 1 AND id = $id LIMIT 1";
                  $resultConsultaPrograma  = consulta_db($sqlConsultaPrograma);
                  while($consultaPrograma  = mysql_fetch_object($resultConsultaPrograma)){
                ?>
                    <div class="box-header">
                      <h3 class="box-title"><?php echo $consultaPrograma->nome; ?></h3>
                      <a class="btn-add btn btn-app btn-success pull-right" href="programas-add.php"><i class="fa fa-plus"></i> Adicionar Novo</a>
                      <a class="btn-add btn btn-app btn-warning pull-right" href="programas-edit.php?id=<?php echo $consultaPrograma->id; ?>"><i class="fa fa-pencil"></i> Editar</a>
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
                                    <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse" aria-expanded="true" class="">
                                      Informações Gerais
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse in" id="collapseOne" aria-expanded="true" style="">
                                  <div class="box-body">
                                    <dl class="dl-horizontal">
                                      <dt>Nome</dt>
                                      <dd><?php echo $consultaPrograma->nome; ?></dd>
                                      <dt>Área</dt>
                                      <dd>
                                        <?php
                                          $sqlConsultaProgramaArea     = "SELECT * FROM areas WHERE status = 1 AND id = $consultaPrograma->id_area LIMIT 1";
                                          $resultConsultaProgramaArea  = consulta_db($sqlConsultaProgramaArea);
                                          while($consultaProgramaArea  = mysql_fetch_object($resultConsultaProgramaArea)){
                                            echo utf8_encode($consultaProgramaArea->nome);
                                          }
                                        ?>
                                      </dd>
                                      <dt>Instituição</dt>
                                      <dd>
                                        <?php
                                          $sqlConsultaProgramaInst     = "SELECT * FROM instituicoes WHERE status = 1 AND id = $consultaPrograma->id_instituicao LIMIT 1";
                                          $resultConsultaProgramaInst  = consulta_db($sqlConsultaProgramaInst);
                                          while($consultaProgramaInst  = mysql_fetch_object($resultConsultaProgramaInst)){
                                            echo utf8_encode($consultaProgramaInst->nome);
                                          }
                                        ?>
                                      </dd>
                                      <dt>Cidade</dt>
                                      <dd><?php echo utf8_encode($consultaPrograma->cidade); ?></dd>
                                      <dt>Imagem</dt>
                                      <dd>
                                        <img src="https://s3.amazonaws.com/pgsskroton-uploads/<?php echo $consultaPrograma->imagem; ?>" width="150">
                                      </dd>
                                      <dt>Data Final Para Inscrição</dt>
                                      <dd><?php echo $consultaPrograma->data_inscricao; ?></dd>
                                      <dt>Data da Prova</dt>
                                      <dd><?php echo $consultaPrograma->data_prova; ?></dd>
                                      <dt>Hora da Prova</dt>
                                      <dd><?php echo $consultaPrograma->hora_prova; ?></dd>
                                      <dt>Resultado</dt>
                                      <dd><?php echo $consultaPrograma->resultado; ?></dd>
                                      <dt>Mestrado/Doutorado</dt>
                                      <dd>
                                        <div class="content-tags type-tags">
                                          <?php
                                            if($consultaPrograma->fl_mestrado == 1){
                                          ?>
                                              <span class="tag tag-mestrado col-xs-1">MESTRADO</span>
                                          <?php
                                            }
                                            if($consultaPrograma->fl_doutorado == 1){
                                          ?>
                                              <span class="tag tag-doutorado col-xs-1">DOUTORADO</span>
                                          <?php
                                            }
                                          ?> 
                                        </div>
                                      </dd>
                                    </dl>
                                  </div>
                                </div>
                              </div>
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                      Apresentação
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseTwo" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <?php echo $consultaPrograma->apresentacao; ?>
                                  </div>
                                </div>
                              </div>
                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseThree" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                      Área de Concentração
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseThree" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <?php echo utf8_encode($consultaPrograma->area_concentracao); ?>
                                  </div>
                                </div>
                              </div>

                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseFour" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                      Estrutura Curricular
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseFour" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <?php echo utf8_encode($consultaPrograma->estrutura_curricular); ?>
                                  </div>
                                </div>
                              </div>

                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseFive" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                      Corpo Docente
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseFive" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <?php echo utf8_encode($consultaPrograma->corpo_docente); ?>
                                  </div>
                                </div>
                              </div>

                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseSix" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                      Seleção e Matrículas
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseSix" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <?php echo utf8_encode($consultaPrograma->selecao_matriculas); ?>
                                  </div>
                                </div>
                              </div>

                              <div class="panel box box-primary">
                                <div class="box-header with-border">
                                  <h4 class="box-title">
                                    <a href="#collapseSeven" data-parent="#accordion" data-toggle="collapse" class="collapsed" aria-expanded="false">
                                      Contato
                                    </a>
                                  </h4>
                                </div>
                                <div class="panel-collapse collapse" id="collapseSeven" aria-expanded="false" style="height: 0px;">
                                  <div class="box-body">
                                    <?php echo utf8_encode($consultaPrograma->contato); ?>
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
