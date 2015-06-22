<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');
    
    $id                     = $_REQUEST['id'];
    $id_categoria           = $_REQUEST['id_categoria'];
    $nome                   = $_REQUEST['nome'];
    $material               = $_REQUEST['material'];
    $preco                  = $_REQUEST['preco'];
    $peso                   = $_REQUEST['peso'];
    $link                   = $_REQUEST['link'];
    $texto                  = $_REQUEST['texto'];
    $video                  = $_REQUEST['video'];
    $ordem_video            = $_REQUEST['ordem_video'];
    $imagem_destaque        = $_FILES['imagem_destaque'];

    //$id, $nome, $material, $preco, $peso, $link, $texto, $imagem_destaque
       
    function update($id, $id_categoria, $nome, $material, $preco, $peso, $link, $texto, $video, $ordem_video){
        $sqlInsere = "UPDATE produtos SET 
        id_categoria='$id_categoria', nome='$nome', material='$material', preco='$preco', peso='$peso', link='$link', texto='$texto', video='".addslashes($video)."', ordem_video='$ordem_video'
        WHERE
        id = $id";
        //exit();
        return update_db($sqlInsere);
    }

    function updateSemImagem($id, $id_categoria, $nome, $material, $preco, $peso, $link, $texto, $video, $ordem_video){
        $sqlInsere = "UPDATE produtos SET 
        id_categoria='$id_categoria', nome='$nome', material='$material', preco='$preco', peso='$peso', link='$link', texto='$texto', video='".addslashes($video)."', ordem_video='$ordem_video'
        WHERE
        id = $id;";
        //exit();
        return update_db($sqlInsere);
    }

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
    
    function uploadImg($id, $id_categoria, $nome, $material, $preco, $peso, $link, $texto, $imagem_destaque){

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
            //testa o tamanho em pixels da imagem
            if($tamanho < 512){ //se imagem for até 500KB envia
                $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
                $tmp = $imagem_destaque['tmp_name']; //caminho temporário da imagem

                if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                    if(deletaArquivo($id)){
                        //ACAO PARA SALVAR NO BANCO
                        if(update($id, $id_categoria, $nome, $material, $preco, $peso, $link, $texto, $video, $ordem_video)){
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
    
    if(isset($imagem_destaque) && $imagem_destaque["name"] != ""){
        uploadImg($id, $id_categoria, $nome, $material, $preco, $peso, $link, $texto, $video, $ordem_video);
    } else {
        if(updateSemImagem($id, $id_categoria, $nome, $material, $preco, $peso, $link, $texto, $video, $ordem_video)){
            echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'produtos.php';</script>";
            exit();
        }
    }
    
?>