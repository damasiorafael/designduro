<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $id = $_REQUEST['id'];
    $status = $_REQUEST['status'];

    function alteraStatus($id, $status){
        $status = ($status == 1) ? 0 : 1;
        $sqlUpdate = "UPDATE citacao SET status=$status WHERE id = $id";

        $_SESSION['query'] = $sqlUpdate;

        if(update_db($sqlUpdate)){
            return true;
        } else {
            return false;
        }
    }
    
    if(alteraStatus($id, $status)){
        echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); history.back();</script>";
    } else {
        echo "<script type='text/javascript'>alert('Erro alterar o Status!'); history.back();</script>";
    }
?>