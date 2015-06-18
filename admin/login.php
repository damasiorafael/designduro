<?php
  include_once("inc/config.php");
  if((isset($_SESSION['username']) == true) and (isset($_SESSION['senha']) == true)) header('Location: index.php');//CRIAR REDIRECIONAMENTO PRA INDEX
  if((isset($_POST['username']) == true) and (isset($_POST['senha']) == true)){
    $username   = protecao($_POST['username']);
    $senha      = protecao($_POST['senha']);
    
    $msgErroUser      = "Usuário não encontrado!";
    $msgErroSenha     = "Senha incorreta!";
    $msgErroSenhaCaractere  = "Sua senha não deve conter caracteres como: ' # = -- - ; *";
    
    $sqlUser      = "SELECT id, username, data_ultimo_login FROM users WHERE username = '$username' AND status = '1'";
    $resultConsultaUser = consulta_db($sqlUser);
    $numRowsUser    = mysql_num_rows($resultConsultaUser);
    $consultaUser   = mysql_fetch_object($resultConsultaUser);
    if($numRowsUser > 0){
      $_SESSION['username']   = $consultaUser->username;
      $sqlSenha         = "SELECT senha, data_ultimo_login FROM users WHERE username = '".$_SESSION['username']."' AND senha = '".SHA1($senha)."'";
      $resultConsultaSenha  = consulta_db($sqlSenha);
      $numRowsSenha     = mysql_num_rows($resultConsultaSenha);
      $consultaSenha      = mysql_fetch_object($resultConsultaUser);
      if($numRowsSenha > 0){
        if($consultaUser->data_ultimo_login == "0000-00-00 00:00:00"){
          header('Location: usuario-altera-senha-primeiro-login.php');
          exit();
        } else {
          $sqlAtualizaDataLogin = "UPDATE users SET data_ultimo_login = NOW() WHERE username = '".$_SESSION['username']."';";
          update_db($sqlAtualizaDataLogin);
          $_SESSION['senha'] = $consultaSenha->senha;

          $sqlNivel      = "SELECT id FROM users WHERE username = '$username' AND status = '1'";
          $resultNivel   = consulta_db($sqlNivel);
          $consultaNivel = mysql_fetch_object($resultNivel);
          $id = $consultaNivel->id;

          $sqlChamaNivel = "SELECT nome FROM niveis LEFT JOIN `users_niveis` ON `users_niveis`.id_nivel = `niveis`.id WHERE `users_niveis`.id_user = $id";
          $resultChamaNivel   = consulta_db($sqlChamaNivel);
          $consultaChamaNivel = mysql_fetch_object($resultChamaNivel);

          $_SESSION['nivel_acesso'] = $consultaChamaNivel->nome;

          //exit();

          header('Location: index.php');
        }
      } else {
        echo "<script type='text/javascript'>alert('".$msgErroSenha."');</script>";
      }
    } else {
      unset($_SESSION['username']);
      echo "<script type='text/javascript'>alert('".$msgErroUser."');</script>";
    }
  } else {
    unset($_SESSION['username']);
    unset($_SESSION['senha']);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Design Duro - Admin</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Icones mobiles -->
    <link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <link rel="manifest" href="img/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Favicon -->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" href="img/favicon.ico" />

    <!-- Bootstrap 3.3.2 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
      /* LOGIN */
      .div-author {
        width: 100%;
        padding-top: 10px;
      }

      .div-author p {
        text-align: center;
      }
      /* LOGIN */
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index2.html">
          <img src="img/logo_topo.png" />
        </a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Faça login no sistema</p>
        <form action="login.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" id="username" name="username" class="form-control" placeholder="Email"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-4 pull-right">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
            </div><!-- /.col -->
          </div>
        </form>

        <a href="#">Esqueci minha senha</a><br />

      </div><!-- /.login-box-body -->
      <?php /*
      <div class="div-author">
        <p>
          Desenvolvido por 
          <a href="http://intrepido53.com.br/" target="_blank">
            <img src="img/logo_intrepido_login.png" alt="Intrépido 53">
          </a>
        </p>
      </div>
    </div><!-- /.login-box -->
    */ ?>

    <!-- jQuery 2.1.3 -->
    <script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  </body>
</html>