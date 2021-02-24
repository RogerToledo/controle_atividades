<?php

/**
 * Modal Cadastro de Nova Atividade
 *
 * @author roger.toledo
 */

require "_app/Helpers/Check.class.php";

class cadastro {
    
    private $Data;

    function nova_atividade(){
               
        $html = "<div class='modal-body'>
            <form class='form-horizontal' method='post' action='' name='atividade_create_form'>
                <div class='form-group row'>
                    <label class='control-label col-sm-2' for='ativData'>*Data Entrada:</label>
                    <div class='col-sm-3'>
                        <input type='date' class='form-control' id='ativData' data-toggle='tooltip' data-placement='top' title='Data da Notificação' name='ativ_data_entrada' required>
                    </div>
                    <label class='control-label col-sm-2' for='ativHora'>*Hora Entrada:</label>
                    <div class='col-sm-3'>
                        <input type='time' class='form-control' id='ativHora' data-toggle='tooltip' data-placement='top' title='Hora da Notificação' name='ativ_hora_entrada' required>
                    </div>
                </div>
                <div class='form-group row'>
                    <label class='control-label col-sm-2' for='ativTpEntrada'>*Tipo de Entrada:</label>
                    <div class='col-sm-3'>
                        <select class='form-control' id='ativTpEntrada' name='ativ_tp_entrada' required>
                            <option value=''>Selecione ...</option>
                            <option value='SAC'>SAC</option>
                            <option value='E-mail'>E-mail</option>
                            <option value='Solicitação'>Solicitação</option>
                            <option value='Portal'>Portal</option>
                        </select>
                    </div>
                    <label class='control-label col-sm-2' for='ativTpEntradaSac'>SAC:</label>
                    <div class='col-sm-3'>
                        <input type='text' class='form-control' id='ativTpEntradaSac' name='ativ_sac' disabled>
                    </div>
                </div>
                <div class='form-group row'>
                    <label class='control-label col-sm-2' for='ativCliente'>*Cliente:</label>
                    <div class='col-sm-4'>
                        <select class='form-control' id='ativCliente' name='cli_id' required>
                            <option value=''>Selecione ...</option>";
                                
                                $read = new Read;
                                $read->FullRead("SELECT concat(cli_nome,'  -  ',cli_codigo) as cliente,cli_id FROM tb_cliente ORDER BY cli_nome");
                                if(!$read->getResult()):
                                    $html .= "<option value=''>Não existe cliente cadastrado.</option>";
                                else:               
                                    foreach($read->getResult() as $ativCliente):
                                        extract($ativCliente);
                                        $html .= "<option value='{$cli_id}'>{$cliente}</option>";
                                    endforeach;
                                endif;
                                //unset($read);
                            
                        $html .= "</select>
                    </div>
                    <label class='control-label col-sm-1' for='ativAnalista'>Analista:</label>
                    <div class='col-sm-4'>
                        <select class='form-control' id='ativAnalista' name='usr_id'>
                            <option value=''>Selecione um Analista</option>";
                            
                                $read->FullRead("SELECT usr_id,usr_nome FROM tb_usuario WHERE SUBSTRING(usr_sist,1,1) = '1' ORDER BY usr_nome");
                                if(!$read->getResult()):
                                    $html .= "<option value=''>Não existe Analista cadastrado.</option>";
                                else:  
                                    foreach($read->getResult() as $integrante):
                                        extract($integrante);
                                        $html .= "<option value='{$usr_id}'>{$usr_nome}</option>";
                                    endforeach;
                                endif;
                        $html .= "</select>";
                        $html .= "
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2' for='ativTpAtividade'>*Atividade:</label>
                    <div class='col-sm-9'>
                        <select class='form-control js_ativTpAtividade' id='ativTpAtividade' name='tpati_id' required>
                            <option value=''>Selecione ...</option>
                            <option class='divider' disabled><hr></option>";
                            
                                $readAten = new Read;
                                $readAtiv = new Read;

                                $readAten->FullRead("SELECT tpate_id ,tpate_desc FROM tb_tipo_atendimento");

                                if(!$readAten->getResult()):
                                    $html .= "<option disabled>Não existe Tipo de Atividade cadastrada.</option>";
                                else:
                                    foreach($readAten->getResult() as $atendimento):
                                        extract($atendimento);
                                        $readAtiv->FullRead("SELECT tpati_id, tpati_tipo, tpati_criticidade FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$tpate_id}");

                                        $html .= "<option class='dropdown-header' value='{$tpate_id}' disabled>{$tpate_desc}</option>";
                                        foreach($readAtiv->getResult() as $atividades):
                                            extract($atividades);

                                            $html .= "<option value='{$tpati_id}'>{$tpati_tipo}</option>";
                                            $html .= "<option id='idCri_{$tpati_id}' value='{$tpati_criticidade}' hidden>{$tpati_criticidade}</option>";    
                                            $html .= "<option id='idAte_{$tpati_id}' value='{$tpate_id}' hidden>{$tpate_desc}</option>";    
                                        endforeach;

                                        $html .= "<option class='divider' disabled><hr></option>";

                                    endforeach;
                                endif;
                            
                        $html .= "</select>
                    </div>
                </div>
                <div class='form-group row'>
                    <label class='control-label col-sm-2' for='ativTpAtendimento'>*Atendimento:</label>
                    <div class='col-sm-4'>
                        <input type='text' class='form-control js_ativAtendimento_txt' id='ativTpAtendimento' name='tpate_id' disabled>
                        <input type='hidden' class='form-control js_ativAtendimento_val' id='ativTpAtendimento' name='tpate_id'>
                    </div>
                    <label class='control-label col-sm-1' for='ativCriticSelect'>Complex.:</label>
                    <div class='col-sm-4'>
                        <select class='form-control js_ativCriticSelect' id='ativCriticSelect' name='tpati_criticidade'>
                            <option value=''></option>";
                            
                                if($_SESSION['usr_sist_1'] == 9):
                                    $html .=  "<option value='Baixa'>Baixa</option>";
                                    $html .=  "<option value='Média'>Média</option>";
                                    $html .=  "<option value='Alta'>Alta</option>";
                                else:
                                    $html .=  "<option value='Baixa' disabled>Baixa</option>";
                                    $html .=  "<option value='Média' disabled>Média</option>";
                                    $html .=  "<option value='Alta' disabled>Alta</option>";
                                endif;
                            
                        $html .= "</select>
                        <input type='hidden' class='form-control' id='ativCriticSelectHidden' name='tpati_criticidade'>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-sm-2' for='ativDesc'>*Descrição:</label>
                    <div class='col-sm-9'>
                        <textarea class='form-control' rows='6' id='ativDesc' name='ativ_desc' required></textarea>
                    </div>
                </div>    
                <div class='form-group row'>
                    <label class='control-label col-sm-2' for='ativDataInicio'>Data Início:</label>
                    <div class='col-sm-3'>
                        <input type='date' class='form-control' id='ativDataInicio' name='ativ_data_inicio' data-toggle='tooltip' data-placement='top' title='Data de Início'>
                    </div>
                    <label class='control-label col-sm-2' for='ativHoraInicio'>Hora Início:</label>
                    <div class='col-sm-3'>
                        <input type='time' class='form-control' id='ativHoraInicio' name='ativ_hora_inicio' data-toggle='tooltip' data-placement='top' title='Hora da Início'>
                    </div>
                </div>
                <!--
                <div class='form-group row'>
                    <label class='control-label col-sm-2' for='ativDataTermino'>Data Término:</label>
                    <div class='col-sm-3'>
                        <input type='date' class='form-control' id='ativDataTermino' name='ativ_data_termino' data-toggle='tooltip' data-placement='top' title='Data da Término'>
                    </div>
                    <label class='control-label col-sm-2' for='ativHoraTermino'>Hora Término:</label>
                    <div class='col-sm-3'>
                        <input type='time' class='form-control' id='ativHoraTermino' name='ativ_hora_termino' data-toggle='tooltip' data-placement='top' title='Hora da Término'>
                    </div>
                </div>
                -->
                <div class='form-group'>
                    <label class='control-label col-sm-2' for='ativDescAlt'>Solução:</label>
                    <div class='col-sm-9'>
                        <textarea class='form-control' rows='6' id='ativSolucao' name='ativ_solucao'></textarea>
                    </div>                           
                </div>

                <div class='form-group'> 
                    <div class='form-group'>
                        <div class='col-sm-offset-4 col-sm-5'>
                           <button type='button' class='btn btn-info btn-block' data-toggle='collapse' data-target='#prioridade'>Priorizar</button> 
                        </div> 
                    </div> 
                    <div id='prioridade' class='collapse'>
                        <div class='form-group row'>
                            <label class='control-label col-sm-2' for='ativAnalista'>Solicitante:</label>
                            <div class='col-sm-4'>
                                <select class='form-control' id='ativAnalista' name='usr_id_prioridade'>
                                    <option value=''>Selecione Solicitante</option>";
                                    
                                        $read->FullRead($query = 'SELECT usr_id,usr_nome FROM tb_usuario ORDER BY usr_nome');
                                        if(!$read->getResult()):
                                            $html .= "<option value=''>Não existe Analista cadastrado.</option>";
                                        else:  
                                            foreach($read->getResult() as $solicitante):
                                                extract($solicitante);
                                                $html .= "<option value='{$usr_id}'>{$usr_nome}</option>";
                                            endforeach;
                                        endif;
                                    
                                $html .= "</select>
                            </div>
                            <label class='control-label col-sm-2' for='ativDataInicio'>Data Solicitação:</label>
                            <div class='col-sm-3'>
                                <input type='date' class='form-control' id='ativDataPrioridade' name='ativ_data_prioridade' data-toggle='tooltip' data-placement='top' title='Solicitação Prioridade'>
                            </div>
                        </div>
                        <div class='form-group'>
                            <label class='control-label col-sm-2' for='ativDescAlt'>Motivo:</label>
                            <div class='col-sm-9'>
                                <textarea class='form-control' rows='3' id='ativSolucao' name='ativ_motivo_prioridade'></textarea>
                            </div>                           
                        </div>
                    </div>              
                </div>
                <div class='form-group row'> 
                  <div class='col-sm-offset-2 col-sm-1'>
                      <button type='submit' class='btn btn-primary js_btn_ist_atividade' name='submit' value='ist_atividade'>Gravar</button>
                  </div>
                </div>
            </form>
        </div>";
                                
        //echo $html;        
        echo $html;                        
    } 
    
