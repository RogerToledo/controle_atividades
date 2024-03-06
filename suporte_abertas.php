<?php
    ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);
    
    require "./_app/Config.inc.php";
    require "./system/model_suporte.class.php";
    require "./system/Cadastro_Suporte.class.php";
        
    $read = new Read;
    
    session_start();
    
    if(!Check::logIn()):
        header("Location: index.php");       
    endif;    
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <title>Suporte</title>
               
    </head>
    
    <body>
        <!-- Barra de Navegação -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="suporte_abertas.php">Suporte</a>
                </div>
                <ul class="nav navbar-nav dropdown">
                    <?php
                        if($_SESSION['usr_sist_2'] != 1):
                            echo "<li><a href='#' data-toggle='modal' data-target='#modalControleAtiv'><span class='glyphicon glyphicon-plus-sign'></span> Nova Atividade</a></li>";
                        endif;
                    ?>
                    
                    <li class='dropdown'>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownRelatorios" hidden="hidden"><span class="glyphicon glyphicon-stats"></span> Relatórios <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownRelatorios">
                            <li><a href="system/todas_excel_suporte.php">Todas Atividades | Excel</a></li>
                            <li><a href="system/clientes_excel.php">Chamados por Clientes | Excel</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="dropdownSistema" hidden=""><span class="glyphicon glyphicon-flash"></span> Sist. <span class="caret"></span></a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownRelatorios">
                            <li><a href="integracao_abertas.php">Integração</a></li>
                        </ul>
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
            //$Data['ativ_sup_sla'] = '08:00:00';  //---> DEFINE SLA FIXO
            if(!empty($Data)):
                switch ($Data['submit']):
                    case 'ist_integrante';
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $insert = new modelSuporte;
                            $insert->ist_integrante($Data);

                            echo $insert->getResult();  
                        endif;    

                        break;
                    
                    case 'ist_atividade':
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else:                   
                            $insert = new modelSuporte;
                            $insert->ist_atividade($Data);
                            
                            echo $insert->getResult();
                        endif;
                        
                        break;
                    
                    case 'udt_status':
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $update = new modelSuporte;
                            $update->pause($Data);
                        endif;    
                    
                        break;
                    
                    case 'udt_atividades':    
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $sla = new modelSuporte;
                            //var_dump($Data);   
                            $Data['ativ_sup_sla'] = SLA_SUP;
                            $Data['ativ_sup_corrente_sla'] = $sla->calcSla($Data['ativ_sup_id'], $Data['ativ_sup_data_termino'], $Data['ativ_sup_hora_termino']); 
                            //var_dump($Data);
                            if((int)$Data['ativ_sup_corrente_sla'] <= (int)$Data['ativ_sup_sla']):
                                unset($Data['ativ_sup_motivo_sla']);
                            endif; 
                            
                            $update = new modelSuporte;
                            $update->udt_atividade($Data);
									
                            echo $update->getResult(); 
                            
                            $DataSla['ativ_sup_corrente_sla'] = $sla->calcSla($Data['ativ_sup_id']); 
                            $DataSla['ativ_sup_id'] = $Data['ativ_sup_id'];      
                            
                            $upSla = new modelSuporte;
                            $upSla->upt_sla($DataSla);
                            
                        endif;
                       
                        break;

               endswitch;
           endif;
        ?> 
        
        <!-- Gráfico Dash -->
        <div class="container-fluid">            
            <h2>Suporte <small> Atividades Abertas</small></h2>
            <div class="btn-group" style="padding-bottom: 15px;">
                <a class="btn btn-default" href="suporte_fechadas.php">Encerradas</a>
            </div>
        </div>
        <div class="container-fluid" id="ativ-abertas">
            <div class="table-responsive">  
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr style="background-color:#a4a4a4;">
                            <th style="width:2px;">#</th>
                            <th class="col-sm-4">Descrição</th>
                            <th class="col-sm-1">Severidade</th>
                            <th class="col-sm-1">Analista</th>
                            <th class="col-sm-1">Cliente</th>
                            <th class="col-sm-1">Tipo Entrada</th>
                            <th class="col-sm-1">SAC</th>
                            <th class="col-sm-1">Entrada</th>
                            <th class="col-sm-1">Início</th>
                            <th class="col-sm-1" >Tempo</th>
                            <th style="width:2px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $queryAberto = "SELECT
                                        atisp.ativ_sup_id,
                                        atisp.ativ_sup_criticidade,
                                        atisp.ativ_sup_desc,
                                        usr.usr_id,
                                        usr.usr_nome,
                                        cli.cli_id,
                                        cli.cli_codigo,
                                        cli.cli_nome,
                                        atisp.ativ_sup_tp_entrada,
                                        atisp.ativ_sup_sac,
                                        atisp.ativ_sup_corrente_sla,
                                        atisp.ativ_sup_motivo_sla,
                                        atisp.ativ_sup_data_entrada,
                                        atisp.ativ_sup_hora_entrada,
                                        atisp.ativ_sup_data_inicio,
                                        atisp.ativ_sup_hora_inicio,
                                        atisp.ativ_sup_data_termino,
                                        atisp.ativ_sup_hora_termino,
                                        atisp.ativ_sup_solucao,
                                        atisp.usr_id_prioridade,
                                        pri.usr_nome AS ativ_sup_nome_prioridade,
                                        atisp.ativ_sup_data_prioridade,
                                        atisp.ativ_sup_motivo_prioridade,
                                        atisp.ativ_sup_flag_prioridade
                                 FROM tb_atividades_sup atisp
                                 INNER JOIN tb_cliente cli
                                        ON atisp.cli_id = cli.cli_id
                                 LEFT OUTER JOIN tb_usuario usr
                                        ON atisp.usr_id = usr.usr_id
                                 LEFT OUTER JOIN tb_usuario pri        
                                        ON atisp.usr_id_prioridade = pri.usr_id
                                 WHERE 
                                      ativ_sup_data_termino IS NULL 
                                 ORDER BY atisp.ativ_sup_flag_prioridade desc,atisp.ativ_sup_id;";
                        $readAberto = new Read;
                        $readAberto->FullRead($queryAberto);
                        
                        if(!$readAberto->getResult()):
                            echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>#</strong> | Não existe atividades em aberto.</div>';
                        else:

                            foreach($readAberto->getResult() as $ativAberto):
                                extract($ativAberto);
                                echo "<tr>";
                                if($ativ_sup_flag_prioridade == 1):
                                   echo "<td style='background-color: #CDBE70'>{$ativ_sup_id}</td>"; 
                                else:
                                   echo "<td>{$ativ_sup_id}</td>"; 
                                endif;                            
                                //echo "<td>{$tpati_tipo}</td>";                                
                                $ativ_sup_desc_limit = Check::Chars($ativ_sup_desc,60);
                                echo "<td>{$ativ_sup_desc_limit}</td>";
                                echo "<td>{$ativ_sup_criticidade}</td>";
                                echo "<td>{$usr_nome}</td>";
                                echo "<td>{$cli_codigo}</td>";
                                echo "<td>{$ativ_sup_tp_entrada}</td>";
                                echo "<td>{$ativ_sup_sac}</td>";
                                //echo "<td>{$tpate_desc}</td>";
                                $ativ_sup_data_entrada = Check::DataTela($ativ_sup_data_entrada);
                                echo "<td>{$ativ_sup_data_entrada}    {$ativ_sup_hora_entrada}</td>";   
                                
                                $ativ_sup_data_inicio = Check::DataTela($ativ_sup_data_inicio);
                                echo "<td>{$ativ_sup_data_inicio}   {$ativ_sup_hora_inicio}</td>";
                                                                
                                $sla = new modelSuporte;
                                $calcSla = $sla->calcSla($ativ_sup_id);
                                $ativ_sup_sla = '8:00:00';                                
                                
                                $checSla = Check::checkSla($ativ_sup_sla, $calcSla);
                                
                                if($checSla == 1):
                                    echo "<td style='background-color: #8B2323; color: white' display='none'>{$calcSla}</td>";
                                else:    
                                    echo "<td>{$calcSla}</td>";
                                endif;
                                
                                echo "<td>";
                                    if($_SESSION['usr_sist_2'] == 1):
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_sup_id}' name='udt_atividade'></button>";     
                                    elseif($_SESSION['usr_id'] == $usr_id || $_SESSION['usr_sist_2'] == 9 || empty($usr_nome)):
                                        echo "<button type='button' class='btn btn-info btn-xs glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_sup_id}' name='udt_atividade'></button>";
                                    else:
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_sup_id}' name='udt_atividade'></button>";     
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
                            <th style="width:2px;">#</th>
                            <th class="col-sm-3">Descrição</th>
                            <th class="col-sm-1">Severidade</th>
                            <th class="col-sm-1">Analista</th>
                            <th class="col-sm-1">Cliente</th>
                            <th class="col-sm-1">Tipo Entrada</th>
                            <th class="col-sm-1">SAC</th>
                            <th class="col-sm-1">Entrada</th>
                            <th class="col-sm-1">Início</th>
                            <th class="col-sm-1">Término</th>
                            <th class="col-sm-2" >Tempo</th>
                            <th style="width:2px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $queryFechado = "SELECT
                                        atisp.ativ_sup_id,
                                        atisp.ativ_sup_criticidade,
                                        atisp.ativ_sup_desc,
                                        usr.usr_id,
                                        usr.usr_nome,
                                        cli.cli_id,
                                        cli.cli_codigo,
                                        cli.cli_nome,
                                        atisp.ativ_sup_tp_entrada,
                                        atisp.ativ_sup_sac,
                                        atisp.ativ_sup_corrente_sla,
                                        atisp.ativ_sup_motivo_sla,
                                        atisp.ativ_sup_data_entrada,
                                        atisp.ativ_sup_hora_entrada,
                                        atisp.ativ_sup_data_inicio,
                                        atisp.ativ_sup_hora_inicio,
                                        atisp.ativ_sup_data_termino,
                                        atisp.ativ_sup_hora_termino,
                                        atisp.ativ_sup_solucao,
                                        atisp.usr_id_prioridade,
                                        pri.usr_nome AS ativ_nome_prioridade,
                                        atisp.ativ_sup_data_prioridade,
                                        atisp.ativ_sup_motivo_prioridade,
                                        atisp.ativ_sup_flag_prioridade
                                 FROM tb_atividades_sup atisp
                                 INNER JOIN tb_cliente cli
                                        ON atisp.cli_id = cli.cli_id
                                 LEFT OUTER JOIN tb_usuario usr
                                    ON atisp.usr_id = usr.usr_id
                                 LEFT OUTER JOIN tb_usuario pri        
                                    ON atisp.usr_id_prioridade = pri.usr_id
                                 WHERE 
                                        ativ_sup_data_termino IS NOT NULL
                                 ORDER BY atisp.ativ_sup_id DESC";
                        
                        $readFechado = new Read;
                        $readFechado->FullRead($queryFechado);
                        
                        if(!$readFechado->getResult()):
                            echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Não existe atividades em aberto.</div>';
                        else:

                            foreach($readFechado->getResult() as $ativ):
                                extract($ativ);
                                echo "<tr>";
                                if($ativ_sup_flag_prioridade == 1):
                                   echo "<td style='background-color: #CDBE70'>{$ativ_sup_id}</td>"; 
                                else:
                                   echo "<td>{$ativ_sup_id}</td>"; 
                                endif;                                         
                                $ativ_sup_desc_limit = Check::Chars($ativ_sup_desc,60);
                                echo "<td>{$ativ_sup_desc_limit}</td>";
                                echo "<td>{$ativ_sup_criticidade}</td>";
                                echo "<td>{$usr_nome}</td>";
                                echo "<td>{$cli_codigo}</td>";
                                echo "<td>{$ativ_sup_tp_entrada}</td>";
                                echo "<td>{$ativ_sup_sac}</td>";
                                
                                $ativ_sup_data_entrada = Check::DataTela($ativ_sup_data_entrada);
                                echo "<td>{$ativ_sup_data_entrada}   {$ativ_sup_hora_entrada}</td>";   
                                
                                $ativ_sup_data_inicio = Check::DataTela($ativ_sup_data_inicio);
                                echo "<td>{$ativ_sup_data_inicio}   {$ativ_sup_hora_inicio}</td>";
                                
                                $ativ_sup_data_termino = Check::DataTela($ativ_sup_data_termino);
                                echo "<td>{$ativ_sup_data_termino}   {$ativ_sup_hora_termino}</td>";
                                
                                $ativ_sup_sla = '8:00:00';
                                
                                if((int)$ativ_sup_corrente_sla > (int)$ativ_sup_sla):
                                    echo "<td style='background-color: #8B2323; color: white' display='none'>{$ativ_sup_corrente_sla}</td>";
                                else:    
                                    echo "<td>{$ativ_sup_corrente_sla}</td>";
                                endif;
                                
                                echo "<td>";
                                    if($_SESSION['usr_sist_2'] == 9):
                                        echo "<button type='button' class='btn btn-info btn-xs glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_sup_id}' name='udt_atividade'></button>";
                                    elseif($_SESSION['usr_sist_2'] == 1):
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_sup_id}' name='udt_atividade'></button>";     
                                    else:
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_sup_id}' name='udt_atividade'></button>";     
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
        
        <!-- Modal Altera Atividade Abertas-->
        <?php
            foreach($readAberto->getResult() as $ativ):
            $alterar = new Cadastro_Suporte;
            $alterar->altera_atividade($ativ);
            endforeach;
        ?>    
        <!-- FIM - Modal Altera Atividade Abertas-->
                   
        <!-- Modal Altera Atividade Fechadas-->    
        <?php
            if($readFechado->getResult()):
                foreach($readFechado->getResult() as $ativ):
                extract($ativ);      
        ?>    
            <!-- Modal Altera Atividade -->
            <div class="container">
                <!-- Modal -->
                <div class="modal fade" id="modalAlteraAtiv<?=$ativ_sup_id?>" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <?php
                                    if($ativ_sup_flag_prioridade == 1):
                                        echo "<h4 class='modal-title text-center'>PRIORIZADA - Atividade #{$ativ_sup_id}</h4>";
                                    else:    
                                        echo "<h4 class='modal-title text-center'>Atividade #{$ativ_sup_id}</h4>";
                                    endif;
                                ?>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" method="post" action="" name="atividade_update_form">
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataAlt">*Data Entrada:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataAlt" data-toggle="tooltip" data-placement="top" title="Data da Notificação" name="ativ_sup_data_entrada" value="<?=$ativ_sup_data_entrada?>" required>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraAlt">*Hora Entrada:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraAlt" data-toggle="tooltip" data-placement="top" title="Hora da Notificação" name="ativ_sup_hora_entrada" value="<?=$ativ_sup_hora_entrada?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativTpEntradaAlt">*Tipo de Entrada:</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" id="ativTpEntradaAlt" name="ativ_sup_tp_entrada" required>
                                                <option value="<?=$ativ_sup_tp_entrada?>"><?=$ativ_sup_tp_entrada?></option>
                                                <option value="SAC">SAC</option>
                                                <option value="E-mail">E-mail</option>
                                                <option value="Solicitação">Solicitação</option>
                                                <option value="Portal">Portal</option>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-2" for="ativTpEntradaSacAlt">SAC:</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="ativTpEntradaSacAlt" name="ativ_sup_sac" value="<?=$ativ_sup_sac?>">
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
                                        <label class="control-label col-sm-2" for="ativCriticAlt<?=$ativ_sup_id?>">Severidade:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control js_ativCriticAlt" id="ativCriticAlt<?=$ativ_sup_id?>" name="ativ_sup_criticidade">
                                                <option value="<?=$ativ_sup_criticidade?>"><?=$ativ_sup_criticidade?></option>
                                                <option value='Baixa'>Baixa</option>
                                                <option value='Média'>Média</option>
                                                <option value='Alta'>Alta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativDescAlt">*Descrição:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="6" id="ativDescAlt" name="ativ_sup_desc" required><?=$ativ_sup_desc?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataInicioAlt">Data Início:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataInicioAlt" name="ativ_sup_data_inicio" value="<?=$ativ_sup_data_inicio?>" data-toggle="tooltip" data-placement="top" title="Data de Início">
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraInicioAlt">Hora Início:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraInicioAlt" name="ativ_sup_hora_inicio" value="<?=$ativ_sup_hora_inicio?>" data-toggle="tooltip" data-placement="top" title="Hora da Início">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-sm-2" for="ativDataTerminoAlt">Data Término:</label>
                                        <div class="col-sm-3">
                                            <input type="date" class="form-control" id="ativDataTerminoAlt" name="ativ_sup_data_termino" value="<?=$ativ_sup_data_termino?>" data-toggle="tooltip" data-placement="top" title="Data da Término">
                                        </div>
                                        <label class="control-label col-sm-2" for="ativHoraTerminoAlt">Hora Término:</label>
                                        <div class="col-sm-3">
                                            <input type="time" class="form-control" id="ativHoraTerminoAlt" name="ativ_sup_hora_termino" value="<?=$ativ_sup_hora_termino?>" data-toggle="tooltip" data-placement="top" title="Hora da Término">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="ativDescAlt">Solução:</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" rows="6" id="ativDescAlt" name="ativ_sup_solucao"><?=$ativ_sup_solucao?></textarea>
                                        </div>
                                        <input type="hidden" id="ativIdAlt" name="ativ_sup_id" value="<?=$ativ_sup_id?>">
                                    </div>
                                    
                                    <?php 
                                        if($ativ_sup_flag_prioridade == 1):
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
                                                    <option value="<?=$usr_id_prioridade?>"><?=$ativ_sup_nome_prioridade?></option>
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
                                                <input type="date" class="form-control" id="ativDataPrioridade" name="ativ_sup_data_prioridade" value="<?=$ativ_sup_data_prioridade?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="ativDescAlt">Motivo:</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="3" id="ativSolucao" name="ativ_sup_motivo_prioridade"><?=$ativ_sup_motivo_prioridade?></textarea>
                                            </div>                           
                                        </div>
                                    </div>
                                    <?php
                                        if(!is_null($ativ_sup_motivo_sla)):
                                            echo "  <div class='form-group'>
                                                        <label class='control-label col-sm-2' for='ativ_sup_motivo_sla'>Estouro SLA:</label>
                                                        <div class='col-sm-9'>
                                                            <textarea class='form-control' rows='6' id='ativ_sup_motivo_sla' name='ativ_sup_motivo_sla'>{$ativ_sup_motivo_sla}</textarea>
                                                        </div>
                                                        <input type='hidden' id='ativIdAlt' name='ativ_sup_id' value='{$ativ_sup_id}'>
                                                        <input type='hidden' id='ativSlaAlt' name='ativ_sup_sla' value='{$ativ_sup_sla}'>    
                                                    </div>";
                                        else:
                                            echo "<input type='hidden' id='ativSlaAlt' name='ativ_sup_sla' value='{$ativ_sup_sla}'>";                 
                                        endif;
                                    ?>
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <?php
                                                if($_SESSION['usr_sist_2'] == 9):
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
            endif;
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
                        <!-- Cadastro Nova Atividade -->
                        <?php
                            $novaAtiv = new Cadastro_Suporte;
                            $novaAtiv->nova_atividade();
                        ?>
                        <!-- FIM Cadastro Nova Atividade -->
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

