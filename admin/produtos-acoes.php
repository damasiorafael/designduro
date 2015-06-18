<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');

    $nome                   = $_REQUEST['nome'];
    $id_categoria           = $_REQUEST['id_categoria'];
    $material               = $_REQUEST['material'];
    $preco                  = $_REQUEST['preco'];
    $peso                   = $_REQUEST['peso'];
    $link                   = $_REQUEST['link'];
    $texto                  = $_REQUEST['texto'];
    
    
    $_SESSION['nome']                   = $nome;
    $_SESSION['id_categoria']           = $id_categoria;
    $_SESSION['material']               = $material;
    $_SESSION['preco']                  = $preco;
    $_SESSION['peso']                   = $peso;
    $_SESSION['link']                   = $link;
    $_SESSION['texto']                  = $texto;

    //exit();
    
    function insere($nome, $area, $instituicao, $cidade, $estado, $nome_atual, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato){
        //echo "entrei na funcao de salvar";
        $hora_prova = "das ".$hora_prova_inicial." às ".$hora_prova_final;
        $sqlInsere = "INSERT INTO programas
        (nome, id_area, id_instituicao, cidade, estado, imagem, data_inscricao, data_prova, hora_prova, resultado, fl_mestrado, fl_doutorado, apresentacao, area_concentracao, estrutura_curricular, corpo_docente, selecao_matriculas, contato, data)
        VALUES
        ('$nome', $area, $instituicao, '$cidade', estado, '$nome_atual', '$data_inscricao', '$data_prova', '$hora_prova', '$resultado', '$mestrado', '$doutorado', '$apresentacao', '$area_concentracao', '$estrutura_curricular', '$corpo_docente', '$selecao_matriculas', '$contato', NOW());";
        $_SESSION['query'] = $sqlInsere;
        return insert_db($sqlInsere);
    }

    function limpaSessionsFormulario(){
        if(isset($_SESSION['nome'])) unset($_SESSION['nome']);
        if(isset($_SESSION['area'])) unset($_SESSION['area']);
        if(isset($_SESSION['instituicao'])) unset($_SESSION['instituicao']);
        if(isset($_SESSION['cidade'])) unset($_SESSION['cidade']);
        if(isset($_SESSION['estado'])) unset($_SESSION['estado']);
        if(isset($_SESSION['data_inscricao'])) unset($_SESSION['data_inscricao']);
        if(isset($_SESSION['data_prova'])) unset($_SESSION['data_prova']);
        if(isset($_SESSION['hora_prova_inicial'])) unset($_SESSION['hora_prova_inicial']);
        if(isset($_SESSION['hora_prova_final'])) unset($_SESSION['hora_prova_final']);
        if(isset($_SESSION['resultado'])) unset($_SESSION['resultado']);
        if(isset($_SESSION['mestrado'])) unset($_SESSION['mestrado']);
        if(isset($_SESSION['doutorado'])) unset($_SESSION['doutorado']);
        if(isset($_SESSION['apresentacao'])) unset($_SESSION['apresentacao']);
        if(isset($_SESSION['area_concentracao'])) unset($_SESSION['area_concentracao']);
        if(isset($_SESSION['estrutura_curricular'])) unset($_SESSION['estrutura_curricular']);
        if(isset($_SESSION['corpo_docente'])) unset($_SESSION['corpo_docente']);
        if(isset($_SESSION['selecao_matriculas'])) unset($_SESSION['selecao_matriculas']);
        if(isset($_SESSION['contato'])) unset($_SESSION['contato']);
        if(isset($_SESSION['imagem'])) unset($_SESSION['imagem']);

        return true;
    }
    
    function uploadImg($imagem, $nome, $area, $instituicao, $cidade, $estado, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato){

        $bucket="pgsskroton-uploads";

        include("inc/aws/s3_config.php");

        $pasta = "../uploads/";
    
        /* formatos de imagem permitidos */
        $permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp");
        
        //FAZ O UPLOAD DAS IMAGENS ENQUANTO EXISTIREM
        $nome_imagem    = $imagem['name'];
        $tamanho_imagem = $imagem['size'];
            
        /* pega a extensão do arquivo */
        $ext = strtolower(strrchr($nome_imagem,"."));

        //281 x 184
        /* chega dimensoes da imagem */
        list($largura, $altura) = getimagesize($imagem['tmp_name']);

        /* converte o tamanho para KB */
        $tamanho = round($tamanho_imagem / 1024);
            
        /*  verifica se a extensão está entre as extensões permitidas */
        if(in_array($ext,$permitidos)){
            if($altura == 184 && $largura == 281){
                //testa o tamanho em pixels da imagem
                if($tamanho < 512){ //se imagem for até 500KB envia
                    $nome_atual = md5(uniqid(time())).$ext; //nome que dará a imagem
                    $tmp = $imagem['tmp_name']; //caminho temporário da imagem

                    //if(move_uploaded_file($tmp,$pasta.$nome_atual)){
                    if($s3->putObjectFile($tmp, $bucket , $nome_atual, S3::ACL_PUBLIC_READ)){
                        //ACAO PARA SALVAR NO BANCO
                        if(insere($nome, $area, $instituicao, $cidade, $estado, $nome_atual, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato)){
                            if(limpaSessionsFormulario()){
                                echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'programas.php';</script>";
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
            } else {
                //echo "atura e largura não permitidos";
                echo "<script type='text/javascript'>alert('A imagem deve ter as dimensões de 281 x 184 pixels!'); history.back();</script>";
            }
        } /*else {
            //echo "Somente são aceitos arquivos do tipo Imagem";
            echo "<script type='text/javascript'>alert('Somente são aceitos arquivos do tipo Imagem!'); //history.back();</script>";
            */
        //echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'programas-add.php';</script>";
        exit();
    }
    
    if($acao == ""){
        uploadImg($imagem, $nome, $area, $instituicao, $cidade, $estado, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato);
    } else if($acao == "delete"){
        if(deletaItem($id)){
            echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'programas.php';</script>";
        } else {
            echo "<script type='text/javascript'>alert('Erro ao deletar o arquivo!'); history.back();</script>";
        }
    }
?>