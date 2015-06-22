<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $id         = $_REQUEST['id'];
    $texto      = $_REQUEST['texto'];
    $autor      = $_REQUEST['autor'];    

    function updateSemImagem($id, $texto, $autor){
        //echo "entrei na funcao de salvar SEM imagem";
        //exit();
        $sqlInsere = "UPDATE citacao SET 
        texto = '$texto', autor = '$autor'
        WHERE
        id = $id;";
        return update_db($sqlInsere);
    }
    
    
    //echo "oi sem imagem";
    //exit();
    if(updateSemImagem($id, $texto, $autor)){
        echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'citacao.php';</script>";
        exit();
    }    
?>