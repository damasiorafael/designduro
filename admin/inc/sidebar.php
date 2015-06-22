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
            <li>
              <a href="produtos.php">
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
            </li>
            <li>
              <a href="slides.php">
                <i class="fa fa-laptop"></i>
                <span>Slides</span>
                <span class="label label-primary pull-right">
                  <?php
                    $sqlConsultaSlidesMenu     = "SELECT id FROM slides";
                    $resultConsultaSlidesMenu  = consulta_db($sqlConsultaSlidesMenu);
                    $numRowsSlidesMenu         = mysql_num_rows($resultConsultaSlidesMenu);
                    if($numRowsSlidesMenu > 0){
                      echo $numRowsSlidesMenu;
                    } else {
                      echo "0";
                    }
                  ?>
                </span>
              </a>
            </li>
            <li>
              <a href="citacao.php">
                <i class="fa fa-comment"></i>
                <span>Citação</span>
                <span class="label label-primary pull-right">1</span>
              </a>
            </li>

            <li>
              <a href="sobre.php">
                <i class="fa fa-group"></i>
                <span>Sobre</span>
                <span class="label label-primary pull-right">1</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>