    function altera_atividade($data){
        $this->Data = $data;
        //var_dump($this->Data['tpati_sla']);
        extract($this->Data);
        $read = new Read;
        
        $altera = "<!-- Modal -->
                <div class='modal fade' id='modalAlteraAtiv{$ativ_id}' role='dialog'>
                    <div class='modal-dialog modal-lg'>
                        <!-- Modal content-->
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <button type='button' class='close' data-dismiss='modal'>&times;</button>";
                                
                                    if($ativ_flag_prioridade == 1):
                                        $altera .= "<h4 class='modal-title text-center'>PRIORIZADA - Atividade #{$ativ_id}</h4>";
                                    else:    
                                        $altera .= "<h4 class='modal-title text-center'>Atividade #{$ativ_id}</h4>";
                                    endif;
                                
                $altera .= "</div>
                            <div class='modal-body'>
                                <form class='form-horizontal' method='post' action='' name='atividade_update_form'>
                                    <div class='form-group row'>
                                        <label class='control-label col-sm-2' for='ativDataAlt'>*Data Entrada:</label>
                                        <div class='col-sm-3'>
                                            <input type='date' class='form-control' id='ativDataAlt' data-toggle='tooltip' data-placement='top' title='Data da Notificação' name='ativ_data_entrada' value='{$ativ_data_entrada}' required>
                                        </div>
                                        <label class='control-label col-sm-2' for='ativHoraAlt'>*Hora Entrada:</label>
                                        <div class='col-sm-3'>
                                            <input type='time' class='form-control' id='ativHoraAlt' data-toggle='tooltip' data-placement='top' title='Hora da Notificação' name='ativ_hora_entrada' value='{$ativ_hora_entrada}' required>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='control-label col-sm-2' for='ativTpEntradaAlt'>*Tipo de Entrada:</label>
                                        <div class='col-sm-3'>
                                            <select class='form-control' id='ativTpEntradaAlt' name='ativ_tp_entrada' required>
                                                <option value='{$ativ_tp_entrada}'>{$ativ_tp_entrada}</option>
                                                <option value='SAC'>SAC</option>
                                                <option value='E-mail'>E-mail</option>
                                                <option value='Solicitação'>Solicitação</option>
                                                <option value='Portal'>Portal</option>
                                            </select>
                                        </div>
                                        <label class='control-label col-sm-2' for='ativTpEntradaSacAlt'>SAC:</label>
                                        <div class='col-sm-3'>
                                            <input type='text' class='form-control' id='ativTpEntradaSacAlt' name='ativ_sac' value='{$ativ_sac}'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='control-label col-sm-2' for='ativClienteAlt'>*Cliente:</label>
                                        <div class='col-sm-4'>
                                            <select class='form-control' id='ativClienteAlt' name='cli_id' required>
                                                <option value='{$cli_id}'>{$cli_codigo} - {$cli_nome}</option>";
                                                
                                                    $read->FullRead("SELECT concat(cli_nome,'  -  ',cli_codigo) as cliente,cli_id FROM tb_cliente ORDER BY cli_nome");
                                                    if(!$read->getResult()):
                                                        $altera .= "<option value=''>Não existe cliente cadastrado.</option>";
                                                    else:               
                                                        foreach($read->getResult() as $ativCliente):
                                                            extract($ativCliente);
                                                            $altera .= "<option value='{$cli_id}'>{$cliente}</option>";
                                                        endforeach;
                                                    endif;
                                                
                                $altera .= "</select>
                                        </div>                                  
                                        <label class='control-label col-sm-1' for='ativAnalistaAlt'>Analista:</label>
                                        <div class='col-sm-4'>
                                            <select class='form-control' id='ativAnalistaAlt' name='usr_id'>
                                                <option value='{$usr_id}'>{$usr_nome}</option>";
                                                
                                                    $read->FullRead("SELECT usr_id,usr_nome FROM tb_usuario WHERE SUBSTRING(usr_sist,1,1) = '1' ORDER BY usr_nome");
                                                    if(!$read->getResult()):
                                                        $altera .= "<option value=''>Não existe Analista cadastrado.</option>";
                                                    else:  
                                                        foreach($read->getResult() as $integrante):
                                                            extract($integrante);
                                                            $altera .= "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                        endforeach;
                                                    endif;
                                                
                                            $altera .= "</select>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='control-label col-sm-2' for='{$ativ_id}'>Atividade:</label>
                                        <div class='col-sm-9'>
                                            <select class='form-control js_ativTpAtividadeAlt' id='{$ativ_id}' name='tpati_id'>
                                                <option value='{$tpati_id}'>{$tpati_tipo}</option>
                                                <option class='divider' disabled><hr></option>";
                                                
                                                $readAten = new Read;
                                                $readAtiv = new Read;
                                                
                                                $readAten->FullRead("SELECT tpate_id ,tpate_desc FROM tb_tipo_atendimento");
                                                                                                                                            
                                                if(!$readAten->getResult()):
                                                    $altera .= "<option disabled>Não existe Tipo de Atividade cadastrada.</option>";
                                                else:
                                                    foreach($readAten->getResult() as $atendimento):
                                                        extract($atendimento);
                                                        $altera .= "<option class='dropdown-header' value='{$tpate_id}' disabled>{$tpate_desc}</option>";    
                                                    
                                                        $readAtiv->FullRead("SELECT tpati_id, tpati_tipo, tpati_criticidade FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$tpate_id}");
                                                        
                                                        foreach($readAtiv->getResult() as $atividades):
                                                            extract($atividades);
                                                        
                                                            $altera .= "<option value='{$tpati_id}'>{$tpati_tipo}</option>
                                                                        <option id='idCri{$tpati_id}' value='{$tpati_criticidade}' hidden></option>    
                                                                        <option id='idAte_{$tpati_id}' value='{$tpate_id}' hidden>{$tpate_desc}</option>";    
                                                        endforeach;
                                                        
                                                        $altera .= "<option class='divider' disabled><hr></option>";
                                                        
                                                    endforeach;
                                                endif;
                                $altera .= "</select>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='control-label col-sm-2' for='ativTpAtendimentoAlt'>Atendimento:</label>
                                        <div class='col-sm-4'>
                                            <input type='text' class='form-control js_ativAtendimentoAlt_txt' id='ativTpAtendimentoAlt' name='tpate_id' value='{$tpate_desc}' disabled>
                                            <input type='hidden' class='form-control js_ativAtendimentoAlt_val' id='ativTpAtendimentoAlt' name='tpate_id' value='{$tpate_id}'>
                                        </div>
                                        <label class='control-label col-sm-1' for='ativCriticAlt{$ativ_id}'>Complex.:</label>
                                        <div class='col-sm-4'>
                                            <select class='form-control js_ativCriticAlt' id='ativCriticAlt{$ativ_id}' name='tpati_criticidade'>
                                                <option value='{$tpati_criticidade}'>{$tpati_criticidade}</option>";
                                                
                                                    if($_SESSION['usr_sist_1'] == 9):
                                                        $altera .= "<option value='Baixa'>Baixa</option>
                                                                <option value='Média'>Média</option>
                                                                <option value='Alta'>Alta</option>";
                                                    else:
                                                        $altera .= "  <option value='Baixa' disabled>Baixa</option>
                                                                <option value='Média' disabled>Média</option>
                                                                <option value='Alta' disabled>Alta</option>";
                                                    endif;
                                                
                                $altera .= "</select>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='control-label col-sm-2' for='ativDescAlt'>*Descrição:</label>
                                        <div class='col-sm-9'>
                                            <textarea class='form-control' rows='6' id='ativDescAlt' name='ativ_desc' required>{$ativ_desc}</textarea>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='control-label col-sm-2' for='ativDataInicioAlt'>Data Início:</label>
                                        <div class='col-sm-3'>
                                            <input type='date' class='form-control' id='ativDataInicioAlt' name='ativ_data_inicio' value='{$ativ_data_inicio}' data-toggle='tooltip' data-placement='top' title='Data de Início'>
                                        </div>
                                        <label class='control-label col-sm-2' for='ativHoraInicioAlt'>Hora Início:</label>
                                        <div class='col-sm-3'>
                                            <input type='time' class='form-control' id='ativHoraInicioAlt' name='ativ_hora_inicio' value='{$ativ_hora_inicio}' data-toggle='tooltip' data-placement='top' title='Hora da Início'>
                                        </div>
                                    </div>
                                    <div class='form-group row'>
                                        <label class='control-label col-sm-2' for='ativDataTerminoAlt'>Data Término:</label>
                                        <div class='col-sm-3'>
                                            <input type='date' class='form-control' id='ativDataTerminoAlt' name='ativ_data_termino' value='{$ativ_data_termino}' data-toggle='tooltip' data-placement='top' title='Data da Término'>
                                        </div>
                                        <label class='control-label col-sm-2' for='ativHoraTerminoAlt'>Hora Término:</label>
                                        <div class='col-sm-3'>
                                            <input type='time' class='form-control' id='ativHoraTerminoAlt' name='ativ_hora_termino' value='{$ativ_hora_termino}' data-toggle='tooltip' data-placement='top' title='Hora da Término'>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <label class='control-label col-sm-2' for='ativDescAlt'>Solução:</label>
                                        <div class='col-sm-9'>
                                            <textarea class='form-control' rows='6' id='ativDescAlt' name='ativ_solucao'>{$ativ_solucao}</textarea>
                                        </div>
                                        <input type='hidden' id='ativIdAlt' name='ativ_id' value='{$ativ_id}'>
                                    </div>
                                    <div class='form-group'> 
                                        <div class='form-group'>
                                            <div class='col-sm-offset-4 col-sm-5'>";
                                                 
                                                    if($ativ_flag_prioridade == 1):
                                                        $altera .= "<button type='button' class='btn btn-warning btn-block' data-toggle='collapse' data-target='#prioridade_{$ativ_id}'>Prioridade</button>";
                                                    else:
                                                        $altera .= "<button type='button' class='btn btn-info btn-block' data-toggle='collapse' data-target='#prioridade_{$ativ_id}'>Priorizar</button>"; 
                                                    endif;
                                                                                               
                                $altera .= "</div> 
                                        </div> 
                                        <div id='prioridade_{$ativ_id}' class='collapse'>
                                            <div class='form-group row'>
                                                <label class='control-label col-sm-2' for='ativAnalista'>Solicitante:</label>
                                                <div class='col-sm-4'>
                                                    <select class='form-control' id='ativAnalista' name='usr_id_prioridade'>
                                                        <option value='{$usr_id_prioridade}'>{$ativ_nome_prioridade}</option>";
                                                        
                                                            $read->FullRead($query = 'SELECT usr_id,usr_nome FROM tb_usuario ORDER BY usr_nome');
                                                            if(!$read->getResult()):
                                                                $altera .= "<option value=''>Não existe Analista cadastrado.</option>";
                                                            else:  
                                                                foreach($read->getResult() as $solicitante):
                                                                    extract($solicitante);
                                                                    $altera .= "<option value='{$usr_id}'>{$usr_nome}</option>";
                                                                endforeach;
                                                            endif;
                                                        
                                        $altera .= "</select>
                                                </div>
                                                <label class='control-label col-sm-2' for='ativDataInicio'>Data Solicitação:</label>
                                                <div class='col-sm-3'>
                                                    <input type='date' class='form-control' id='ativDataPrioridade' name='ativ_data_prioridade' value='{$ativ_data_prioridade}'>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='control-label col-sm-2' for='ativDescAlt'>Motivo:</label>
                                                <div class='col-sm-9'>
                                                    <textarea class='form-control' rows='3' id='ativSolucao' name='ativ_motivo_prioridade'>{$ativ_motivo_prioridade}</textarea>
                                                </div>                           
                                            </div>
                                        </div>              
                                    </div>";
                                    
                                        $slaAberta = new model;
                                        
                                        //$ativAbertaSla = $rstAtivAbertaSla[0]['sla'];
                                        $ativAbertaSla = $slaAberta->calcSla($ativ_id);
                                        
                                        $checSla = Check::checkSla($this->Data['tpati_sla'], $ativAbertaSla);
                                
                                        if($checSla == 1):
                                            $altera .= "  <div class='form-group'>
                                                        <label class='control-label col-sm-2' for='ativ_motivo_sla'>Estouro SLA:</label>
                                                        <div class='col-sm-9'>
                                                            <textarea class='form-control' rows='6' id='ativ_motivo_sla' name='ativ_motivo_sla'>{$ativ_motivo_sla}</textarea>
                                                        </div>
                                                        <input type='hidden' id='ativIdAlt' name='ativ_id' value='{$ativ_id}'>
                                                        <input type='hidden' id='ativSla' name='ativ_corrente_sla' value='{$ativAbertaSla}'>    
                                                        <input type='hidden' id='ativSlaAtiv' name='tpati_sla' value='{$tpati_sla}'>    
                                                    </div>";
                                        else:
                                            $altera .= "<input type='hidden' id='ativSlaAtiv' name='tpati_sla' value='{$tpati_sla}'>";    
                                        endif;
                                                                        
                        $altera .= "<div class='form-group'> 
                                        <div class='col-sm-offset-2 col-sm-10'>";
                                            
                                                if(($_SESSION['usr_id'] == $this->Data['usr_id'] || $_SESSION['usr_sist_1'] == 9 || empty($this->Data['usr_nome'])) && $_SESSION['usr_sist_1'] != 1):
                                                    $altera .= "<button type='submit' class='btn btn-primary' name='submit' value='udt_atividades'>Atualizar</button>";
                                                endif;
                            $altera .= "</div>
                                    </div>
                                </form>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-blue js_close' data-dismiss='modal'>Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>"; 
        echo $altera;
    }
}
