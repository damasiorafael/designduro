<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $nome               = $_REQUEST['nome'];
    $id_categoria       = $_REQUEST['id_categoria'];
    $material           = $_REQUEST['material'];
    $preco              = $_REQUEST['preco'];
    $peso               = $_REQUEST['peso'];
    $link               = $_REQUEST['link'];
    $texto              = $_REQUEST['texto'];
    $imagem_destaque    = $_FILES['imagem_destaque'];    
    
    $_SESSION['nome']           = $nome;
    $_SESSION['id_categoria']   = $id_categoria;
    $_SESSION['material']       = $material;
    $_SESSION['preco']          = $preco;
    $_SESSION['peso']           = $peso;
    $_SESSION['link']           = $link;
    $_SESSION['texto']          = $texto;

    //exit();
    
    function insere($nome, $id_categoria, $material, $preco, $peso, $link, $texto, $imagem_destaque){
        $sqlInsere = "INSERT INTO produtos
        (nome, id_categoria, material, preco, peso, link, texto, imagem_destaque)
        VALUES
        ('$nome', '$id_categoria', '$material', '$preco', '$peso', '$link', '$texto', '$imagem_destaque');";
        return insert_db($sqlInsere);
    }

    function limpaSessionsFormulario(){

        if(isset($_SESSION['nome'])) unset($_SESSION['nome']);
        if(isset($_SESSION['id_categoria'])) unset($_SESSION['id_categoria']);
        if(isset($_SESSION['material'])) unset($_SESSION['material']);
        if(isset($_SESSION['preco'])) unset($_SESSION['preco']);
        if(isset($_SESSION['peso'])) unset($_SESSION['peso']);
        if(isset($_SESSION['link'])) unset($_SESSION['link']);
        if(isset($_SESSION['texto'])) unset($_SESSION['texto']);

        return true;
    }
    
    function uploadImg($nome, $id_categoria, $material, $preco, $peso, $link, $texto, $imagem_destaque){

        $pasta = "../uploads/";
    
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        
        //FAZ O UPLOAD DAS IMAGENS ENQUANTO EXISTIREM
        $nome_imagem    = $imagem_destaque['name'];
        $tamanho_imagem = $imagem_destaque['size'];
            
        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem,"."));

        //281 x 184
        /* chega dimensoes da imagem */
        list($largura, $altura) = getimagesize($imagem_destaque['tmp_name']);

        /* converte o tamanho para KB */
        $tamanho = round($tamanho_imagem / 1024);
            
        /*  verifica se a extensão está entre as extensões permitidas */
        if(in_array($ext,$permitidos)){
            if($tamanho < 512){ //se imagem for até 500KB envia
                $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
                $tmp = $imagem_destaque['tmp_name']; //caminho temporário da imagem

                if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                    //ACAO PARA SALVAR NO BANCO
                    if(insere($nome, $id_categoria, $material, $preco, $peso, $link, $texto, $nome_atual)){
                        if(limpaSessionsFormulario()){
                            echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'produtos.php';</script>";
                            exit();
                        }
                    }
                } else {
                    //Falha no UPLOAD;
                    echo "<script type='text/javascript'>alert('Falha ao salvar!'); history.back();</script>";
                    exit();
                }
            } else {
                //Falha no tamanho da imagem em pixels
                echo "<script type='text/javascript'>alert('A imagem deve ser de no máximo 500KB!'); history.back();</script>";
                exit();
            }
        } /*else {
            //echo "Somente são aceitos arquivos do tipo Imagem";
            echo "<script type='text/javascript'>alert('Somente são aceitos arquivos do tipo Imagem!'); //history.back();</script>";
            */
        //echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'programas-add.php';</script>";
        exit();
    }
    
    uploadImg($nome, $id_categoria, $material, $preco, $peso, $link, $texto, $imagem_destaque);
?>