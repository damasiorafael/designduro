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
            <!-- Main row -->
            <div class="row">
            <!-- left column -->
                <div class="col-xs-4">
                    <!-- general form elements -->
                    <div class="box box-primary box-form col-xs-12">
                        <div class="box-header">
                            <h3 class="box-title">Cadastrar Produto</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form name="produto" id="produto" class="produto" enctype="multipart/form-data" action="produtos-imagens-acoes.php" method="post" novalidate>
                            <div class="form-group col-xs-12">
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

                            <div class="form-group col-xs-12">
                              <label for="nome">Nome</label>
                              <input type="text" id="nome" name="nome" placeholder="Nome do Produto" class="form-control" value="<?php if(isset($_SESSION['nome'])) echo $_SESSION['nome']; ?>" required>
                            </div>

                            <div class="form-group col-xs-12">
                              <label for="materia">Material</label>
                              <input type="text" id="material" name="material" placeholder="Material" class="form-control" value="<?php if(isset($_SESSION['material'])) echo $_SESSION['material']; ?>" required>
                            </div>

                            <div class="form-group col-xs-6">
                              <label for="preco">Preço (R$)</label>
                              <input type="text" id="preco" name="preco" placeholder="Preço" class="form-control" value="<?php if(isset($_SESSION['preco'])) echo $_SESSION['preco']; ?>" required>
                            </div>

                            <div class="form-group col-xs-6">
                              <label for="peso">Peso (KG)</label>
                              <input type="text" id="peso" name="peso" placeholder="Peso" class="form-control" value="<?php if(isset($_SESSION['peso'])) echo $_SESSION['peso']; ?>" required>
                            </div>

                            <div class="form-group col-xs-12">
                              <label for="link">Link do Pay Pal</label>
                              <input type="text" id="link" name="link" placeholder="Link do Pay Pal" class="form-control" value="<?php if(isset($_SESSION['link'])) echo $_SESSION['link']; ?>" required>
                            </div>

                            <div class="form-group form-group-textarea col-xs-12">
                              <label for="img_destaque">A primeira imagem selecionada será a de destaque</label>
                              <input type="file" id="img_destaque" name="img_destaque[]" multiple required>
                              <p class="help-block">A imagem deve ter no máximo 500kb!</p>
                            </div>

                            <div class="form-group form-group-textarea col-xs-8">
                              <label for="video">Embed de vídeo</label>
                              <input type="text" id="video" name="video" placeholder="Embed de vídeo" class="form-control" value="<?php if(isset($_SESSION['video'])) echo $_SESSION['video']; ?>">
                            </div>

                            <div class="form-group col-xs-4">
                              <label for="ordem_video">Ordem do vídeo</label>
                              <input type="text" id="ordem_video" name="ordem_video" placeholder="Ordem do vídeo" class="form-control" value="<?php if(isset($_SESSION['ordem_video'])) echo $_SESSION['ordem_video']; ?>">
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
                    </div><!-- /.box -->
                </div>
                <div class="col-xs-8">
                    <div class="box">
                        <div class="box-header box-header-imagens-produtos">
                            <h3 class="box-title">Produtos</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table id="example2" class="table table-hover">
                                <thead>
                                    <tr>
                                      <th>ID</th>
                                      <th>Nome</th>
                                      <th>Descrição</th>
                                      <th>Imagens</th>
                                      <th class="col-acoes">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                      $sqlConsultaProdutos = "SELECT DISTINCT
                                                                produtos.id AS id,
                                                                produtos.nome AS produto,
                                                                produtos.texto AS descricao,
                                                                produtos.preco AS preco,
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
                                    <tr rel="<?php echo $consultaProdutos->id; ?>">
                                      <td class="td-id-portfolio"><?php echo $consultaProdutos->id; ?></td>
                                        <td class="td-tit-portfolio">
                                          <span class="mostra"><?php echo $consultaProdutos->produto; ?></span>
                                        </td>
                                        <td class="td-tx-portfolio">
                                          <span class="mostra"><?php echo $consultaProdutos->descricao; ?></span>
                                        </td>
                                        <td>
                                          <?php
                                            $sqlConsultaImagens   = "SELECT * FROM produtos_imagens WHERE id_produto = $consultaProdutos->id ORDER by id ASC";
                                            $resultConsultaImagens  = consulta_db($sqlConsultaImagens);
                                            $num_rows_imagens     = mysql_num_rows($resultConsultaImagens);
                                            if($num_rows_imagens > 0){
                                          ?>
                                                <ul class="listImagensPortfolio">
                                            <?php
                                                while($consultaImagens = mysql_fetch_object($resultConsultaImagens)){
                                            ?>
                                                  <li rel="<?php echo $consultaImagens->id; ?>">
                                                            <div id="nova-imagem-<?php echo $consultaImagens->id; ?>">
                                                            <img src="../uploads/<?php echo $consultaImagens->imagem; ?>" width="70" alt="<?php echo $consultaProdutos->produto; ?>" title="<?php echo $consultaProdutos->produto; ?>" rel="<?php echo $consultaImagens->id; ?>" />
                                                            </div>
                                                            <span class="btn-delete-port fa fa-times" alt="Deletar" title="Deletar" rel="<?php echo $consultaImagens->id; ?>"></span>
                                                            <form name="port_teste_<?php echo $consultaImagens->id; ?>" id="port_teste_<?php echo $consultaImagens->id; ?>" class="port_teste" enctype="multipart/form-data" action="produtos-imagens-acoes.php" method="post" novalidate>
                                                                <input type="hidden" name="acao" value="edit_image" />
                                                                <input type="hidden" name="id_imagem" value="<?php echo $consultaImagens->id; ?>" />
                                                                <input type="file" id="img_teste_<?php echo $consultaImagens->id; ?>" name="img_teste_<?php echo $consultaImagens->id; ?>" class="img_teste esconde" alt="<?php echo $consultaImagens->id; ?>" />
                                                            </form>
                                                        </li>
                                              <?php
                                                }
                                              ?>
                                                </ul>
                                                <span class="inc-mais-imagem btn btn-success btn-xs" rel="<?php echo $consultaProdutos->id; ?>"><i class="fa fa-plus"></i> Imagem</span>
                                                <span class="btn-pronto-imagem btn btn-success btn-xs esconde" rel="<?php echo $consultaProdutos->id; ?>"><i class="fa fa-check"></i> Pronto</span>
                                            <?php 
                                              } else {
                                            ?>
                                                  <ul class="listImagensPortfolio"></ul>
                                                  <span class="inc-mais-imagem btn btn-success btn-xs" rel="<?php echo $consultaProdutos->id; ?>"><i class="fa fa-plus"></i> Imagem</span>
                                                  <span class="btn-pronto-imagem btn btn-success btn-xs esconde" rel="<?php echo $consultaProdutos->id; ?>"><i class="fa fa-check"></i> Pronto</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                          <a href="produto.php?id=<?php echo $consultaProdutos->id; ?>" class="btn btn-info btn-xs"><i class="fa fa-plus"></i> Ver mais</a>
                                          <a href="produtos-edit.php?id=<?php echo $consultaProdutos->id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                          <a href="produtos-acoes-delete.php?id=<?php echo $consultaProdutos->id; ?>" class="btn-delete btn btn-danger btn-xs"><i class="fa fa-times"></i> Excluir</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <?php
              if($num_rows > 1){
            ?>
                                <tfoot>
                                    <tr>
                                      <th>ID</th>
                                      <th>Título</th>
                                      <th>Descrição</th>
                                      <th>Imagens</th>
                                      <th class="col-acoes">&nbsp;</th>
                                    </tr>
                                </tfoot>
                                <?php } ?>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div><!-- /.row (main row) -->

        </section><!-- /.content -->

        
      </div><!-- /.content-wrapper -->
      <?php include("inc/footer.php"); ?>

    </div><!-- ./wrapper -->

    <?php include("inc/footer-scripts.php"); ?>

    <!-- DATA TABES SCRIPT -->
    <script src="plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

    <script src="dist/js/jquery.validate.min.js" type="text/javascript"></script>

    <script src="dist/js/jquery.form.js" type="text/javascript"></script>
    
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
        
        $(".img_teste").on("change", function(){
          var $this = $(this);
          var relThis = $this.attr("alt");
          //$this.parent().parent().parent().parent().parent().find(".btn-canc-port").attr("style", "display: none!important");
          $("#port_teste_"+relThis).ajaxForm({
            target: '#nova-imagem-'+relThis // o callback será no elemento com o id #visualizar
          }).submit();
        });
        
        $(".btn-delete-port").on("click", function(){
          var conf = confirm("Tem certeza que deseja excluir esta imagem?");
          if (conf == true) {
            var $this = $(this);
            var relThis = $this.attr("rel");
            //$this.parent().parent().parent().parent().parent().find(".btn-canc-port").attr("style", "display: none!important");
            $.ajax({
              type: "POST",
              url: "produtos-imagens-acoes.php",
              data: "acao=deleta_imagem&id_imagem="+relThis,
              success: function(dados){
                if(dados == "sucesso"){
                  alert("Imagem excluída com sucesso!");
                  $(".listImagensPortfolio li[rel='"+relThis+"']").remove();
                } else {
                  alert(dados);
                }
              }
            });
          } else {
            return false;
          }
        });
        var numNovasImagens = 0;
        $(".inc-mais-imagem").on("click", function(){
          var $this = $(this);
          var relThis = $this.attr("rel");
          trPrint = $("tr[rel="+relThis+"]");
          trPrint.find(".btn-pronto-imagem").removeClass("esconde");
          var idPortNovaImagem = $this.parent().parent().attr("rel");
          $this.addClass("esconde");
          $("tr:not([rel="+relThis+"])").find(".liNovaImagem").remove();
          numNovasImagens = 0;
          $this.parent().find(".listImagensPortfolio").each(function(){
            var $this = $(this);
            var liNova = $this.find("li");
            if(liNova.hasClass("liNovaImagem")){
              numNovasImagens++;
            }
          });
          var formNovaImagem = "<li class='liNovaImagem novaImagem_"+numNovasImagens+"'>";
          formNovaImagem += "<div class='nova-imagem-edit' id='nova-imagem-added_"+numNovasImagens+"'></div>";
          formNovaImagem += "<form class='add-img-portfolio_"+numNovasImagens+"' action='produtos-imagens-acoes.php' enctype='multipart/form-data' method='post' novalidate>";
          //?acao=add_nova_image&id_controle="+numNovasImagens+"&id_portfolio="+idPortNovaImagem+"
          formNovaImagem += "<input type='hidden' name='acao' value='add_nova_image' />";
          formNovaImagem += "<input type='hidden' name='id_controle' value='"+numNovasImagens+"' />";
          formNovaImagem += "<input type='hidden' name='id' value='"+idPortNovaImagem+"' />";
          formNovaImagem += "<input type='file' id='add_nova_image_"+numNovasImagens+"' name='add_nova_image_"+numNovasImagens+"' class='add_nova_image' />";
          formNovaImagem += "</form></li>";
          $this.parent().find(".listImagensPortfolio").append(formNovaImagem);
          $("#add_nova_image_"+numNovasImagens).on("change", function(){
            var $this = $(this);
            var relThis = $this.attr("rel");
            //$this.parent().parent().parent().parent().parent().find(".btn-canc-port").attr("style", "display: none!important");
            $(".add-img-portfolio_"+numNovasImagens).ajaxForm({
              target: '#nova-imagem-added_'+numNovasImagens // o callback será no elemento com o id #visualizar
            }).submit();
          });
        });

        $(".btn-pronto-imagem").on("click", function(){
          window.location=window.location;
        });
        
        //VALIDACAO E ENVIO DO FORMULÁRIO
        $("#produto").validate({
          elementError: "span",
          rules: {
            id_categoria: "required",
            nome: "required",
            material: "required",
            preco: "required",
            peso: "required",
            link: "required",
            texto: "required",
            "img_destaque[]": "required"
          },
          messages: {
            id_categoria: "Selecione um item!",
            nome: "Por favor preencha o campo corretamente!",
            material: "Por favor preencha o campo corretamente!",
            preco: "Por favor preencha o campo corretamente!",
            peso: "Por favor preencha o campo corretamente!",
            link: "Por favor preencha o campo corretamente!",
            texto: "Por favor preencha o campo corretamente!",
            "img_destaque[]": "Por favor preencha o campo corretamente!"
          },
          submitHandler: function(form){
            //var fileInput = document.getElementById("img_destaque").files;
            //console.log(fileInput.length);
            //return false;
            $('#produto').ajaxForm({
              //target:'#visualizar' // o callback será no elemento com o id #visualizar
            }).submit();
            return false;
          }
        });



      });
    </script>

  </body>
</html>
