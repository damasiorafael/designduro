<?php
    include("inc/config.php");
    
    $acao   = $_REQUEST['acao'];
    $id     = $_REQUEST['id'];

    $nome               = $_REQUEST['nome'];
    $id_categoria       = $_REQUEST['id_categoria'];
    $material           = $_REQUEST['material'];
    $preco              = $_REQUEST['preco'];
    $peso               = $_REQUEST['peso'];
    $link               = $_REQUEST['link'];
    $video              = $_REQUEST['video'];
    $ordem_video        = $_REQUEST['ordem_video'];
    $texto              = $_REQUEST['texto'];
    
    $arrayItens = $_REQUEST['arrayItens'];
    
    $arrayImagens   = $_FILES['img_destaque'];
    
    function selectUltimo(){
        $sqlUltimo  = "SELECT MAX(id) as ultimo_id FROM produtos";
        $resultConsulta = consulta_db($sqlUltimo);
        while($consulta = mysql_fetch_object($resultConsulta)){
            return $consulta->ultimo_id;
        }
    }
    
    function inserePortfolio($nome, $id_categoria, $material, $preco, $peso, $link, $texto, $video, $ordem_video){
        $sqlInserePortfolio = "INSERT INTO produtos
        (nome, id_categoria, material, preco, peso, link, texto, video, ordem_video)
        VALUES
        ('$nome', '$id_categoria', '$material', '$preco', '$peso', '$link', '$texto', '".addslashes($video)."', '$ordem_video');";
        return insert_db($sqlInserePortfolio);
    }
    
    function inserePortfolioImagens($id, $imagem){
        $sqlInserePortfolioImagens = "INSERT INTO produtos_imagens (id_produto, imagem) VALUES ($id, '$imagem');";
        return insert_db($sqlInserePortfolioImagens);
    }
    
    function uploadImg($arrayImagens, $ultimoId){

        $pasta = "../uploads/";
    
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        
        //FAZ O UPLOAD DAS IMAGENS ENQUANTO EXISTIREM
        for($qt=0; $qt<count($arrayImagens);$qt++){     
            $nome_imagem    = $arrayImagens['name'][$qt];
            $tamanho_imagem = $arrayImagens['size'][$qt];
            
            /* pega a extensão do arquivo */
            $ext = strtolower(strrchr($nome_imagem,"."));
            
            /*  verifica se a extensão está entre as extensões permitidas */
            if(in_array($ext,$permitidos)){
                /* converte o tamanho para KB */
                $tamanho = round($tamanho_imagem / 1024);
                if($tamanho < 512){ //se imagem for até 1MB envia
                    $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
                    $tmp = $arrayImagens['tmp_name'][$qt]; //caminho temporário da imagem
                    
                    /* se enviar a foto, insere o nome da foto no banco de dados */
                    if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                        //mysql_query("INSERT INTO fotos (foto) VALUES (".$nome_atual.")");
                        inserePortfolioImagens($ultimoId, $nome_atual);
                    } else {
                        //echo "Falha ao enviar";
                        echo "<script type='text/javascript'>alert('Falha ao enviar!'); history.back();</script>";
                    }
                } else {
                    //echo "A imagem deve ser de no máximo 2MB";
                    echo "<script type='text/javascript'>alert('A imagem deve ter no máximo 500kb!'); history.back();</script>";
                }
            } /*else {
                //echo "Somente são aceitos arquivos do tipo Imagem";
                echo "<script type='text/javascript'>alert('Somente são aceitos arquivos do tipo Imagem!'); //history.back();</script>";
            }*/
        }
        echo "<script type='text/javascript'>alert('Cadastro efetuado com sucesso!'); window.location = 'produtos.php';</script>";
    }
    
    if($acao == ""){
        if(inserePortfolio($nome, $id_categoria, $material, $preco, $peso, $link, $texto, $video, $ordem_video)){
            $ultimoId = selectUltimo();
            uploadImg($arrayImagens, $ultimoId);
        }
    } else if($acao == "edit_image"){
        $id_imagem      = $_REQUEST["id_imagem"];
        $tmp            = $_FILES['img_teste_'.$id_imagem]['tmp_name'];
        $nome_imagem    = $_FILES['img_teste_'.$id_imagem]['name'];
        $tamanho_imagem = $_FILES['img_teste_'.$id_imagem]['size'];
        
        $pasta = "../uploads/";
        
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        
        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem,"."));
        
        /*  verifica se a extensão está entre as extensões permitidas */
        if(in_array($ext,$permitidos)){
            /* converte o tamanho para KB */
            $tamanho = round($tamanho_imagem / 1024);
            if($tamanho < 512){ //se imagem for até 1MB envia
                $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
                
                /* se enviar a foto, insere o nome da foto no banco de dados */
                if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                    $sqlEdit = "UPDATE produtos_imagens SET imagem='$nome_atual' WHERE id=$id_imagem";
                    if(update_db($sqlEdit)){
                        echo "<img width='80' src='../uploads/$nome_atual'>";
                    }
                    //inserePortfolioImagens($ultimoId, $nome_atual);
                } else {
                    //echo "Falha ao enviar";
                    echo "<script type='text/javascript'>alert('Falha ao enviar!'); history.back();</script>";
                }
            } else {
                //echo "A imagem deve ser de no máximo 2MB";
                echo "<script type='text/javascript'>alert('A imagem deve ter no máximo 500kb!'); history.back();</script>";
            }
        }
    } else if($acao == "deleta_imagem"){
        $id_imagem              = $_REQUEST["id_imagem"];
        $sqlDelete              = "DELETE FROM `produtos_imagens` WHERE `id` = $id_imagem";
        $sqlConsultaImagens     = "SELECT `imagem` FROM `produtos_imagens` WHERE `id` = $id_imagem";
        $resultConsultaImagens  = consulta_db($sqlConsultaImagens);
        while($consultaImagens = mysql_fetch_object($resultConsultaImagens)){
            $arquivo = "../uploads/".$consultaImagens->imagem;
            if(deleta_db($sqlDelete)){
                if (unlink($arquivo)){
                    echo "sucesso";
                } else {
                    echo ("Erro ao deletar $arquivo");
                }
            }
        }
    } else if($acao == "add_nova_image"){
        $id                 = $_REQUEST["id"];
        $id_controle        = $_REQUEST["id_controle"];
        $tmp                = $_FILES["add_nova_image_".$id_controle]["tmp_name"];
        $nome_imagem        = $_FILES["add_nova_image_".$id_controle]["name"];
        $tamanho_imagem     = $_FILES["add_nova_image_".$id_controle]["size"];
        
        $pasta = "../uploads/";
        
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        
        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem,"."));
        
        /*  verifica se a extensão está entre as extensões permitidas */
        if(in_array($ext,$permitidos)){
            /* converte o tamanho para KB */
            $tamanho = round($tamanho_imagem / 1024);
            if($tamanho < 512){ //se imagem for até 1MB envia
                $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
                
                /* se enviar a foto, insere o nome da foto no banco de dados */
                if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                    $sqlEdit = "INSERT INTO produtos_imagens (id_produto, imagem) VALUES ($id, '$nome_atual');";
                    if(update_db($sqlEdit)){
                        echo "<img width='70' src='../uploads/$nome_atual'>";
                    }
                    //inserePortfolioImagens($ultimoId, $nome_atual);
                } else {
                    //echo "Falha ao enviar";
                    echo "<script type='text/javascript'>alert('Falha ao enviar!'); history.back();</script>";
                }
            } else {
                //echo "A imagem deve ser de no máximo 2MB";
                echo "<script type='text/javascript'>alert('A imagem deve ter no máximo 500kb!'); history.back();</script>";
            }
        }
    }
?>