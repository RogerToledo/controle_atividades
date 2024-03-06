<?php
//ini_set("display_errors",1);
//ini_set("display_startup_erros",1);
//error_reporting(E_ALL);

    require "./_app/Config.inc.php";
    require "./views/navbar.class.php";
    require "./system/play.class.php";
    require "./system/model.class.php";
    require "./system/cadastro.class.php";
    
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
        
        <title>Integração</title>
               
    </head>
    
    <body>
        <!-- Barra de Navegação -->
        <?php
            $navBar = new navBar;
            $navBar->showNavbar(1);
        ?>
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
                            $insert = new model;
                            $insert->ist_atividade($Data);

                            echo $insert->getResult();
                        endif;
                        
                        break;
                    
                    case 'udt_status':
                        if(!Check::checkConn()):
                            echo '<div class="alert alert-danger alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Falha na Conexão:</strong> Verifique a conexão com a internet e tente novamente.</div>';
                            
                        else: 
                            $update = new play;
                            $update->alteraStatus($Data);
                            
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
            <h2>Integração <small> Atividades Abertas</small></h2>
            <div class="btn-group" style="padding-bottom: 15px;">
                <a class="btn btn-default" href="integracao_fechadas.php">Encerradas</a>
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
                            <th class="col-sm-1" >Esforço</th>
                            <th class="col-sm-1"></th>
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
                                
                                $esf = new Play;
                                echo "<td>{$esf->somaTempo($ativ_id)}</td>";
                                                              
                                echo "<td>";
                                
                                $readPause = new Read;
                                $readPause->FullRead("SELECT pla_tipo from tb_play where ativ_id = :id order by pla_id desc limit 1","id={$ativ_id}");
                                $pause = $readPause->getResult();
                                $pause = ((empty($pause) || is_null($pause)) ? 0 : $readPause->getResult()[0]['pla_tipo']);
                                //var_dump($pause);
                                if($_SESSION['usr_id'] == $usr_id):
                                    
                                    echo"<form action='' method='post' name='status_update_form'>";
                                    echo"<input type='hidden' name='usr_id' value='{$usr_id}'>";
                                    echo"<input type='hidden' name='ativ_id' value='{$ativ_id}'>";

                                    if($pause == 0):   
                                        echo"<input type='hidden' name='pla_tipo' value=1>";
                                        echo "<button type='submit' class='btn btn-danger btn-xs glyphicon glyphicon-play' name='submit' value='udt_status'></button>";   
                                    else:
                                        echo"<input type='hidden' name='pla_tipo' value=0>";
                                        echo "<button type='submit' class='btn btn-success btn-xs glyphicon glyphicon-pause' name='submit'value='udt_status'></button>";
                                    endif;
                                    echo"</form>"; 
                                else:
                                    if($pause == 0):   
                                        echo "<button type='button' class='btn btn-xs glyphicon glyphicon-play' disabled></button>";   
                                    else:
                                        echo "<button type='button' class='btn btn-xs glyphicon glyphicon-pause' disabled></button>";
                                    endif;
                                endif;
                                echo "</td>";
                                
                                echo "<td>";
                                    if($_SESSION['usr_sist_1'] == 1):
                                        echo "<button type='button' class='btn btn-warning btn-xs glyphicon glyphicon-file' data-toggle='modal' data-target='#modalAlteraAtiv{$ativ_id}' name='udt_atividade'></button>";     
                                    elseif($_SESSION['usr_id'] == $usr_id || $_SESSION['usr_sist_1'] == 9 || empty($usr_nome)):
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
        
        <!-- Modal Altera Atividade Abertas-->
        <?php
        //var_dump($readAberto->getResult());
            foreach($readAberto->getResult() as $ativ):
            //extract($ativ);
            $alterar = new cadastro;
            $alterar->altera_atividade($ativ);
            
            endforeach;
        ?>
        <!-- FIM Modal Altera Atividade Abertas-->    
        
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
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Dívida Ativa:</strong> | Não existe empresa cadastrada.</div>';
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
                                if($_SESSION['usr_sist_1'] == 9):
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
                                        if($_SESSION['usr_sist_1'] == 9):
                                            echo "<button type='submit' class='btn btn-primary' name='submit' value='ist_cliente'>Gravar</button>";
                                        endif;
                                    ?>  
                                    </div>
                                </div>
                            </form>
                            <?php
                                if($_SESSION['usr_sist_1'] == 9):
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
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Dívida Ativa:</strong> | Não existe empresa cadastrada.</div>';
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
                                if($_SESSION['usr_sist_1'] == 9):
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
                                if($_SESSION['usr_sist_1'] == 9):
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
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Dívida Ativa:</strong> | Não existe empresa cadastrada.</div>';
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
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Dívida Ativa:</strong> | Não existe empresa cadastrada.</div>';
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
                                            $query = "SELECT tpate_desc FROM tb_tipo_atendimento";

                                            $read->FullRead($query);

                                            if(!$read->getResult()):
                                                echo '<div class="alert alert-info alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Dívida Ativa:</strong> | Não existe empresa cadastrada.</div>';
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
                        <?php
                            $novo = new cadastro;
                            $cadastro_novo = $novo->nova_atividade();
                         ?>        
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

