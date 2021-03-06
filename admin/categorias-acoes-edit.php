<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $id         = $_REQUEST['id'];
    $texto      = $_REQUEST['texto'];
    $imagem     = $_FILES['imagem'];

    
    function update($id, $texto, $nome_atual){
        //echo "entrei na funcao de salvar com imagem";
        //exit();
        $sqlInsere = "UPDATE categorias SET 
        texto = '$texto', imagem = '$nome_atual'
        WHERE
        id = $id";
        $_SESSION['query'] = $sqlInsere;
        return update_db($sqlInsere);
    }

    function updateSemImagem($id, $texto){
        //echo "entrei na funcao de salvar SEM imagem";
        //exit();
        $sqlInsere = "UPDATE categorias SET 
        texto = '$texto'
        WHERE
        id = $id;";
        $_SESSION['query'] = $sqlInsere;
        return update_db($sqlInsere);
    }

    function deletaArquivo($id){
        $sqlConsulta    = "SELECT imagem FROM categorias WHERE id = $id";
        //exit();
        $resultConsulta = consulta_db($sqlConsulta);
        while($consulta = mysql_fetch_object($resultConsulta)){
            $arquivo = "../uploads/".$consulta->imagem;
            //exit();
            if(unlink($arquivo)){
                return true;
            } else {
                return false;
            }
        }
    }
    
    function uploadImg($id, $texto, $imagem){

        $pasta = "../uploads/";
    
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        
        //FAZ O UPLOAD DAS IMAGENS ENQUANTO EXISTIREM
        $nome_imagem    = $imagem['name'];
        $tamanho_imagem = $imagem['size'];
            
        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem,"."));

        /* converte o tamanho para KB */
        $tamanho = round($tamanho_imagem / 1024);
            
        if($tamanho < 500){ //se imagem for até 1MB envia
            $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
            $tmp = $imagem['tmp_name']; //caminho temporário da imagem

            if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                if(deletaArquivo($id)){
                    //ACAO PARA SALVAR NO BANCO
                    if(update($id, $texto, $nome_atual)){
                        echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'categorias.php';</script>";
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
            echo "<script type='text/javascript'>alert('O arquivo deve ter no máximo 500kb!'); history.back();</script>";
            exit();
        }
        exit();
    }
    
    if(isset($imagem) && $imagem["name"] != ""){
        //echo "oi";
        //exit();
        uploadImg($id, $texto, $imagem);
    } else {
        //echo "oi sem imagem";
        //exit();
        if(updateSemImagem($id, $texto)){
            echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'categorias.php';</script>";
            exit();
        }
    }
    
?>