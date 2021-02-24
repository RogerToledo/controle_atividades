<?php
    require '../_app/Config.inc.php';
    require './model.class.php';
    
    //ini_set('display_errors', true); error_reporting(E_ALL);
    
    date_default_timezone_set('America/Sao_Paulo');

    $dtimp = date("d/m/Y \a\s H:i"); // imprimir data completa da impressão
    $dtxls = date("dmYHi");  // agora o nome do arquivo é gerado com data, hora e minuto na exportação
    $arquivo = "todas-atividades-suporte-$dtxls.xls";

    

    // Criamos uma tabela HTML com o formato da planilha
    $html = "";
    $html .= "<table border='1'>";
    $html .= "<tr>";
    $html .= "<td colspan='14' valign='top'>";
    $html .= "<table border='0'>";
    $html .= "<tr>";
    $html .= "<td colspan='8' align='left' valign='top'>Todas as atividades | Exportado em: $dtimp</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "<br>";
    $html .= "<table border='1'>";
    $html .= "<tr bgcolor='#dddddd'>";
    $html .= "<td><b>ID</b></td>";
    $html .= "<td width='100'><b>Descricao</b></td>";
    $html .= "<td width='55'><b>Severidade</b></td>";
    $html .= "<td width='55'><b>Analista</b></td>";
    $html .= "<td width='55'><b>Codigo Cliente</b></td>";
    $html .= "<td width='55'><b>Nome Cliente</b></td>";
    $html .= "<td width='55'><b>Tipo Entrada</b></td>";
    $html .= "<td width='55'><b>SAC</b></td>";
    $html .= "<td width='55'><b>Data Entrada</b></td>";
    $html .= "<td width='55'><b>Hora Entrada</b></td>";
    $html .= "<td width='55'><b>Data Inicio</b></td>";
    $html .= "<td width='55'><b>Hora Inicio</b></td>";
    $html .= "<td width='55'><b>Data Termino</b></td>";
    $html .= "<td width='55'><b>Hora Termino</b></td>";
    $html .= "<td width='100'><b>Solucao</b></td>";
    $html .= "<td width='55'><b>Solitante Prioridade</b></td>";
    $html .= "<td width='55'><b>Data Prioridade</b></td>";
    $html .= "<td width='55'><b>Motivo Prioridade</b></td>";
    $html .= "<td width='55'><b>SLA</b></td>";
    $html .= "<td width='55'><b>SLA Total</b></td>";
    $html .= "<td width='55'><b>Tempo p/ Inicio</b></td>";
    $html .= "<td width='100'><b>Motivo Estouro SLA</b></td>";
    $html .= "<td width='100'><b>Esforco</b></td>";
    $html .= "<td width='100'><b>Ultima alteracao</b></td>";
    $html .= "</tr>";

    $read = new Read;
    
    $query = "SELECT
                    ati.ativ_id,
                    ati.ativ_desc,
                    tpati.tpati_criticidade,
                    usr.usr_nome,
                    cli.cli_codigo,
                    cli.cli_nome,
                    ativ_tp_entrada, 
                    ati.ativ_sac,
                    tpate.tpate_desc,
                    ati.ativ_data_entrada,
                    ati.ativ_hora_entrada,
                    ati.ativ_data_inicio,
                    ati.ativ_hora_inicio,
                    ati.ativ_data_termino,
                    ati.ativ_hora_termino,
                    ati.ativ_solucao,
                    pri.usr_nome as pri_nome,
                    ati.ativ_data_prioridade,
                    ati.ativ_motivo_prioridade,
                    tpati_sla,
                    ati.ativ_corrente_sla,
                    ati.ativ_motivo_sla,
                    ati.ativ_log
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
             WHERE ati.ativ_equipe = 2";
    
    $read->FullRead($query);
    
    if(!$read->getResult()):
            echo '<div class="alert alert-warnig alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Retorno:</strong> Não existe registro.</div>';
        else:
            
            foreach($read->getResult() as $ativ):
                extract($ativ);
                $html .= "<tr>";
                $html .= "<td>{$ativ_id}</td>";  
                
                $ativ_desc = Check::fixCaracter($ativ_desc);
                $html .= "<td>{$ativ_desc}</td>";
                
                $tpati_criticidade = Check::fixCaracter($tpati_criticidade); 
                $html .= "<td>{$tpati_criticidade}</td>";
                
                $usr_nome = Check::fixCaracter($usr_nome);
                $html .= "<td>{$usr_nome}</td>";
                
                $html .= "<td>{$cli_codigo}</td>";
                
                $cli_nome = Check::fixCaracter($cli_nome);
                $html .= "<td>{$cli_nome}</td>";
                
                $ativ_tp_entrada = Check::fixCaracter($ativ_tp_entrada);
                $html .= "<td>{$ativ_tp_entrada}</td>";
                
                $html .= "<td>{$ativ_sac}</td>";
                                
                $ativ_data_entrada = Check::DataTela($ativ_data_entrada);
                $html .= "<td>{$ativ_data_entrada}</td>";   
                $html .= "<td>{$ativ_hora_entrada}</td>";   

                $ativ_data_inicio = Check::DataTela($ativ_data_inicio);
                $html .= "<td>{$ativ_data_inicio}</td>";
                $html .= "<td>{$ativ_hora_inicio}</td>";
                
                $ativ_data_termino = Check::DataTela($ativ_data_termino);
                $html .= "<td>{$ativ_data_termino}</td>";
                $html .= "<td>{$ativ_hora_termino}</td>";
                
                $ativ_solucao = Check::fixCaracter($ativ_solucao);
                $html .= "<td>{$ativ_solucao}</td>";
                                
                $pri_nome = Check::fixCaracter($pri_nome);
                $html .= "<td>{$pri_nome}</td>";
                
                $ativ_data_prioridade = Check::DataTela($ativ_data_prioridade);
                $html .= "<td>{$ativ_data_prioridade}</td>";
                
                $ativ_motivo_prioridade = Check::fixCaracter($ativ_motivo_prioridade);
                $html .= "<td>{$ativ_motivo_prioridade}</td>";
                                
                $html .= "<td>{$tpati_sla}</td>";
                
                $html .= "<td>{$ativ_corrente_sla}</td>";
                
                $temp = new model;
                $tempIni = $temp->calcTempoInicio($ativ_id, $ativ_data_inicio, $ativ_hora_inicio);
                $html .= "<td>{$tempIni}</td>";
                
                $html .= "<td>{$ativ_motivo_sla}</td>";
                
                //$esf = new model;
                $esforco = $temp->calcEsforco($ativ_corrente_sla, $tempIni);
                $html .= "<td>{$esforco}</td>";
                
                $html .= "<td>{$ativ_log}</td>";

                $html .= "</tr>";     
            endforeach;
        endif;
    
    
    // ---x---

    $html .= "</table>";
    $html .= "<br>";
    
    // Configurações header para forçar o download
    //header ("Content-Type: text/html; charset=utf-8");
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$arquivo}\"" );
    header ("Content-Description: PHP Generated Data" );


    // Envia o conteúdo do arquivo
    echo $html;
    exit; 
?>
