<?php
    include("inc/config.php");

    header('Content-Type: text/html; charset=utf-8');
    /*echo "<pre>";
    print_r($imagem              = $_FILES['imagem']);
    echo $id                     = $_REQUEST['id'];
    echo $nome                   = protecao($_REQUEST['nome']);
    echo $area                   = $_REQUEST['area'];
    echo $instituicao            = $_REQUEST['instituicao'];
    echo $cidade                 = protecao($_REQUEST['cidade']);
    echo $data_inscricao         = protecao($_REQUEST['data_inscricao']);
    echo $data_prova             = protecao($_REQUEST['data_prova']);
    echo $hora_prova_inicial     = protecao($_REQUEST['hora_prova_inicial']);
    echo $hora_prova_final       = protecao($_REQUEST['hora_prova_final']);
    echo $resultado              = protecao($_REQUEST['resultado']);
    echo $mestrado               = $_REQUEST['mestrado'];
    echo $doutorado              = $_REQUEST['doutorado'];
    echo $apresentacao           = $_REQUEST['apresentacao'];
    echo $area_concentracao      = $_REQUEST['area_concentracao'];
    echo $estrutura_curricular   = $_REQUEST['estrutura_curricular'];
    echo $corpo_docente          = $_REQUEST['corpo_docente'];
    echo $selecao_matriculas     = $_REQUEST['selecao_matriculas'];
    echo $selecao_matriculas     = $_REQUEST['contato'];
    echo "</pre>";*/
    //exit();

    $id                     = $_REQUEST['id'];
    $nome                   = protecao($_REQUEST['nome']);
    $area                   = $_REQUEST['area'];
    $instituicao            = $_REQUEST['instituicao'];
    $cidade                 = protecao($_REQUEST['cidade']);
    $estado                 = protecao($_REQUEST['estado']);
    $data_inscricao         = protecao($_REQUEST['data_inscricao']);
    $data_prova             = protecao($_REQUEST['data_prova']);
    $hora_prova_inicial     = protecao($_REQUEST['hora_prova_inicial']);
    $hora_prova_final       = protecao($_REQUEST['hora_prova_final']);
    $resultado              = protecao($_REQUEST['resultado']);
    $mestrado               = $_REQUEST['mestrado'];
    $doutorado              = $_REQUEST['doutorado'];
    $apresentacao           = $_REQUEST['apresentacao'];
    $area_concentracao      = $_REQUEST['area_concentracao'];
    $estrutura_curricular   = $_REQUEST['estrutura_curricular'];
    $corpo_docente          = $_REQUEST['corpo_docente'];
    $selecao_matriculas     = $_REQUEST['selecao_matriculas'];
    $contato                = $_REQUEST['contato'];
    $imagem                 = $_FILES['imagem'];

    //exit();

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
    
    function update($id, $nome, $area, $instituicao, $cidade, $estado, $nome_atual, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato){
        //echo "entrei na funcao de salvar";
        $hora_prova = "das ".$hora_prova_inicial." às ".$hora_prova_final;
        $sqlInsere = "UPDATE programas SET 
        nome = '$nome', id_area = $area, id_instituicao = $instituicao, cidade = '$cidade', estado = '$estado', imagem = '$nome_atual', data_inscricao = '$data_inscricao', data_prova = '$data_prova', hora_prova = '$hora_prova', resultado = '$resultado', fl_mestrado = '$mestrado', fl_doutorado = '$doutorado', apresentacao = '$apresentacao', area_concentracao = '$area_concentracao', estrutura_curricular = '$estrutura_curricular', corpo_docente = '$corpo_docente', selecao_matriculas = '$selecao_matriculas', contato= '$contato', data = NOW()
        WHERE
        id = $id";
        $_SESSION['query'] = $sqlInsere;
        //exit();
        return update_db($sqlInsere);
    }

    function updateSemImagem($id, $nome, $area, $instituicao, $cidade, $estado, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato){
        //echo "entrei na funcao de salvar";
        $hora_prova = "das ".$hora_prova_inicial." às ".$hora_prova_final;
        $sqlInsere = "UPDATE programas SET 
        nome = '$nome', id_area = $area, id_instituicao = $instituicao, cidade = '$cidade', estado = '$estado', data_inscricao = '$data_inscricao', data_prova = '$data_prova', hora_prova = '$hora_prova', resultado = '$resultado', fl_mestrado = '$mestrado', fl_doutorado = '$doutorado', apresentacao = '$apresentacao', area_concentracao = '$area_concentracao', estrutura_curricular = '$estrutura_curricular', corpo_docente = '$corpo_docente', selecao_matriculas = '$selecao_matriculas', contato = '$contato', data = NOW()
        WHERE
        id = $id;";
        $_SESSION['query'] = $sqlInsere;
        //exit();
        return update_db($sqlInsere);
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
    
    function uploadImg($id, $imagem, $nome, $area, $instituicao, $cidade, $estado, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato){

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
                        //if(deletaArquivo($id)){
                            //ACAO PARA SALVAR NO BANCO
                            if(update($id, $nome, $area, $instituicao, $cidade, $estado, $nome_atual, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato)){
                                chamaLog();
                                echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'programas.php?idarea=$area';</script>";
                                exit();
                            }
                        //}
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
    
    if(isset($imagem) && $imagem["name"] != ""){
        //echo "ALTEREI a imagem";
        //exit();
        uploadImg($id, $imagem, $nome, $area, $instituicao, $cidade, $estado, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato);
    } else {
        //echo "NAO alterei a imagem";
        //exit();
        if(updateSemImagem($id, $nome, $area, $instituicao, $cidade, $estado, $data_inscricao, $data_prova, $hora_prova_inicial, $hora_prova_final, $resultado, $mestrado, $doutorado, $apresentacao, $area_concentracao, $estrutura_curricular, $corpo_docente, $selecao_matriculas, $contato)){
            chamaLog();
            //echo "ALTEREI os dados";
            echo "<script type='text/javascript'>alert('Operação realizada com sucesso!'); window.location = 'programas.php?idarea=$area';</script>";
            exit();
        }
    }
    
?>