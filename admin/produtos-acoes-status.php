<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $id = $_REQUEST['id'];
    $status = $_REQUEST['status'];

    //exit();

    function chamaLog(){

        $user  = $_SESSION['username'];
        $item  = "Programas";
        $acao  = "Altera Status";
        $query = $_SESSION['query'];

        $sqlUser      = "SELECT id FROM users WHERE username = '$user' AND status = '1'";
        $resultConsultaUser = consulta_db($sqlUser);
        $numRowsUser    = mysql_num_rows($resultConsultaUser);
        $consultaUser   = mysql_fetch_object($resultConsultaUser);
        if($numRowsUser > 0){
          $id_usuario = $consultaUser->id;
          geraLogs($id_usuario, $item, $acao, $query);
          unset($_SESSION['query']);
        }
    }

    function alteraStatus($id, $status){
        $status = ($status == 1) ? 0 : 1;
        $sqlUpdate = "UPDATE programas SET status=$status WHERE id = $id";

        $_SESSION['query'] = $sqlUpdate;

        //exit();

        if(update_db($sqlUpdate)){
            return true;
        } else {
            return false;
        }
    }
    
    if(alteraStatus($id, $status)){
        chamaLog();
        echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); history.back();</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro alterar o Status!'); history.back();</script>";
    }
?>