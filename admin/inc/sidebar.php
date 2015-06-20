<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <?php
          /*
          ESCONDENDO FORMULARIO DE BUSCA DO LADO ESQUERDO
          
          //<form action="#" method="get" class="sidebar-form">
          //  <div class="input-group">
          //   <input type="text" name="q" class="form-control" placeholder="Search..."/>
          //    <span class="input-group-btn">
          //      <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
          //    </span>
          //  </div>
          // </form>
          
          */
          ?>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">NAVEGAÇÃO PRINCIPAL</li>
            <li>
              <a href="categorias.php">
                <i class="fa fa-book"></i>
                <span>Categorias</span>
                <span class="label label-primary pull-right">3</span>
              </a>
            </li>
            <li class="treeview">
              <a href="">
                <i class="fa fa-th"></i>
                <span>Produtos</span>
                <span class="label label-primary pull-right">
                  <?php
                    $sqlConsultaProdutosMenu     = "SELECT id FROM produtos";
                    $resultConsultaProdutosMenu  = consulta_db($sqlConsultaProdutosMenu);
                    $numRowsBannersProdutosMenu  = mysql_num_rows($resultConsultaProdutosMenu);
                    if($numRowsBannersProdutosMenu > 0){
                      echo $numRowsBannersProdutosMenu;
                    } else {
                      echo "0";
                    }
                  ?>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="produtos.php"><i class="fa fa-circle-o"></i> Produtos</a></li>
                <li><a href="produtos-imagens.php"><i class="fa fa-circle-o"></i> Imagens de Produtos</a></li>
              </ul>
            </li>
            <li>
              <a href="noticias.php">
                <i class="fa fa-laptop"></i>
                <span>Notícias</span>
                <span class="label label-primary pull-right">
                  <?php
                    $sqlConsultaNoticiasMenu     = "SELECT id FROM noticias WHERE status = 1";
                    $resultConsultaNoticiasMenu  = consulta_db($sqlConsultaNoticiasMenu);
                    $numRowsNoticiasMenu         = mysql_num_rows($resultConsultaNoticiasMenu);
                    if($numRowsNoticiasMenu > 0){
                      echo $numRowsNoticiasMenu;
                    } else {
                      echo "0";
                    }
                  ?>
                </span>
              </a>
            </li>
            <li>
              <a href="teses.php">
                <i class="fa fa-bookmark"></i>
                <span>Teses</span>
                <span class="label label-primary pull-right">
                  <?php
                    if($idInstMenu != ""){
                      $sqlConsultaTesesMenu     = "SELECT `programas_teses`.id FROM programas_teses LEFT JOIN `programas` ON `programas`.id = `programas_teses`.id WHERE `programas`.id_instituicao = $idInstMenu";
                    } else {
                      $sqlConsultaTesesMenu     = "SELECT id FROM programas_teses";
                    }
                    $resultConsultaTesesMenu  = consulta_db($sqlConsultaTesesMenu);
                    $numRowsTesesMenu         = mysql_num_rows($resultConsultaTesesMenu);
                    if($numRowsTesesMenu > 0){
                      echo $numRowsTesesMenu;
                    } else {
                      echo "0";
                    }
                  ?>
                </span>
              </a>
            </li>

            <li>
              <a href="dissertacoes.php">
                <i class="fa fa-bookmark"></i>
                <span>Dissertações</span>
                <span class="label label-primary pull-right">
                  <?php
                    if($idInstMenu != ""){
                      $sqlConsultaDissertacoesMenu     = "SELECT `programas_dissertacoes`.id FROM programas_dissertacoes LEFT JOIN `programas` ON `programas`.id = `programas_dissertacoes`.id WHERE `programas`.id_instituicao = $idInstMenu";
                    } else {
                      $sqlConsultaDissertacoesMenu     = "SELECT id FROM programas_dissertacoes";
                    }
                    $resultConsultaDissertacoesMenu  = consulta_db($sqlConsultaDissertacoesMenu);
                    $numRowsDissertacoesMenu         = mysql_num_rows($resultConsultaDissertacoesMenu);
                    if($numRowsDissertacoesMenu > 0){
                      echo $numRowsDissertacoesMenu;
                    } else {
                      echo "0";
                    }
                  ?>
                </span>
              </a>
            </li>

            <li>
              <a href="arquivos.php">
                <i class="fa fa-files-o"></i>
                <span>Documentos</span>
                <span class="label label-primary pull-right">
                  <?php
                    if($idInstMenu != ""){
                      $idInstMenu;
                      $sqlConsultaArquivosMenu     = "SELECT DISTINCT `programas_arquivos`.id FROM programas_arquivos LEFT JOIN `programas` ON `programas`.id = `programas_arquivos`.id WHERE `programas`.id_instituicao = $idInstMenu";
                    } else {
                      $sqlConsultaArquivosMenu     = "SELECT id FROM programas_arquivos";
                    }
                    $resultConsultaArquivosMenu  = consulta_db($sqlConsultaArquivosMenu);
                    $numRowsArquivosMenu         = mysql_num_rows($resultConsultaArquivosMenu);
                    if($numRowsArquivosMenu > 0){
                      echo $numRowsArquivosMenu;
                    } else {
                      echo "0";
                    }
                  ?>
                </span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>