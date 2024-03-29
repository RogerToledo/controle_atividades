<?php

    require "./_app/Config.inc.php";
    //require "./system/sla.class.php";
    require "./system/model.class.php";
    require "./system/ajax.class.php";
    //require "./_ajax/Atividades.ajax.php";
    
    $read = new Read;
    
    session_start();
    
    if(!Check::logIn()):
        header("Location: index.php");       
    endif; 
    
    $ajaxAtiv = new Ajax;
    $json = $ajaxAtiv->Atividades();
    echo $json;
    //$itensPagina = 20;
    //$pagina = intval($_GET['pagina']);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <title>Integração</title>
               
    </head>
    
    <body>
        <!-- Barra de Navegação -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="integracao.php">Brand</a>
                </div>
                <ul class="nav navbar-nav dropdown">
                    <?php
                        if($_SESSION['usr_nivel'] != 1):
                            echo "<li><a href='#' data-toggle='modal' data-target='#modalControleAtiv'><span class='glyphicon glyphicon-plus-sign'></span> Nova Atividade</a></li>";
                        endif;
                    ?>
                    
                    <li class='dropdown'>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownCadastro" hidden="hidden"><span class="glyphicon glyphicon-list"></span> Cadastros <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownCadastro">
                            <li><a href="#" data-toggle="modal" data-target="#modalCliente">Cliente</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#modalDivida">Dívida Ativa</a></li>
                            <?php
                                if($_SESSION['usr_nivel'] == 9):
                                    echo "<li><a href='#' data-toggle='modal' data-target='#modalIntegrante'>Integrante</a></li>
                                            <li><a href='#' data-toggle='modal' data-target='#modalAtividade'>Tipo de Atividade</a></li>
                                            <li><a href='#' data-toggle='modal' data-target='#modalAtendimento'>Tipo de Atendimento</a></li>";
                                endif;  
                            ?>
                            
                        </ul>
                    </li>    
                    <li class='dropdown'>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownRelatorios" hidden="hidden"><span class="glyphicon glyphicon-stats"></span> Relatórios <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownRelatorios">
                            <li><a href="system/prioridade_aberta_excel.php">Atividades Priorizadas em Aberto | Excel</a></li>
                            <li><a href="system/todas_excel.php">Todas Atividades | Excel</a></li>
                            <li><a href="system/clientes_excel.php">Clientes | Excel</a></li>
                            <li><a href="system/da_excel.php">Dívida Ativa | Excel</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownSistema" hidden=""><span class="glyphicon glyphicon-flash"></span> Sist. <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownRelatorios">
                            <li><a href="integracao.php">Integração</a></li>
                            <li><a href="suporte.php">Suporte</a></li>
                        </ul>
                    </li>
                    </li>
                    <li>
                        <a href="#"><?=$_SESSION['usr_nome'];?></a>
                    </li>
                    <li>
                        <a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- FIM - Barra de Navegação -->
        
        <?php
            $Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            //var_dump($Data);
            if(!empty($Data)):
                switch ($Data['submit']):
                    case 'ist_integrante';
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $insert = new model;
                            $insert->ist_integrante($Data);

                            echo $insert->getResult();  
                        endif;    

                        break;

                    case 'ist_cliente';
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $insert = new model;
                            $insert->ist_cliente($Data);

                            echo $insert->getResult();
                        endif;
                        
                        break;

                    case 'ist_dividaAtiva';
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $insert = new model;
                            $insert->ist_divida_ativa($Data);

                            echo $insert->getResult();
                        endif;
                        
                        break;

                    case 'ist_tipoAtividade';
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $insert = new model;
                            $insert->ist_tpAtividade($Data);

                            echo $insert->getResult();
                        endif;
                        
                        break;

                    case 'ist_tipoAtendimento';
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $insert = new model;
                            $insert->ist_tpAtendimento($Data);

                            echo $insert->getResult();
                        endif;
                        
                        break;

                    case 'ist_atividade':
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $Data['ativ_equipe'] = 1;
                            $insert = new model;
                            $insert->ist_atividade($Data);

                            echo $insert->getResult();
                        endif;
                        
                        break;
                    
                    case 'udt_status':
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $update = new model;
                            $update->pause($Data);
                        endif;    
                    
                        break;
                    
                    case 'udt_atividades':    
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                                                        
                            $sla = new model;
                                                        
                            $Data['ativ_corrente_sla'] = $sla->calcSla($Data['ativ_id'], $Data['ativ_data_termino'], $Data['ativ_hora_termino']); 
                            if((int)$Data['ativ_corrente_sla'] <= (int)$Data['tpati_sla']):
                                unset($Data['ativ_motivo_sla']);
                            endif; 
                            //var_dump($Data);
                            $update = new model;
                            $update->udt_atividade($Data);
									
                            echo $update->getResult(); 
                            
                            $DataSla['ativ_corrente_sla'] = $sla->calcSla($Data['ativ_id']); 
                            $DataSla['ativ_id'] = $Data['ativ_id'];      
                            
                            $upSla = new model;
                            $upSla->upt_sla($DataSla);
                            
                        endif;
                       
                        break;

               endswitch;
           endif;
        ?> 
        
        <!-- Gráfico Dash -->
        <div class="container-fluid">            
            <h2>Lista de Atividades</h2>
            <div class="btn-group" data-toggle="buttons" style="padding-bottom: 15px;">
                <label class="btn btn-default btn-md active">
                  <input type="radio" name="options" id="abertas" autocomplete="off" checked> Abertas
                </label>
                <label class="btn btn-default btn-md">
                  <input type="radio" name="options" id="fechadas" autocomplete="off"> Fechadas
                </label>
            </div>
        </div>
        <div class="container-fluid" id="ativ-abertas">
            <div class="table-responsive">  
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr style="background-color:#a4a4a4;">
                            <th>#</th>
                            <th class="col-sm-2">Atividade</th>
                            <th class="col-sm-2">Descrição</th>
                            <th class="col-sm-1">Complexidade</th>
                            <th class="col-sm-1">Analista</th>
                            <th class="col-sm-1">Cliente</th>
                            <th class="col-sm-1">Tipo Entrada</th>
                            <th class="col-sm-1">Atendimento</th>
                            <th class="col-sm-1">Entrada</th>
                            <th class="col-sm-1">Início</th>
                            <th class="col-sm-1">SLA</th>
                           <th class="col-sm-1" >Tempo</th>
                            <th class="col-sm-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $queryAberto = "SELECT
                                        ati.ativ_id,
                                        tpati.tpati_id,
                                        tpati.tpati_tipo,
                                        ati.tpati_criticidade,
                                        ati.ativ_desc,
                                        usr.usr_id,
                                        usr.usr_nome,
                                        cli.cli_id,
                                        cli.cli_codigo,
                                        cli.cli_nome,
                                        ativ_tp_entrada, 
                                        ati.ativ_sac,
                                        tpate.tpate_id,
                                        tpate.tpate_desc,
                                        tpati_sla,
                                        ati.ativ_corrente_sla,
                                        ati.ativ_motivo_sla,
                                        sec_to_time(time_to_sec(tpati_sla) * 0.6) as tpati_sla_06,
                                        ati.ativ_data_entrada,
                                        ati.ativ_hora_entrada,
                                        ati.ativ_data_inicio,
                                        ati.ativ_hora_inicio,
                                        ati.ativ_data_termino,
                                        ati.ativ_hora_termino,
                                        ati.ativ_solucao,
                                        ati.usr_id_prioridade,
                                        pri.usr_nome AS ativ_nome_prioridade,
                                        ati.ativ_data_prioridade,
                                        ati.ativ_motivo_prioridade,
                                        ati.ativ_flag_prioridade
                                 FROM tb_atividades ati
                                 INNER JOIN tb_cliente cli
                                        ON ati.cli_id = cli.cli_id
                                 LEFT OUTER JOIN tb_tipo_atividades tpati
                                        ON ati.tpati_id = tpati.tpati_id
                                 LEFT OUTER JOIN tb_usuario usr
                                        ON ati.usr_id = usr.usr_id
                                 LEFT OUTER JOIN tb_usuario pri        
                                        ON ati.usr_id_prioridade = pri.usr_id
                                 LEFT OUTER JOIN tb_tipo_atendimento tpate
                                        ON ati.tpate_id = tpate.tpate_id
                                 WHERE 
                                      ativ_data_termino IS NULL
                                      AND ativ_equipe = 1
                                 ORDER BY ati.ativ_flag_prioridade desc,ati.ativ_id;";
                        $readAberto = new Read;
                        $readAberto->FullRead($queryAberto);
                        
                        if(!$readAberto->getResult()):
                            echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe atividades em aberto.</div>';
                        else:

                            foreach($readAberto->getResult() as $ativAberto):
                                extract($ativAberto);
                                echo "<tr>";
                                if($ativ_flag_prioridade == 1):
                                   echo "<td style='background-color: #CDBE70'>{$ativ_id}</td>"; 
                                else:
                                   echo "<td>{$ativ_id}</td>"; 
                                endif;                            
                                echo "<td>{$tpati_tipo}</td>";                                
                                $ativ_desc_limit = Check::Chars($ativ_desc,60);
                                echo "<td>{$ativ_desc_limit}</td>";
                                echo "<td>{$tpati_criticidade}</td>";
                                echo "<td>{$usr_nome}</td>";
                                echo "<td>{$cli_codigo}</td>";
                                echo "<td>{$ativ_tp_entrada} {$ativ_sac}</td>";
                                echo "<td>{$tpate_desc}</td>";
                                $ativ_data_entrada = Check::DataTela($ativ_data_entrada);
                                echo "<td>{$ativ_data_entrada} {$ativ_hora_entrada}</td>";   
                                
                                $ativ_data_inicio = Check::DataTela($ativ_data_inicio);
                                echo "<td>{$ativ_data_inicio} {$ativ_hora_inicio}</td>";
                                echo "<td>{$tpati_sla}</td>";
                                
                                $sla = new model;
                                $calcSla = $sla->calcSla($ativ_id);
                                                               
                                $checSla = Check::checkSla($tpati_sla, $calcSla);
                                
                                if($checSla == 1):
                                    echo "<td style='background-color: #8B2323; color: white' display='none'>{$calcSla}</td>";
                                else:    
                                    echo "<td>{$calcSla}</td>";
                                endif;
                                
                                echo "<td>";
                                    if($_SESSION['usr_nivel'] == 1):
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";     
                                    elseif($_SESSION['usr_id'] == $usr_id || $_SESSION['usr_nivel'] == 9 || empty($usr_nome)):
                                        echo "<button type='button' class='btn btn-info btn-xs glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";
                                    else:
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";     
                                    endif;
                                         
                                echo "</td>";
                                echo "</tr>";     
                            endforeach;
                        endif;
                        
                    ?>
                    </tbody>
                </table>
            </div>    
        </div>
        
        <div class="container-fluid" id="ativ-fechadas" hidden="">
            <div class="table-responsive">  
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr style="background-color:#a4a4a4;">
                            <th>#</th>
                            <th class="col-sm-2">Atividade</th>
                            <th class="col-sm-2">Descrição</th>
                            <th class="col-sm-1">Complexidade</th>
                            <th class="col-sm-1">Analista</th>
                            <th class="col-sm-1">Cliente</th>
                            <th class="col-sm-1">Tipo Entrada</th>
                            <th class="col-sm-1">Atendimento</th>
                            <th class="col-sm-1">Entrada</th>
                            <th class="col-sm-1">Início</th>
                            <th class="col-sm-1">Término</th>
                            <th class="col-sm-1">SLA</th>
                            <th class="col-sm-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $queryFechado = "SELECT
                                        ati.ativ_id,
                                        tpati.tpati_id,
                                        tpati.tpati_tipo,
                                        ati.tpati_criticidade,
                                        ati.ativ_desc,
                                        usr.usr_id,
                                        usr.usr_nome,
                                        cli.cli_id,
                                        cli.cli_codigo,
                                        cli.cli_nome,
                                        ativ_tp_entrada, 
                                        ati.ativ_sac,
                                        tpate.tpate_id,
                                        tpate.tpate_desc,
                                        tpati_sla,
                                        ati.ativ_corrente_sla,
                                        ati.ativ_motivo_sla,
                                        sec_to_time(time_to_sec(tpati_sla) * 0.6) as tpati_sla_06,
                                        ati.ativ_data_entrada,
                                        ati.ativ_hora_entrada,
                                        ati.ativ_data_inicio,
                                        ati.ativ_hora_inicio,
                                        ati.ativ_data_termino,
                                        ati.ativ_hora_termino,
                                        ati.ativ_solucao,
                                        ati.usr_id_prioridade,
                                        pri.usr_nome AS ativ_nome_prioridade,
                                        ati.ativ_data_prioridade,
                                        ati.ativ_motivo_prioridade,
                                        ati.ativ_flag_prioridade
                                 FROM tb_atividades ati
                                 INNER JOIN tb_cliente cli
                                        ON ati.cli_id = cli.cli_id
                                 LEFT OUTER JOIN tb_tipo_atividades tpati
                                        ON ati.tpati_id = tpati.tpati_id
                                 LEFT OUTER JOIN tb_usuario usr
                                    ON ati.usr_id = usr.usr_id
                                 LEFT OUTER JOIN tb_usuario pri        
                                    ON ati.usr_id_prioridade = pri.usr_id
                                 LEFT OUTER JOIN tb_tipo_atendimento tpate
                                        ON ati.tpate_id = tpate.tpate_id
                                 WHERE 
                                        ativ_data_termino IS NOT NULL
                                        AND ativ_equipe = 1
                                 ORDER BY 
                                        ati.ativ_data_termino,
                                        ati.ativ_hora_termino,
                                        ati.ativ_id DESC";
                        
                        $readFechado = new Read;
                        $readFechado->FullRead($queryFechado);
                        
                        if(!$readFechado->getResult()):
                            echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe atividades em aberto.</div>';
                        else:

                            foreach($readFechado->getResult() as $ativ):
                                extract($ativ);
                                echo "<tr>";
                                if($ativ_flag_prioridade == 1):
                                   echo "<td style='background-color: #CDBE70'>{$ativ_id}</td>"; 
                                else:
                                   echo "<td>{$ativ_id}</td>"; 
                                endif;                                 
                                echo "<td>{$tpati_tipo}</td>";                                
                                $ativ_desc_limit = Check::Chars($ativ_desc,60);
                                echo "<td>{$ativ_desc_limit}</td>";
                                echo "<td>{$tpati_criticidade}</td>";
                                echo "<td>{$usr_nome}</td>";
                                echo "<td>{$cli_codigo}</td>";
                                echo "<td>{$ativ_tp_entrada} {$ativ_sac}</td>";
                                echo "<td>{$tpate_desc}</td>";
                                $ativ_data_entrada = Check::DataTela($ativ_data_entrada);
                                echo "<td>{$ativ_data_entrada}   {$ativ_hora_entrada}</td>";   
                                
                                $ativ_data_inicio = Check::DataTela($ativ_data_inicio);
                                echo "<td>{$ativ_data_inicio}   {$ativ_hora_inicio}</td>";
                                
                                $ativ_data_termino = Check::DataTela($ativ_data_termino);
                                echo "<td>{$ativ_data_termino}   {$ativ_hora_termino}</td>";
                                
                                $tpati_sla = (is_null($tpati_sla) || !isset($tpati_sla) ? '00:00:00' : $tpati_sla);
                                                                 
                                $ativ_corrente_sla = (is_null($ativ_corrente_sla) || !isset($ativ_corrente_sla) ? '00:00:00' : $ativ_corrente_sla);
                                                                
                                $checSla = Check::checkSla($tpati_sla, $ativ_corrente_sla);
                                
                                if($checSla == 1):
                                    echo "<td style='background-color: #8B2323; color: white' display='none'>{$ativ_corrente_sla}</td>";
                                else:    
                                    echo "<td>{$ativ_corrente_sla}</td>";
                                endif;
                                
                                echo "<td>";
                                    if($_SESSION['usr_nivel'] == 9):
                                        echo "<button type='button' class='btn btn-info btn-xs glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";
                                    elseif($_SESSION['usr_nivel'] == 1):
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";     
                                    else:
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";     
                                    endif;
                                echo"</td>";
                                echo "</tr>";     
                            endforeach;
                        endif;
                        
                    ?>
                    </tbody>
                </table>
            </div>    
        </div>
        <!-- FIM - Gráfico Dash -->
        
        <?php
            foreach($readAberto->getResult() as $ativ):
            extract($ativ);
        ?>    
            <!-- Modal Altera Atividade Abertas-->
            <div class="container">
                <!-- Modal -->
                <div class="modal fade" id="modalAlteraAtiv<?=$ativ_id?>" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <?php
                                    if($ativ_flag_prioridade == 1):
                                        echo "<h4 class='modal-title text-center'>PRIORIZADA - Atividade #{$ativ_id}</h4>";
                                    else:    
                                        echo "<h4 class='modal-title text-center'>Atividade #{$ativ_id}</h4>";
                                    endif;
                                ?>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="" name="atividade_update_form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativSituacaoAlt">*Situação:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="ativSituacaoAlt" name="ativ_status" required>
                                                <option value="Backlog">Backlog</option>
                                                <option value="Fazendo">Fazendo</option>
                                                <option value="Bloqueado">Bloqueado</option>
                                                <option value="Aguardando - Cliente">Aguardando - Cliente</option>
                                                <option value="Aguardando - DA">Aguardando - DA</option>
                                                <option value="Barrado">Barrado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativTpEntradaAlt">*Tipo de Entrada:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="ativTpEntradaAlt" name="ativ_tp_entrada" required>
                                                <option value="<?=$ativ_tp_entrada?>"><?=$ativ_tp_entrada?></option>
                                                <option value="SAC">SAC</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="Solicitação">Solicitação</option>
                                                <option value="Portal">Portal</option>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativTpEntradaSacAlt">SAC:</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="ativTpEntradaSacAlt" name="ativ_sac" value="<?=$ativ_sac?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataAlt">*Data Entrada:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataAlt" data-toggle="tooltip" data-placement="top" title="Data da Notificação" name="ativ_data_entrada" value="<?=$ativ_data_entrada?>" required>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraAlt">*Hora Entrada:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraAlt" data-toggle="tooltip" data-placement="top" title="Hora da Notificação" name="ativ_hora_entrada" value="<?=$ativ_hora_entrada?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativTpEntradaAlt">*Tipo de Entrada:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="ativTpEntradaAlt" name="ativ_tp_entrada" required>
                                                <option value="<?=$ativ_tp_entrada?>"><?=$ativ_tp_entrada?></option>
                                                <option value="SAC">SAC</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="Solicitação">Solicitação</option>
                                                <option value="Portal">Portal</option>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativTpEntradaSacAlt">SAC:</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="ativTpEntradaSacAlt" name="ativ_sac" value="<?=$ativ_sac?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativClienteAlt">*Cliente:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="ativClienteAlt" name="cli_id" required>
                                                <option value="<?=$cli_id?>"><?=$cli_codigo . ' - ' . $cli_nome?></option>
                                                <?php
                                                    $read->FullRead($query = "SELECT concat(cli_nome,'  -  ',cli_codigo) as cliente,cli_id FROM tb_cliente ORDER BY cli_nome");
                                                    if(!$read->getResult()):
                                                        echo "<option value=''>Não existe cliente cadastrado.</option>";
                                                    else:               
                                                        foreach($read->getResult() as $ativCliente):
                                                            extract($ativCliente);
                                                            echo "<option value='{$cli_id}'>{$cliente}</option>";
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>
                                        </div>                                  
                                        <label class="control-label col-sm-1" for="ativAnalistaAlt">Analista:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="ativAnalistaAlt" name="usr_id">
                                                <option value="<?=$usr_id?>"><?=$usr_nome?></option>
                                                <?php
                                                    $read->FullRead($query = "SELECT usr_id,usr_nome FROM tb_usuario WHERE usr_nivel NOT IN (0,1) ORDER BY usr_nome");
                                                    if(!$read->getResult()):
                                                        echo "<option value=''>Não existe Analista cadastrado.</option>";
                                                    else:  
                                                        foreach($read->getResult() as $integrante):
                                                            extract($integrante);
                                                            echo "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="<?=$ativ_id?>">Atividade:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control js_ativTpAtividadeAlt" id="<?=$ativ_id?>" name="tpati_id">
                                                <option value="<?=$tpati_id?>"><?=$tpati_tipo?></option>
                                                <option class='divider' disabled><hr></option>
                                                <?php
                                                $readAten = new Read;
                                                $readAtiv = new Read;
                                                
                                                $readAten->FullRead("SELECT tpate_id ,tpate_desc FROM tb_tipo_atendimento");
                                                                                                                                            
                                                if(!$readAten->getResult()):
                                                    echo "<option disabled>Não existe Tipo de Atividade cadastrada.</option>";
                                                else:
                                                    foreach($readAten->getResult() as $atendimento):
                                                        //extract($atendimento);
                                                        
                                                        $readAtiv->FullRead("SELECT tpati_id, tpati_tipo, tpati_criticidade FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$atendimento['tpate_id']}");
                                                        
                                                        echo "<option class='dropdown-header' value='{$atendimento['tpate_id']}' disabled>{$atendimento['tpate_desc']}</option>";
                                                        foreach($readAtiv->getResult() as $atividades):
                                                            print_r($atividades);
                                                        
                                                            echo "<option value='{$atividades['tpati_id']}'>{$atividades['tpati_tipo']}</option>";
                                                            echo "<option id='idCri{$atividades['tpati_id']}' value='{$atividades['tpati_criticidade']}' hidden></option>";    
                                                            echo "<option id='idAte_{$atividades['tpati_id']}' value='{$atendimento['tpate_id']}' hidden>{$atendimento['tpate_desc']}</option>";    
                                                        endforeach;
                                                        
                                                        echo "<option class='divider' disabled><hr></option>";
                                                        
                                                    endforeach;
                                                endif;
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativTpAtendimentoAlt">Atendimento:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control js_ativAtendimentoAlt_txt" id="ativTpAtendimentoAlt" name="tpate_id" value="<?=$tpate_desc?>" disabled>
                                            <input type="hidden" class="form-control js_ativAtendimentoAlt_val" id="ativTpAtendimentoAlt" name="tpate_id" value="<?=$tpate_id?>">
                                        </div>
                                        <label class="control-label col-sm-1" for="ativCriticAlt<?=$ativ_id?>">Complex.:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control js_ativCriticAlt" id="ativCriticAlt<?=$ativ_id?>" name="tpati_criticidade">
                                                <option value="<?=$tpati_criticidade?>"><?=$tpati_criticidade?></option>
                                                <?php
                                                    if($_SESSION['usr_nivel'] == 9):
                                                        echo "  <option value='Baixa'>Baixa</option>
                                                                <option value='Média'>Média</option>
                                                                <option value='Alta'>Alta</option>";
                                                    else:
                                                        echo "  <option value='Baixa' disabled>Baixa</option>
                                                                <option value='Média' disabled>Média</option>
                                                                <option value='Alta' disabled>Alta</option>";
                                                    endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativDescAlt">*Descrição:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="6" id="ativDescAlt" name="ativ_desc" required><?=$ativ_desc?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataInicioAlt">Data Início:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataInicioAlt" name="ativ_data_inicio" value="<?=$ativ_data_inicio?>" data-toggle="tooltip" data-placement="top" title="Data de Início">
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraInicioAlt">Hora Início:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraInicioAlt" name="ativ_hora_inicio" value="<?=$ativ_hora_inicio?>" data-toggle="tooltip" data-placement="top" title="Hora da Início">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataTerminoAlt">Data Término:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataTerminoAlt" name="ativ_data_termino" value="<?=$ativ_data_termino?>" data-toggle="tooltip" data-placement="top" title="Data da Término">
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraTerminoAlt">Hora Término:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraTerminoAlt" name="ativ_hora_termino" value="<?=$ativ_hora_termino?>" data-toggle="tooltip" data-placement="top" title="Hora da Término">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativDescAlt">Solução:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="6" id="ativDescAlt" name="ativ_solucao"><?=$ativ_solucao?></textarea>
                                        </div>
                                        <input type="hidden" id="ativIdAlt" name="ativ_id" value="<?=$ativ_id?>">
                                    </div>
                                    <div class="form-group"> 
                                        <div class="form-group">
                                            <div class="col-sm-offset-4 col-sm-5">
                                                <?php 
                                                    if($ativ_flag_prioridade == 1):
                                                        echo "<button type='button' class='btn btn-warning btn-block' data-toggle='collapse' data-target='#prioridade_{$ativ_id}'>Prioridade</button>";
                                                    else:
                                                        echo "<button type='button' class='btn btn-info btn-block' data-toggle='collapse' data-target='#prioridade_{$ativ_id}'>Priorizar</button>"; 
                                                    endif;
                                                ?>                                               
                                            </div> 
                                        </div> 
                                        <div id="prioridade_<?=$ativ_id?>" class="collapse">
                                            <div class="form-group row">
                                                <label class="control-label col-sm-2" for="ativAnalista">Solicitante:</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" id="ativAnalista" name="usr_id_prioridade">
                                                        <option value="<?=$usr_id_prioridade?>"><?=$ativ_nome_prioridade?></option>
                                                        <?php
                                                            $read->FullRead($query = "SELECT usr_id,usr_nome FROM tb_usuario ORDER BY usr_nome");
                                                            if(!$read->getResult()):
                                                                echo "<option value=''>Não existe Analista cadastrado.</option>";
                                                            else:  
                                                                foreach($read->getResult() as $solicitante):
                                                                    extract($solicitante);
                                                                    echo "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                                endforeach;
                                                            endif;
                                                        ?>
                                                    </select>
                                                </div>
                                                <label class="control-label col-sm-2" for="ativDataInicio">Data Solicitação:</label>
                                                <div class="col-sm-3">
                                                    <input type="date" class="form-control" id="ativDataPrioridade" name="ativ_data_prioridade" value="<?=$ativ_data_prioridade?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-2" for="ativDescAlt">Motivo:</label>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" rows="3" id="ativSolucao" name="ativ_motivo_prioridade"><?=$ativ_motivo_prioridade?></textarea>
                                                </div>                           
                                            </div>
                                        </div>              
                                    </div>
                                    
                                    <?php
                                        
                                        $slaAberta = new model;
                                        
                                        //$ativAbertaSla = $rstAtivAbertaSla[0]['sla'];
                                        $ativAbertaSla = $slaAberta->calcSla($ativ_id);
                                        
                                        $checSla = Check::checkSla($tpati_sla, $ativAbertaSla);
                                
                                        if($checSla == 1):
                                            echo "  <div class='form-group'>
                                                        <label class='control-label col-sm-2' for='ativ_motivo_sla'>Estouro SLA:</label>
                                                        <div class='col-sm-9'>
                                                            <textarea class='form-control' rows='6' id='ativ_motivo_sla' name='ativ_motivo_sla'>{$ativ_motivo_sla}</textarea>
                                                        </div>
                                                        <input type='hidden' id='ativIdAlt' name='ativ_id' value='{$ativ_id}'>
                                                        <input type='hidden' id='ativSla' name='ativ_corrente_sla' value='{$ativAbertaSla}'>    
                                                        <input type='hidden' id='ativSlaAtiv' name='tpati_sla' value='{$tpati_sla}'>    
                                                    </div>";
                                        else:
                                            echo "<input type='hidden' id='ativSlaAtiv' name='tpati_sla' value='{$tpati_sla}'>";    
                                        endif;
                                    ?>
                                    
                                    
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <?php
                                                if(($_SESSION['usr_id'] == $ativ['usr_id'] || $_SESSION['usr_nivel'] == 9 || empty($ativ['usr_nome'])) && $_SESSION['usr_nivel'] != 1):
                                                    echo "<button type='submit' class='btn btn-primary' name='submit' value='udt_atividades'>Atualizar</button>";
                                                endif;
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-blue js_close" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php
            endforeach;
        ?>
            
        <!-- Modal Altera Atividade Fechadas-->    
        <?php
            foreach($readFechado->getResult() as $ativ):
            extract($ativ);
        ?>    
            <!-- Modal Altera Atividade -->
            <div class="container">
                <!-- Modal -->
                <div class="modal fade" id="modalAlteraAtiv<?=$ativ_id?>" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <?php
                                    if($ativ_flag_prioridade == 1):
                                        echo "<h4 class='modal-title text-center'>PRIORIZADA - Atividade #{$ativ_id}</h4>";
                                    else:    
                                        echo "<h4 class='modal-title text-center'>Atividade #{$ativ_id}</h4>";
                                    endif;
                                ?>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="" name="atividade_update_form">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativSituacaoAlt">*Situação:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="ativSituacaoAlt" name="ativ_status" required>
                                                <option value="Backlog">Backlog</option>
                                                <option value="Fazendo">Fazendo</option>
                                                <option value="Bloqueado">Bloqueado</option>
                                                <option value="Aguardando - Cliente">Aguardando - Cliente</option>
                                                <option value="Aguardando - DA">Aguardando - DA</option>
                                                <option value="Barrado">Barrado</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataAlt">*Data Entrada:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataAlt" data-toggle="tooltip" data-placement="top" title="Data da Notificação" name="ativ_data_entrada" value="<?=$ativ_data_entrada?>" required>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraAlt">*Hora Entrada:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraAlt" data-toggle="tooltip" data-placement="top" title="Hora da Notificação" name="ativ_hora_entrada" value="<?=$ativ_hora_entrada?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativTpEntradaAlt">*Tipo de Entrada:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="ativTpEntradaAlt" name="ativ_tp_entrada" required>
                                                <option value="<?=$ativ_tp_entrada?>"><?=$ativ_tp_entrada?></option>
                                                <option value="SAC">SAC</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="Solicitação">Solicitação</option>
                                                <option value="Portal">Portal</option>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativTpEntradaSacAlt">SAC:</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="ativTpEntradaSacAlt" name="ativ_sac" value="<?=$ativ_sac?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativClienteAlt">*Cliente:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="ativClienteAlt" name="cli_id" required>
                                                <option value="<?=$cli_id?>"><?=$cli_codigo . ' - ' . $cli_nome?></option>
                                                <?php
                                                    $read->FullRead($query = "SELECT concat(cli_nome,'  -  ',cli_codigo) as cliente,cli_id FROM tb_cliente ORDER BY cli_nome");
                                                    if(!$read->getResult()):
                                                        echo "<option value=''>Não existe cliente cadastrado.</option>";
                                                    else:               
                                                        foreach($read->getResult() as $ativCliente):
                                                            extract($ativCliente);
                                                            echo "<option value='{$cli_id}'>{$cliente}</option>";
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-1" for="ativAnalistaAlt">Analista:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="ativAnalistaAlt" name="usr_id">
                                                <option value="<?=$usr_id?>"><?=$usr_nome?></option>
                                                <?php
                                                    $read->FullRead($query = "SELECT usr_id,usr_nome FROM tb_usuario WHERE usr_nivel NOT IN (0,1) ORDER BY usr_nome");
                                                    if(!$read->getResult()):
                                                        echo "<option value=''>Não existe Analista cadastrado.</option>";
                                                    else:  
                                                        foreach($read->getResult() as $integrante):
                                                            extract($integrante);
                                                            echo "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="<?=$ativ_id?>">Atividade:</label>
                                        <div class="col-sm-9">
                                            <select class="form-control js_ativTpAtividadeAlt" id="<?=$ativ_id?>" name="tpati_id">
                                                <option value="<?=$tpati_id?>"><?=$tpati_tipo?></option>
                                                <option class='divider' disabled><hr></option>
                                                <?php
                                                $readAten = new Read;
                                                $readAtiv = new Read;
                                                
                                                $readAten->FullRead("SELECT tpate_id ,tpate_desc FROM tb_tipo_atendimento");
                                                                                                                                            
                                                if(!$readAten->getResult()):
                                                    echo "<option disabled>Não existe Tipo de Atividade cadastrada.</option>";
                                                else:
                                                    foreach($readAten->getResult() as $atendimento):
                                                        //extract($atendimento);
                                                        
                                                        $readAtiv->FullRead("SELECT tpati_id, tpati_tipo, tpati_criticidade FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$atendimento['tpate_id']}");
                                                        
                                                        echo "<option class='dropdown-header' value='{$atendimento['tpate_id']}' disabled>{$atendimento['tpate_desc']}</option>";
                                                        foreach($readAtiv->getResult() as $atividades):
                                                            print_r($atividades);
                                                        
                                                            echo "<option value='{$atividades['tpati_id']}'>{$atividades['tpati_tipo']}</option>";
                                                            echo "<option id='idCri{$atividades['tpati_id']}' value='{$atividades['tpati_criticidade']}' hidden></option>";    
                                                            echo "<option id='idAte_{$atividades['tpati_id']}' value='{$atendimento['tpate_id']}' hidden>{$atendimento['tpate_desc']}</option>";    
                                                        endforeach;
                                                        
                                                        echo "<option class='divider' disabled><hr></option>";
                                                        
                                                    endforeach;
                                                endif;
                                            ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativTpAtendimentoAlt">Atendimento:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="ativTpAtendimentoAlt" name="tpate_id">
                                                <option value="<?=$tpate_id?>"><?=$tpate_desc?></option>
                                                <?php
                                                    $read->FullRead($query = "SELECT tpate_id,tpate_desc FROM tb_tipo_atendimento ORDER BY tpate_desc");
                                                    if(!$read->getResult()):
                                                        echo "<option value=''>Não existe Tipo de Atendimento cadastrado.</option>";
                                                    else:
                                                        foreach($read->getResult() as $tpAtendimento):
                                                            extract($tpAtendimento);
                                                            echo "<option value='{$tpate_id}'>{$tpate_desc}</option>";
                                                        endforeach;
                                                    endif;
                                                ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-1" for="ativCriticAlt<?=$ativ_id?>">Complex.:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control js_ativCriticAlt" id="ativCriticAlt<?=$ativ_id?>" name="tpati_criticidade">
                                                    <option value="<?=$tpati_criticidade?>"><?=$tpati_criticidade?></option>
                                                    <option value="Baixa">Baixa</option>
                                                    <option value="Média">Média</option>
                                                    <option value="Alta">Alta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativDescAlt">*Descrição:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="6" id="ativDescAlt" name="ativ_desc" required><?=$ativ_desc?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataInicioAlt">Data Início:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataInicioAlt" name="ativ_data_inicio" value="<?=$ativ_data_inicio?>" data-toggle="tooltip" data-placement="top" title="Data de Início">
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraInicioAlt">Hora Início:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraInicioAlt" name="ativ_hora_inicio" value="<?=$ativ_hora_inicio?>" data-toggle="tooltip" data-placement="top" title="Hora da Início">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataTerminoAlt">Data Término:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataTerminoAlt" name="ativ_data_termino" value="<?=$ativ_data_termino?>" data-toggle="tooltip" data-placement="top" title="Data da Término">
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraTerminoAlt">Hora Término:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraTerminoAlt" name="ativ_hora_termino" value="<?=$ativ_hora_termino?>" data-toggle="tooltip" data-placement="top" title="Hora da Término">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativDescAlt">Solução:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="6" id="ativDescAlt" name="ativ_solucao"><?=$ativ_solucao?></textarea>
                                        </div>
                                        <input type="hidden" id="ativIdAlt" name="ativ_id" value="<?=$ativ_id?>">
                                    </div>
                                    
                                    <?php 
                                        if($ativ_flag_prioridade == 1):
                                            echo "<div class='form-group row'>";
                                        else:    
                                            echo "<div class='form-group row' hidden>";
                                        endif;
                                    ?>

                                        <div class="alert alert-warning"  style="text-align: center">
                                            <strong >Prioridade</strong>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="ativAnalista">Solicitante:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="ativAnalista" name="usr_id_prioridade">
                                                    <option value="<?=$usr_id_prioridade?>"><?=$ativ_nome_prioridade?></option>
                                                    <?php
                                                        $read->FullRead($query = "SELECT usr_id,usr_nome FROM tb_usuario ORDER BY usr_nome");
                                                        if(!$read->getResult()):
                                                            echo "<option value=''>Não existe Analista cadastrado.</option>";
                                                        else:  
                                                            foreach($read->getResult() as $solicitante):
                                                                extract($solicitante);
                                                                echo "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                            <label class="control-label col-sm-2" for="ativDataInicio">Data Solicitação:</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="ativDataPrioridade" name="ativ_data_prioridade" value="<?=$ativ_data_prioridade?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="ativDescAlt">Motivo:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="3" id="ativSolucao" name="ativ_motivo_prioridade"><?=$ativ_motivo_prioridade?></textarea>
                                            </div>                           
                                        </div>
                                    </div>
                                    <?php
                                        if(!is_null($ativ_motivo_sla)):
                                            echo "  <div class='form-group'>
                                                        <label class='control-label col-sm-2' for='ativ_motivo_sla'>Estouro SLA:</label>
                                                        <div class='col-sm-9'>
                                                            <textarea class='form-control' rows='6' id='ativ_motivo_sla' name='ativ_motivo_sla'>{$ativ_motivo_sla}</textarea>
                                                        </div>
                                                        <input type='hidden' id='ativIdAlt' name='ativ_id' value='{$ativ_id}'>
                                                        <input type='hidden' id='ativSlaAlt' name='tpati_sla' value='{$tpati_sla}'>    
                                                    </div>";
                                        else:
                                            echo "<input type='hidden' id='ativSlaAlt' name='tpati_sla' value='{$tpati_sla}'>";                 
                                        endif;
                                    ?>
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <?php
                                                if($_SESSION['usr_nivel'] == 9):
                                                    echo "<button type='submit' class='btn btn-primary' name='submit' value='udt_atividades'>Atualizar</button>";
                                                endif;
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        <?php
            endforeach;
        ?>
        <!-- FIM - Modal Alterar Atividade -->
        
        <!-- Modal Colaborador -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="modalIntegrante" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro | Integrante</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="post" action="" name="integrante_create_form">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="nomeIntegrante">*Nome:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nomeIntegrante" name="usr_nome" placeholder="Digite o nome do integrante" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="emailIntegrante">*E-mail:</label>
                                    <div class="col-sm-9"> 
                                        <input type="email" class="form-control" id="emailIntegrante" name="usr_email" placeholder="Digite o email do integrante" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="equipeIntegrante">*Equipe:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="equipeIntegrante" name="usr_equipe" required>
                                            <option value="">Selecione ...</option>
                                            <option value="Integração">Integração</option>
                                            <option value="Configuração">Configuração</option>
                                            <option value="Melhorias">Melhorias</option>
                                            <option value="Suporte">Suporte</option>
                                            <option value="Projetos">Projetos</option>
                                            <option value="Sul">Sul</option>
                                        </select>
                                    </div>
                                    <label class="control-label col-sm-2" for="nivelIntegrante">Nível:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="nivelIntegrante" name="usr_nivel">
                                            <option value="0">0 - Bloqueado</option>
                                            <option value="1">1 - Visualização</option>
                                            <option value="2">2 - Usuário</option>
                                            <option value="9">9 - Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"> 
                                  <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-primary" name="submit" value="ist_integrante">Gravar</button>
                                  </div>
                                </div>
                            </form>
                            <div class="modal-footer"></div>
                            <div class="container-fluid">
                                <h4>Lista Integrantes</h4>
                                <div class="table-responsive" style="overflow: auto; height: 350px;">  
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color:#a4a4a4;">
                                                <th class="col-sm-2">Nome</th>
                                                <th class="col-sm-2">Equipe</th>
                                                <th class="col-sm-3">E-mail</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = "SELECT usr_nome,usr_equipe,usr_email FROM tb_usuario ORDER BY usr_nome";

                                            $read->FullRead($query);

                                            if(!$read->getResult()):
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe empresa cadastrada.</div>';
                                            else:

                                                foreach($read->getResult() as $usr):
                                                    extract($usr);
                                                    echo "<tr>";
                                                    echo "<td>{$usr_nome}</td>";                                
                                                    echo "<td>{$usr_equipe}</td>";                                
                                                    echo "<td>{$usr_email}</td>";                                
                                                    echo "</tr>";     
                                                endforeach;
                                            endif;

                                        ?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM - Modal Colaborador -->
        
        <!-- Modal Clientes -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="modalCliente" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro | Clientes</h4>
                        </div>
                        <div class="modal-body">
                            <?php
                                if($_SESSION['usr_nivel'] == 9):
                                    echo "<form class='form-horizontal' method='post' action='' name='cliente_create_form'>";
                                else:
                                    echo "<form class='form-horizontal' method='post' action='' name='cliente_create_form' hidden>";
                                endif;
                            ?>    
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="nomeCodigo">*Código:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nomeCodigo" name="cli_codigo" placeholder="PGMPXXXX" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="nomeCliente">*Nome:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nomeCliente" name="cli_nome" placeholder="Digite o nome do cliente" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="nomeDA">DA:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="nomeDA" name="div_id">
                                            <option value="">Selecione...</option>
                                            <?php
                                                $query = "  SELECT div_id,div_nome
                                                            FROM tb_divida_ativa
                                                            ORDER BY div_nome ";

                                                $read->FullRead($query);

                                                if(!$read->getResult()):
                                                    echo "<option disabled>Não existe empresa de DA cadastrada.</option>";
                                                else:
                                                    foreach($read->getResult() as $div):
                                                        extract($div);
                                                        echo "<option value='{$div_id}'>{$div_nome}</option>";
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">Situação:</label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cli_status" value="0" checked>Novo
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cli_status" value="1">Implantado
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cli_status" value="2">Importado Legado
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="cli_status" value="3">Suspenso
                                    </label>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-10">
                                    <?php
                                        if($_SESSION['usr_nivel'] == 9):
                                            echo "<button type='submit' class='btn btn-primary' name='submit' value='ist_cliente'>Gravar</button>";
                                        endif;
                                    ?>  
                                    </div>
                                </div>
                            </form>
                            <?php
                                if($_SESSION['usr_nivel'] == 9):
                                    echo "<div class='modal-footer'></div>";
                                else:
                                    echo "<div class='modal-footer' hidden></div>";
                                endif;
                            ?>
                            <div class="container-fluid">
                                <h4>Lista de Clientes</h4>
                                <div class="table-responsive" style="overflow: auto; height: 350px;">  
                                    <table class="table table-striped table-bordered" >
                                        <thead>
                                            <tr style="background-color:#a4a4a4;">
                                                <th class="col-sm-2">Nome</th>
                                                <th class="col-sm-2">Código</th>
                                                <th class="col-sm-2">Situação</th>
                                                <th class="col-sm-3">Dívida Ativa</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_cli">
                                        <?php
                                            $query = "SELECT 
                                                            cli_codigo, 
                                                            cli_nome, 
                                                            CASE cli_status
                                                                    WHEN 0 THEN 'Novo'
                                                                    WHEN 1 THEN 'Implantado'
                                                                    WHEN 2 THEN 'Imp. Legado'
                                                                    WHEN 3 THEN 'Suspenso'
                                                            END cli_status, 
                                                            da.div_nome 
                                                    FROM tb_cliente cli 
                                                    LEFT OUTER JOIN tb_divida_ativa da
                                                           ON cli.div_id = da.div_id
                                                    ORDER BY cli.cli_nome";

                                            $read->FullRead($query);

                                            if(!$read->getResult()):
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe empresa cadastrada.</div>';
                                            else:

                                                foreach($read->getResult() as $cli):
                                                    extract($cli);
                                                    echo "<tr>";
                                                    echo "<td>{$cli_nome}</td>";                                
                                                    echo "<td>{$cli_codigo}</td>";                                
                                                    echo "<td>{$cli_status}</td>";                                
                                                    echo "<td>{$div_nome}</td>";                                
                                                    echo "</tr>";     
                                                endforeach;
                                            endif;

                                        ?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM - Modal Clientes -->
        
        <!-- Modal DA -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="modalDivida" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro | Dívida Ativa</h4>
                        </div>
                        <div class="modal-body">
                            <?php
                                if($_SESSION['usr_nivel'] == 9):
                                    echo "<form class='form-horizontal' method='post' action='' name='divida_create_form'>";
                                else:    
                                    echo "<form class='form-horizontal' method='post' action='' name='divida_create_form' hidden>";
                                endif;
                            ?> 
                                <div class='form-group'>;
                                    <label class="control-label col-sm-2" for="nomeDA">*Nome:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nomeDA" name="div_nome" placeholder="Digite o nome da empresa">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type='submit' class='btn btn-primary' name='submit' value='ist_dividaAtiva'>Gravar</button>
                                    </div>
                                </div>
                            </form>
                            
                            <?php
                                if($_SESSION['usr_nivel'] == 9):
                                    echo "<div class='modal-footer'></div>";
                                else:    
                                    echo "<div class='modal-footer' hidden></div>";
                                endif;
                            ?>
                            
                            <div class="container-fluid">
                                <h4>Lista de Empresas DA</h4>
                                <div class="table-responsive" style="overflow: auto; height: 350px;">  
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color:#a4a4a4;">
                                                <th class="col-sm-3">Descrição</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = "SELECT * FROM tb_divida_ativa";

                                            $read->FullRead($query);

                                            if(!$read->getResult()):
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe empresa cadastrada.</div>';
                                            else:

                                                foreach($read->getResult() as $da):
                                                    extract($da);
                                                    echo "<tr>";                               
                                                    echo "<td>{$div_nome}</td>";                                
                                                    echo "</tr>";     
                                                endforeach;
                                            endif;

                                        ?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type='button' class='btn btn-blue' data-dismiss='modal'>Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM - DA -->
        
        <!-- Modal Tipo Atividade -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="modalAtividade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro | Tipo de Atividade</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="post" action="" name="tp_atividade_create_form">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="nomeAtiv">*Atividade:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nomeAtiv" name="tpati_tipo" placeholder="Digite a Atividade" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="slaAtiv">*Sla:</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control" id="slaAtiv" name="tpati_sla" placeholder="Digite hora cheia" required>
                                    </div>
                                    <label class="control-label col-sm-2" for="critAtiv">Complexidade:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="critAtiv" name="tpati_criticidade">
                                            <option value="Baixa">Baixa</option>
                                            <option value="Média">Média</option>
                                            <option value="Alta">Alta</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="equipeAtiv">Equipe:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="equipetAtiv" name="tpate_id">
                                            <option value="">Selecione ...</option>
                                            <?php
                                                $read->FullRead("SELECT tpate_id,tpate_desc FROM tb_tipo_atendimento");
                                                if(!$read->getResult()):
                                                    echo "<option disabled>Não existe Tipo de Atendimento cadastrada.</option>";
                                                else:
                                                    foreach($read->getResult() as $tpAte):
                                                        extract($tpAte);
                                                        echo "<option value='{$tpate_id}'>{$tpate_desc}</option>";
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="form-group"> 
                                  <div class="col-sm-offset-2 col-sm-10">
                                      <button type="submit" class="btn btn-primary" name="submit" value="ist_tipoAtividade">Gravar</button>
                                  </div>
                                </div>
                            </form>
                            <div class="modal-footer"></div>
                            <div class="container-fluid">
                                <h4>Lista Tipo Atividades</h4>
                                <div class="table-responsive" style="overflow: auto; height: 350px;">  
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color:#a4a4a4;">
                                                <th class="col-sm-1">Tp Atend.</th>
                                                <th class="col-sm-1">Tp Ativ.</th>
                                                <th class="col-sm-1">SLA</th>
                                                <th class="col-sm-1">Complexidade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = "  SELECT ate.tpate_desc,ati.tpati_tipo,ati.tpati_sla,ati.tpati_criticidade
                                                        FROM tb_tipo_atividades ati
                                                        INNER JOIN tb_tipo_atendimento ate
                                                                ON ati.tpate_id = ate.tpate_id";

                                            $read->FullRead($query);

                                            if(!$read->getResult()):
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe empresa cadastrada.</div>';
                                            else:

                                                foreach($read->getResult() as $ati):
                                                    extract($ati);
                                                    echo "<tr>";
                                                    echo "<td>{$tpate_desc}</td>";                                                               
                                                    echo "<td>{$tpati_tipo}</td>";                                                               
                                                    echo "<td>{$tpati_sla}</td>";                                                               
                                                    echo "<td>{$tpati_criticidade}</td>";                                                               
                                                    echo "</tr>";     
                                                endforeach;
                                            endif;

                                        ?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM - Modal Tipo Atividade -->
        
        <!-- Modal Tipo Atendimento -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="modalAtendimento" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro | Tipo de Atendimento</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="post" action="" name="tp_atendimento_create_form">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="tpAtendimento">Descrição:</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="tpAtendimento" name="tpate_desc" placeholder="Digite tipo de Atendimento">
                                    </div>
                                </div>
                                <div class="form-group"> 
                                  <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-primary" name="submit" value="ist_tipoAtendimento">Gravar</button>
                                  </div>
                                </div>
                            </form>
                            <div class="modal-footer"></div>
                            <div class="container-fluid">
                                <h4>Lista Tipo de Atendimento</h4>
                                <div class="table-responsive" style="overflow: auto; height: 350px;">  
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr style="background-color:#a4a4a4;">
                                                <th class="col-sm-3">Descrição</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $query = "SELECT tpate_desc FROM tb_tipo_atendimento";

                                            $read->FullRead($query);

                                            if(!$read->getResult()):
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe empresa cadastrada.</div>';
                                            else:

                                                foreach($read->getResult() as $ate):
                                                    extract($ate);
                                                    echo "<tr>";
                                                    echo "<td>{$tpate_desc}</td>";                                                                
                                                    echo "</tr>";     
                                                endforeach;
                                            endif;

                                        ?>
                                        </tbody>
                                    </table>
                                </div>    
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM - Modal Tipo Atendimento -->
        
        <!-- Modal Controle Atividade -->
        <div class="container">
            <!-- Modal -->
            <div class="modal fade" id="modalControleAtiv" role="dialog">
                <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cadastro | Atividades</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="post" action="" name="atividade_create_form">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="ativTpEntradaAlt">*Situação:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="ativTpEntradaAlt" name="ativ_tp_entrada" required>
                                            <option value="Backlog">Backlog</option>
                                            <option value="Fazendo">Fazendo</option>
                                            <option value="Bloqueado">Bloqueado</option>
                                            <option value="Aguardando - Cliente">Aguardando - Cliente</option>
                                            <option value="Aguardando - DA">Aguardando - DA</option>
                                            <option value="Barrado">Barrado</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="ativData">*Data Entrada:</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="ativData" data-toggle="tooltip" data-placement="top" title="Data da Notificação" name="ativ_data_entrada" required>
                                    </div>
                                    <label class="control-label col-sm-2" for="ativHora">*Hora Entrada:</label>
                                    <div class="col-sm-3">
                                        <input type="time" class="form-control" id="ativHora" data-toggle="tooltip" data-placement="top" title="Hora da Notificação" name="ativ_hora_entrada" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="ativTpEntrada">*Tipo de Entrada:</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="ativTpEntrada" name="ativ_tp_entrada" required>
                                            <option value="">Selecione ...</option>
                                            <option value="SAC">SAC</option>
                                            <option value="E-mail">E-mail</option>
                                            <option value="Solicitação">Solicitação</option>
                                            <option value="Portal">Portal</option>
                                        </select>
                                    </div>
                                    <label class="control-label col-sm-2" for="ativTpEntradaSac">SAC:</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="ativTpEntradaSac" name="ativ_sac" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="ativCliente">*Cliente:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="ativCliente" name="cli_id" required>
                                            <option value="">Selecione ...</option>
                                            <?php
                                                $read->FullRead($query = "SELECT concat(cli_nome,'  -  ',cli_codigo) as cliente,cli_id FROM tb_cliente ORDER BY cli_nome");
                                                if(!$read->getResult()):
                                                    echo "<option value=''>Não existe cliente cadastrado.</option>";
                                                else:               
                                                    foreach($read->getResult() as $ativCliente):
                                                        extract($ativCliente);
                                                        echo "<option value='{$cli_id}'>{$cliente}</option>";
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                    <label class="control-label col-sm-1" for="ativAnalista">Analista:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="ativAnalista" name="usr_id">
                                            <option value="">Selecione um Analista</option>
                                            <?php
                                                $read->FullRead($query = "SELECT usr_id,usr_nome FROM tb_usuario WHERE usr_nivel NOT IN (0,1) ORDER BY usr_nome");
                                                if(!$read->getResult()):
                                                    echo "<option value=''>Não existe Analista cadastrado.</option>";
                                                else:  
                                                    foreach($read->getResult() as $integrante):
                                                        extract($integrante);
                                                        echo "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="ativTpAtividade">*Atividade:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control js_ativTpAtividade" id="ativTpAtividade" name="tpati_id" required>
                                            <option value="">Selecione ...</option>
                                            <option class='divider' disabled><hr></option>
                                            <?php
                                                $readAten = new Read;
                                                $readAtiv = new Read;
                                                
                                                $readAten->FullRead("SELECT tpate_id ,tpate_desc FROM tb_tipo_atendimento");
                                                                                                                                            
                                                if(!$readAten->getResult()):
                                                    echo "<option disabled>Não existe Tipo de Atividade cadastrada.</option>";
                                                else:
                                                    foreach($readAten->getResult() as $atendimento):
                                                        extract($atendimento);
                                                        $readAtiv->FullRead("SELECT tpati_id, tpati_tipo, tpati_criticidade FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$tpate_id}");
                                                        
                                                        echo "<option class='dropdown-header' value='{$tpate_id}' disabled>{$tpate_desc}</option>";
                                                        foreach($readAtiv->getResult() as $atividades):
                                                            extract($atividades);
                                                        
                                                            echo "<option value='{$tpati_id}'>{$tpati_tipo}</option>";
                                                            echo "<option id='idCri_{$tpati_id}' value='{$tpati_criticidade}' hidden>{$tpati_criticidade}</option>";    
                                                            echo "<option id='idAte_{$tpati_id}' value='{$tpate_id}' hidden>{$tpate_desc}</option>";    
                                                        endforeach;
                                                        
                                                        echo "<option class='divider' disabled><hr></option>";
                                                        
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="ativTpAtendimento">*Atendimento:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control js_ativAtendimento_txt" id="ativTpAtendimento" name="tpate_id" disabled>
                                        <input type="hidden" class="form-control js_ativAtendimento_val" id="ativTpAtendimento" name="tpate_id">
                                    </div>
                                    <label class="control-label col-sm-1" for="ativCriticSelect">Complex.:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control js_ativCriticSelect" id="ativCriticSelect" name="tpati_criticidade">
                                            <option value=""></option>
                                            <?php
                                                if($_SESSION['usr_nivel'] == 9):
                                                    echo "  <option value='Baixa'>Baixa</option>
                                                            <option value='Média'>Média</option>
                                                            <option value='Alta'>Alta</option>";
                                                else:
                                                    echo "  <option value='Baixa' disabled>Baixa</option>
                                                            <option value='Média' disabled>Média</option>
                                                            <option value='Alta' disabled>Alta</option>";
                                                endif;
                                            ?>
                                        </select>
                                        <input type="hidden" class="form-control" id="ativCriticSelectHidden" name="tpati_criticidade">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="ativDesc">*Descrição:</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="6" id="ativDesc" name="ativ_desc" required></textarea>
                                    </div>
                                </div>    
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="ativDataInicio">Data Início:</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="ativDataInicio" name="ativ_data_inicio" data-toggle="tooltip" data-placement="top" title="Data de Início">
                                    </div>
                                    <label class="control-label col-sm-2" for="ativHoraInicio">Hora Início:</label>
                                    <div class="col-sm-3">
                                        <input type="time" class="form-control" id="ativHoraInicio" name="ativ_hora_inicio" data-toggle="tooltip" data-placement="top" title="Hora da Início">
                                    </div>
                                </div>
                                <!--
                                <div class="form-group row">
                                    <label class="control-label col-sm-2" for="ativDataTermino">Data Término:</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="ativDataTermino" name="ativ_data_termino" data-toggle="tooltip" data-placement="top" title="Data da Término">
                                    </div>
                                    <label class="control-label col-sm-2" for="ativHoraTermino">Hora Término:</label>
                                    <div class="col-sm-3">
                                        <input type="time" class="form-control" id="ativHoraTermino" name="ativ_hora_termino" data-toggle="tooltip" data-placement="top" title="Hora da Término">
                                    </div>
                                </div>
                                -->
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="ativDescAlt">Solução:</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" rows="6" id="ativSolucao" name="ativ_solucao"></textarea>
                                    </div>                           
                                </div>
                                   
                                <div class="form-group"> 
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-5">
                                           <button type="button" class="btn btn-info btn-block" data-toggle="collapse" data-target="#prioridade">Priorizar</button> 
                                        </div> 
                                    </div> 
                                    <div id="prioridade" class="collapse">
                                        <div class="form-group row">
                                            <label class="control-label col-sm-2" for="ativAnalista">Solicitante:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="ativAnalista" name="usr_id_prioridade">
                                                    <option value="">Selecione Solicitante</option>
                                                    <?php
                                                        $read->FullRead($query = "SELECT usr_id,usr_nome FROM tb_usuario ORDER BY usr_nome");
                                                        if(!$read->getResult()):
                                                            echo "<option value=''>Não existe Analista cadastrado.</option>";
                                                        else:  
                                                            foreach($read->getResult() as $solicitante):
                                                                extract($solicitante);
                                                                echo "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </div>
                                            <label class="control-label col-sm-2" for="ativDataInicio">Data Solicitação:</label>
                                            <div class="col-sm-3">
                                                <input type="date" class="form-control" id="ativDataPrioridade" name="ativ_data_prioridade" data-toggle="tooltip" data-placement="top" title="Solicitação Prioridade">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="ativDescAlt">Motivo:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="3" id="ativSolucao" name="ativ_motivo_prioridade"></textarea>
                                            </div>                           
                                        </div>
                                    </div>              
                                </div>
                                <div class="form-group row"> 
                                  <div class="col-sm-offset-2 col-sm-1">
                                      <button type="submit" class="btn btn-primary js_btn_ist_atividade" name="submit" value="ist_atividade">Gravar</button>
                                  </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-blue" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM - Modal Controle Atividade -->
 
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>

