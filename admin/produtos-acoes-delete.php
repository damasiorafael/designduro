<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $id = $_REQUEST['id'];

    function deletaArquivo($id){
        $sqlConsulta    = "SELECT imagem_destaque FROM produtos WHERE id = $id";
        $resultConsulta = consulta_db($sqlConsulta);
        while($consulta = mysql_fetch_object($resultConsulta)){
            $arquivo = "../uploads/".$consulta->imagem_destaque;
            if (unlink($arquivo)){
                return true;
            } else {
                return false;
            }
        }
    }

    function deletaItem($id){
        if(deletaArquivo($id)){
            $sqlDelete = "DELETE FROM produtos WHERE id = $id";
            if(deleta_db($sqlDelete)){
                return true;
            } else {
                return false;
            }
        }
    }
    
    if(deletaItem($id)){
        echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); history.back();</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro ao deletar o arquivo!'); history.back();</script>";
    }
?>