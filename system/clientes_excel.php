<?php
    require '../_app/Config.inc.php';

    $dtimp = date("d/m/Y \a\s H:i"); // imprimir data completa da impressão
    $dtxls = date("dmYHi");  // agora o nome do arquivo é gerado com data, hora e minuto na exportação
    $arquivo = "clientes-$dtxls.xls";

    

    // Criamos uma tabela HTML com o formato da planilha
    $html = "";
    $html .= "<table border='1'>";
    $html .= "<tr>";
    $html .= "<td colspan='14' valign='top'>";
    $html .= "<table border='0'>";
    $html .= "<tr>";
    $html .= "<td colspan='8' align='left' valign='top'>Lista de Clientes | Exportado em: $dtimp</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "</td>";
    $html .= "</tr>";
    $html .= "</table>";
    $html .= "<br>";
    $html .= "<table border='1'>";
    $html .= "<tr bgcolor='#dddddd'>";
    $html .= "<td><b>ID</b></td>";
    $html .= "<td width='60'><b>Nome</b></td>";
    $html .= "<td width='100'><b>Codigo</b></td>";
    $html .= "<td width='100'><b>Situacao</b></td>";
    $html .= "<td width='55'><b>Divida ativa</b></td>";
    $html .= "<td width='100'><b>Ultima alteracao</b></td>";
    $html .= "</tr>";

    // ***x***
    $read = new Read;
    
    $query = "SELECT
                        cli.cli_id,
                        cli.cli_nome,
                        cli.cli_codigo,
                        CASE cli.cli_status
                                WHEN 0 THEN 'Novo'
                                WHEN 1 THEN 'Implantado'
                                WHEN 2 THEN 'Importado Legado'
                                WHEN 3 THEN 'Suspenso'
                        END as cli_status,
                        da.div_nome,
                        cli.cli_log
                FROM
                        tb_cliente cli
                LEFT OUTER JOIN tb_divida_ativa da
                        ON cli.div_id = da.div_id
                ORDER BY 
                        cli.cli_nome";
    
    $read->FullRead($query);
    
    if(!$read->getResult()):
            echo '<div class="alert alert-warnig alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a><strong>Retorno:</strong> Não existe registro.</div>';
        else:
            
            foreach($read->getResult() as $cli):
                extract($cli);
                $html .= "<tr>";
                $html .= "<td>{$cli_id}</td>";  
                
                $cli_nome = Check::fixCaracter($cli_nome);
                $html .= "<td>{$cli_nome}</td>";                                
                
                $cli_codigo = Check::fixCaracter($cli_codigo);
                $html .= "<td>{$cli_codigo}</td>";
                
                $cli_status = Check::fixCaracter($cli_status);
                $html .= "<td>{$cli_status}</td>";
                
                $div_nome = Check::fixCaracter($div_nome);
                $html .= "<td>{$div_nome}</td>";
                
                $html .= "<td>{$cli_log}</td>";

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
