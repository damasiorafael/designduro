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
            Programas
            <small>Kroton Portal Stricto Sensu</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Programas</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Editar Programa</h3>
                </div><!-- /.box-header -->
                <?php
                  $sqlConsultaPrograma     = "SELECT * FROM programas WHERE status = 1 AND id = $id LIMIT 1";
                  $resultConsultaPrograma  = consulta_db($sqlConsultaPrograma);
                  while($consultaPrograma  = mysql_fetch_object($resultConsultaPrograma)){
                ?>
                    <div class="box-body">
                      <div class="row">
                        <form action="programas-acoes-edit.php" enctype="multipart/form-data" id="programas-add" class="programas-add" method="post" validate>
                          <input type="hidden" id="id" name="id" value="<?php echo $consultaPrograma->id; ?>" class="display-none">
                          <div class="form-group col-xs-4">
                            <label for="nome">Nome</label>
                            <input type="text" id="nome" name="nome" placeholder="Nome" class="form-control" value="<?php echo $consultaPrograma->nome; ?>" required>
                          </div>

                          <div class="form-group col-xs-4">
                            <label for="area">Área</label>
                            <select id="area" name="area" class="form-control" required>
                              <option value="">-- Selecione --</option>
                              <?php
                                $sqlConsultaAreas   = "SELECT * FROM areas WHERE status = 1";
                                $resultConsultaAreas  = consulta_db($sqlConsultaAreas);
                                while($consultaAreas  = mysql_fetch_object($resultConsultaAreas)){
                              ?>
                                  <option value="<?php echo $consultaAreas->id; ?>" <?php if($consultaPrograma->id_area == $consultaAreas->id) echo "selected"; ?>><?php echo utf8_encode($consultaAreas->nome); ?></option>
                              <?php
                                }
                              ?>
                            </select>
                          </div>

                          <div class="form-group col-xs-4">
                            <label for="instituicao">Instituição</label>
                            <select id="instituicao" name="instituicao" class="form-control" required>
                              <option value="">-- Selecione --</option>
                              <?php
                                $sqlConsultaInst   = "SELECT * FROM instituicoes WHERE status = 1";
                                $resultConsultaInst  = consulta_db($sqlConsultaInst);
                                while($consultaInst  = mysql_fetch_object($resultConsultaInst)){
                              ?>
                                  <option value="<?php echo $consultaInst->id; ?>" <?php if($consultaPrograma->id_instituicao == $consultaInst->id) echo "selected"; ?>><?php echo utf8_encode($consultaInst->nome); ?></option>
                              <?php
                                }
                              ?>
                            </select>
                          </div>

                          <div class="form-group col-xs-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="cidade" name="cidade" placeholder="Cidade" class="form-control" value="<?php echo $consultaPrograma->cidade; ?>" required>
                            <p class="help-block">EX: Londrina - PR</p>
                          </div>

                          <div class="form-group col-xs-1">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control" required>
                              <option value=""> -- UF -- </option> 
                              <option value="ac" <?php if ($consultaPrograma->estado == "ac"){ ?> selected <?php } ?>>AC</option>
                              <option value="al" <?php if ($consultaPrograma->estado == "al"){ ?> selected <?php } ?>>AL</option>
                              <option value="am" <?php if ($consultaPrograma->estado == "am"){ ?> selected <?php } ?>>AM</option>
                              <option value="ap" <?php if ($consultaPrograma->estado == "ap"){ ?> selected <?php } ?>>AP</option>
                              <option value="ba" <?php if ($consultaPrograma->estado == "ba"){ ?> selected <?php } ?>>BA</option>
                              <option value="ce" <?php if ($consultaPrograma->estado == "ce"){ ?> selected <?php } ?>>CE</option>
                              <option value="df" <?php if ($consultaPrograma->estado == "df"){ ?> selected <?php } ?>>DF</option>
                              <option value="es" <?php if ($consultaPrograma->estado == "es"){ ?> selected <?php } ?>>ES</option>
                              <option value="go" <?php if ($consultaPrograma->estado == "go"){ ?> selected <?php } ?>>GO</option>
                              <option value="ma" <?php if ($consultaPrograma->estado == "ma"){ ?> selected <?php } ?>>MA</option>
                              <option value="mt" <?php if ($consultaPrograma->estado == "mt"){ ?> selected <?php } ?>>MT</option>
                              <option value="ms" <?php if ($consultaPrograma->estado == "ms"){ ?> selected <?php } ?>>MS</option>
                              <option value="mg" <?php if ($consultaPrograma->estado == "mg"){ ?> selected <?php } ?>>MG</option>
                              <option value="pa" <?php if ($consultaPrograma->estado == "pa"){ ?> selected <?php } ?>>PA</option>
                              <option value="pb" <?php if ($consultaPrograma->estado == "pb"){ ?> selected <?php } ?>>PB</option>
                              <option value="pr" <?php if ($consultaPrograma->estado == "pr"){ ?> selected <?php } ?>>PR</option>
                              <option value="pe" <?php if ($consultaPrograma->estado == "pe"){ ?> selected <?php } ?>>PE</option>
                              <option value="pi" <?php if ($consultaPrograma->estado == "pi"){ ?> selected <?php } ?>>PI</option>
                              <option value="rj" <?php if ($consultaPrograma->estado == "rj"){ ?> selected <?php } ?>>RJ</option>
                              <option value="rn" <?php if ($consultaPrograma->estado == "rn"){ ?> selected <?php } ?>>RN</option>
                              <option value="ro" <?php if ($consultaPrograma->estado == "ro"){ ?> selected <?php } ?>>RO</option>
                              <option value="rs" <?php if ($consultaPrograma->estado == "rs"){ ?> selected <?php } ?>>RS</option>
                              <option value="rr" <?php if ($consultaPrograma->estado == "rr"){ ?> selected <?php } ?>>RR</option>
                              <option value="sc" <?php if ($consultaPrograma->estado == "sc"){ ?> selected <?php } ?>>SC</option>
                              <option value="se" <?php if ($consultaPrograma->estado == "se"){ ?> selected <?php } ?>>SE</option>
                              <option value="sp" <?php if ($consultaPrograma->estado == "sp"){ ?> selected <?php } ?>>SP</option>
                              <option value="to" <?php if ($consultaPrograma->estado == "to"){ ?> selected <?php } ?>>TO</option>
                            </select>
                          </div>

                          <div class="form-group col-xs-4">
                            <label for="imagem">Imagem</label>
                            <input type="file" id="imagem" name="imagem">
                            <img src="https://s3.amazonaws.com/pgsskroton-uploads/<?php echo $consultaPrograma->imagem; ?>" width="60" class="img-pag-edit-prog pull-left">
                            <p class="help-block">Alterar imagem - A imagem deve ter no máximo 500kb e as dimensões de 281 x 184 pixels</p>
                          </div>

                          <div class="form-group col-xs-4">
                            <label for="data_inscricao">Data Final Para Inscrição</label>
                            <input type="text" id="data_inscricao" name="data_inscricao" class="form-control datepicker" value="<?php echo $consultaPrograma->data_inscricao; ?>">
                          </div>

                          <div class="form-group col-xs-4">
                            <label for="data_prova">Data da Prova</label>
                            <input type="text" id="data_prova" name="data_prova" class="form-control datepicker" value="<?php echo $consultaPrograma->data_prova; ?>">
                          </div>

                          <!-- time Picker -->
                          <div class="bootstrap-timepicker col-xs-2">
                            <div class="form-group">
                              <label for="hora_prova_inicial">Hora da Prova</label>
                              <div class="input-group">
                                <input type="text" id="hora_prova_inicial" name="hora_prova_inicial" class="form-control timepicker" value="<?php echo separaHora($consultaPrograma->hora_prova, 0); ?>">
                              </div><!-- /.input group -->
                            </div><!-- /.form group -->
                          </div>

                          <!-- time Picker -->
                          <div class="bootstrap-timepicker col-xs-2">
                            <div class="form-group">
                              <div class="input-group">
                                <input type="text" id="hora_prova_final" name="hora_prova_final" class="form-control timepicker2" value="<?php echo separaHora($consultaPrograma->hora_prova, 1); ?>">
                              </div><!-- /.input group -->
                            </div><!-- /.form group -->
                          </div>

                          <div class="form-group col-xs-4">
                            <button class="btn btn-lg btn-success pull-right" type="submit">
                              <i class="fa fa-check"></i>Salvar
                            </button>
                          </div>

                          <div class="form-group col-xs-4">
                            <label for="resultado">Resultado</label>
                            <input type="text" id="resultado" name="resultado" class="form-control datepicker" value="<?php echo $consultaPrograma->resultado; ?>">
                          </div>

                          <div class="form-group col-xs-4">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="mestrado" value="1" <?php if($consultaPrograma->fl_mestrado == 1) echo "checked"; ?>>
                                Mestrado
                              </label>
                            </div>

                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="doutorado" value="1" <?php if($consultaPrograma->fl_doutorado == 1) echo "checked"; ?>>
                                Doutorado
                              </label>
                            </div>
                          </div>

                          <div class="form-group form-group-textarea col-xs-12">
                            <label for="apresentacao">Apresentação</label>
                            <textarea class="form-control textarea" id="apresentacao" name="apresentacao" placeholder="Apresentação"><?php echo utf8_encode($consultaPrograma->apresentacao); ?></textarea>
                          </div>

                          <div class="form-group form-group-textarea col-xs-12">
                            <label for="area_concentracao">Área de Concentração</label>
                            <textarea class="form-control textarea" id="area_concentracao" name="area_concentracao" placeholder="Área de Concentração"><?php echo utf8_encode($consultaPrograma->area_concentracao); ?></textarea>
                          </div>

                          <div class="form-group form-group-textarea col-xs-6">
                            <label for="estrutura_curricular">Estrutura Curricular</label>
                            <textarea class="form-control textarea" id="estrutura_curricular" name="estrutura_curricular" placeholder="Estrutura Curricular"><?php echo utf8_encode($consultaPrograma->estrutura_curricular); ?></textarea>
                          </div>

                          <div class="form-group form-group-textarea col-xs-6">
                            <label for="corpo_docente">Corpo Docente</label>
                            <textarea class="form-control textarea" id="corpo_docente" name="corpo_docente" placeholder="Corpo Docente"><?php echo utf8_encode($consultaPrograma->corpo_docente); ?></textarea>
                          </div>

                          <div class="form-group form-group-textarea col-xs-6">
                            <label for="selecao_matriculas">Seleção e Matrículas</label>
                            <textarea class="form-control textarea" id="selecao_matriculas" name="selecao_matriculas" placeholder="Seleção e Matrículas"><?php echo utf8_encode($consultaPrograma->selecao_matriculas); ?></textarea>
                          </div>

                          <div class="form-group form-group-textarea col-xs-6">
                            <label for="contato">Contato</label>
                            <textarea class="form-control textarea" id="contato" name="contato" placeholder="Contato"><?php echo utf8_encode($consultaPrograma->contato); ?></textarea>
                          </div>

                          <div class="form-group form-group-textarea col-xs-12">
                            <button type="submit" class="btn btn-lg btn-success pull-right">
                              <i class="fa fa-check"></i>Salvar
                            </button>
                          </div>
                        </form>
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

    <!-- CK Editor -->
    <script src="plugins/ckeditor/ckeditor.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(function () {
        //Timepicker
        $(".timepicker, .timepicker2").timepicker({
          minuteStep: 10,
          showInputs: false,
          showMeridian: false,
        });

        //Datepicker
        $('.datepicker').datepicker({
          autoclose: true,
          startDate: '-3d',
          todayHighlight: true,
          format: 'dd/mm/yyyy',
          language: 'pt-BR'
        });

        CKEDITOR.replace('apresentacao');
        CKEDITOR.replace('area_concentracao');
        CKEDITOR.replace('estrutura_curricular');
        CKEDITOR.replace('corpo_docente');
        CKEDITOR.replace('selecao_matriculas');
        CKEDITOR.replace('contato');

      });
    </script>

  </body>
</html>
