<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $id = $_REQUEST['id'];

    function chamaLog(){

        $user  = $_SESSION['username'];
        $item  = "Programas";
        $acao  = "Editar";
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

    function deletaArquivo($id){
        $sqlConsulta    = "SELECT imagem FROM programas WHERE id = $id";
        $resultConsulta = consulta_db($sqlConsulta);
        while($consulta = mysql_fetch_object($resultConsulta)){
            $arquivo = "../uploads/".$consulta->imagem;
            if (unlink($arquivo)){
                return true;
            } else {
                return false;
            }
        }
    }

    function deletaItem($id){
        //if(deletaArquivo($id)){
            $sqlDelete = "DELETE FROM programas WHERE id = $id";
            $_SESSION['query'] = $sqlDelete;
            if(deleta_db($sqlDelete)){
                return true;
            } else {
                return false;
            }
        //}
    }
    
    if(deletaItem($id)){
        chamaLog();
        echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); history.back();</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro ao deletar o arquivo!'); history.back();</script>";
    }
?>