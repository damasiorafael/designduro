<header class="main-header">
        <!-- Logo -->
        <a href="index.php" class="logo logo-topo">
          <img src="img/mini_logo_topo.png" />
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <?php
                  $sqlUser              = "SELECT * FROM users WHERE username = '".$_SESSION['username']."';";
                  $resultConsultaUser   = consulta_db($sqlUser);
                  $consultaUser         = mysql_fetch_object($resultConsultaUser);
                ?>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <?php
                      if ($consultaUser->imagem != "") {
                    ?>
                      <img src="https://s3.amazonaws.com/pgsskroton-uploads/<?php echo $consultaUser->imagem; ?>" class="user-image" alt="User Image" />
                  <?php
                      } else {
                  ?>
                      <img src="dist/img/avatar04.png" class="user-image" alt="User Image"/>
                  <?php } ?>
                  <span class="hidden-xs"><?php echo $consultaUser->nome; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <?php
                      if ($consultaUser->imagem != "") {
                    ?>
                        <img src="https://s3.amazonaws.com/pgsskroton-uploads/<?php echo $consultaUser->imagem; ?>" class="img-circle" alt="User Image" />
                    <?php
                        } else {
                    ?>
                        <img src="dist/img/avatar04.png" class="img-circle" alt="User Image"/>
                    <?php } ?>
                    <p>
                      <?php echo $consultaUser->nome; ?>
                      <small><?php echo $_SESSION['nivel_acesso']; ?></small>
                      <small>Último login - <?php echo formata_data($consultaUser->data_ultimo_login); ?></small>
                    </p>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left display-none">
                      <a href="#" class="btn btn-default btn-flat">Perfil</a>
                    </div>
                    <div class="pull-right">
                      <a href="logout.php" class="btn btn-default btn-flat">Sair</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>