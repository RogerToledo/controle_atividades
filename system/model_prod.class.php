<?php
    /**
     * Description of atividade
     *
     * @author roger.toledo
     */
    date_default_timezone_set('America/Sao_Paulo'); 
    class model {
        
        private $Data;
        private $User;
        private $Error;
        private $Result;
        
        /*
         * FUNÇÕES DO INTEGRANTE 
         *          
         */
        
        // INSERE INTEGRANTE
        function ist_integrante($Data) {
            
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;

                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                    
                        $this->Data['usr_pass'] = md5('123');
                    
                        $read = new Read;
                        $read->FullRead("SELECT usr_email FROM tb_usuario WHERE usr_email = :email","email={$this->Data['usr_email']}");
                        
                        if($read->getResult()):
                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Analista: </strong>{$this->Data['usr_email']} já está dadastro(a). Entre em contato com o Adm.</div>";
                        
                        else:
                            $create = new Create;
                            $create->ExeCreate('tb_usuario', $this->Data);
                            
                            if ($create->getResult()):
                                $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Analista: </strong>{$this->Data['usr_nome']} cadastrado(a) com sucesso.</div>";
                            else:    
                                
                            endif;
                        endif;
                       
                    else:
                        echo '';
                    
                    endif;
                    
                endif;

            endif;
  
            unset($this->Data);
                               
        }
        
        // UPDATE INTEGRANTE
        
        // DELETE INTEGRANTE
        
        ////----> FIM INTEGRANTE
        
        
        /*
         * FUNÇÕES DO CLIENTE 
         *          
         */
        
        // INSERE CLIENTE
        function ist_cliente($Data) {
            
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;

                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                    
                        $read = new Read;
                        $read->FullRead("SELECT cli_nome FROM tb_cliente WHERE cli_nome = :nome","nome={$this->Data['cli_nome']}");
                        
                        if($read->getResult()):
                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Cliente: </strong>{$this->Data['cli_nome']} já está dadastro(a). Entre em contato com o Adm.</div>";
                        
                        else:
                            $create = new Create;
                            $create->ExeCreate('tb_cliente', $this->Data);
                            
                            if ($create->getResult()):
                                $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Cliente: </strong>{$this->Data['cli_nome']} cadastrado(a) com sucesso.</div>";
                            else:    
                                
                            endif;
                        endif;
                       
                    else:
                        echo '';
                    
                    endif;
                    
                endif;

            endif;
  
            unset($this->Data);
                               
        }
        
        // UPDATE INTEGRANTE
        
        // DELETE INTEGRANTE
        
        ////----> FIM INTEGRANTE
        
        
        /*
         * FUNÇÕES DO DIVIDA ATIVA 
         *          
         */
        
        // INSERE DIVIDA ATIVA
        function ist_divida_ativa($Data) {
            
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;

                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                    
                        $read = new Read;
                        $read->FullRead("SELECT div_nome FROM tb_divida_ativa WHERE div_nome = :nome","nome={$this->Data['div_nome']}");
                        
                        if($read->getResult()):
                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Dívida Ativa: </strong>{$this->Data['div_nome']} já está dadastro(a). Entre em contato com o Adm.</div>";
                        
                        else:
                            $create = new Create;
                            $create->ExeCreate('tb_divida_ativa', $this->Data);
                            
                            if ($create->getResult()):
                                $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Dívida Ativa: </strong>{$this->Data['div_nome']} cadastrado(a) com sucesso.</div>";
                            else:    
                                $this->Result = "<div class='alert alert-alert alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Erro: </strong>Falha ao cadastrar.</div>";
                            endif;
                        endif;
                       
                    else:
                        echo '';
                    
                    endif;
                    
                endif;

            endif;
  
            unset($this->Data);
                               
        }
        
        // UPDATE INTEGRANTE
        
        // DELETE INTEGRANTE
        
        ////----> FIM INTEGRANTE
        
        
        /*
         * FUNÇÕES DO DIVIDA ATIVA 
         *          
         */
        
        // INSERE TIPO ATIVIDADE    
        function ist_tpAtividade($Data) {
            
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;

                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                    
                        $read = new Read;
                        $read->FullRead("SELECT tpati_tipo FROM tb_tipo_atividades WHERE tpati_tipo = :tipo","tipo={$this->Data['tpati_tipo']}");
                        
                        if($read->getResult()):
                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Tipo Atividade: </strong>{$this->Data['tpati_tipo']} já está dadastro(a). Entre em contato com o Adm.</div>";
                        
                        else:
                            $this->Data['tpati_sla'] = $this->Data['tpati_sla'].':00:00';
                            $create = new Create;
                            $create->ExeCreate('tb_tipo_atividades', $this->Data);
                            
                            if ($create->getResult()):
                                $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Tipo Atividade: </strong>{$this->Data['tpati_tipo']} cadastrado(a) com sucesso.</div>";
                            else:    
                                
                            endif;
                        endif;
                       
                    else:
                        echo '';
                    
                    endif;
                    
                endif;

            endif;
  
            unset($this->Data);
                               
        }
        
        // UPDATE TIPO ATIVIDADE 
        
        // DELETE TIPO ATIVIDADE 
        
        ////----> FIM TIPO ATIVIDADE 
        
        
        /*
         * FUNÇÕES DO DIVIDA ATIVA 
         *          
         */
        
        // INSERE TIPO ATIVIDADE    
        function ist_tpAtendimento($Data) {
            
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;

                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                    
                        $read = new Read;
                        $read->FullRead("SELECT tpate_desc FROM tb_tipo_atendimento WHERE tpate_desc = :desc","desc={$this->Data['tpate_desc']}");
                        
                        if($read->getResult()):
                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Tipo Atendimento: </strong>{$this->Data['tpate_desc']} já está dadastro(a). Entre em contato com o Adm.</div>";
                        
                        else:
                            $create = new Create;
                            $create->ExeCreate('tb_tipo_atendimento', $this->Data);
                            
                            if ($create->getResult()):
                                $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Tipo Atendimento: </strong>{$this->Data['tpate_desc']} cadastrado(a) com sucesso.</div>";
                            else:    
                                
                            endif;
                        endif;
                       
                    else:
                        echo '';
                    
                    endif;
                    
                endif;

            endif;
  
            unset($this->Data);
                               
        }
        
        // UPDATE TIPO ATIVIDADE 
        
        // DELETE TIPO ATIVIDADE 
        
        ////----> FIM TIPO ATIVIDADE
        
        
        // INSERE ATIVIDADE    
        function ist_Atividade($Data) {
            
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;

                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                        //var_dump($this->Data);
                        $this->Data['ativ_data_inicio'] = (empty($this->Data['ativ_data_inicio'])? NULL : $this->Data['ativ_data_inicio']);
                        $this->Data['ativ_data_termino'] = (empty($this->Data['ativ_data_termino'])? NULL : $this->Data['ativ_data_termino']);
                        $this->Data['ativ_data_prioridade'] = (empty($this->Data['ativ_data_prioridade'])? NULL : $this->Data['ativ_data_prioridade']);
                        $this->Data['tpate_id'] = (empty($this->Data['tpate_id'])? NULL : $this->Data['tpate_id']);
                        $this->Data['tpati_id'] = (empty($this->Data['tpati_id'])? NULL : $this->Data['tpati_id']);
                        $this->Data['usr_id'] = (empty($this->Data['usr_id'])? NULL : $this->Data['usr_id']);
                        $this->Data['usr_id_prioridade'] = (empty($this->Data['usr_id_prioridade'])? NULL : $this->Data['usr_id_prioridade']);
                        if(!empty($this->Data['ativ_data_prioridade']) || !empty($this->Data['usr_id_prioridade']) || !empty($this->Data['ativ_motivo_prioridade'])):
                            $this->Data['ativ_flag_prioridade'] = 1;
                        else:
                            $this->Data['ativ_flag_prioridade'] = 0;
                        endif;
                        
                        
                        
                        //$this->Data['ativ_status'] = 1;
                        
                        if(!is_null($this->Data['ativ_data_termino'])):
                            if(strtotime($this->Data['ativ_data_inicio']) > strtotime($this->Data['ativ_data_termino'])):
                                $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Data inválida: </strong>Data Encerramento não pode ser menor que a Data Inicio.</div>";
                            else:
                                if(empty($this->Data['ativ_solucao'])):
                                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Solução Obrigatória: </strong>Solução se torna obrigatória ao encerrar uma atividade.</div>";

                                elseif($this->Data['ativ_solucao'] == '.' || $this->Data['ativ_solucao'] == '..' || $this->Data['ativ_solucao'] == '...' || $this->Data['ativ_solucao'] == '-' || $this->Data['ativ_solucao'] == ',' || $this->Data['ativ_solucao'] == ';' ):
                                    $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Ai não né zé: </strong>Preenche a solução direito.</div>";

                                elseif(empty($this->Data['ativ_data_inicio']) || empty($this->Data['ativ_hora_inicio']) || empty($this->Data['ativ_hora_termino']) || is_null($this->Data['tpate_id']) || is_null($this->Data['tpati_id']) || is_null($this->Data['usr_id']) ):
                                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Data inválida: </strong>Ao encerrar uma atividade todas as Datas e Horas são obrigatórias.</div>";

                                else:
                                    if(strtotime($this->Data['ativ_data_inicio']) == strtotime($this->Data['ativ_data_termino'])):
                                        if(strtotime($this->Data['ativ_hora_inicio']) >= strtotime($this->Data['ativ_hora_termino'])):
                                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Hora Inválida: </strong>Hora Encerramento não pode ser menor que a Hora Entrada.</div>";

                                        else:
                                            if(!is_null($this->Data['ativ_data_prioridade']) || !empty($this->Data['usr_id_prioridade']) || !empty($this->Data['ativ_motivo_prioridade'])):
                                                if(is_null($this->Data['ativ_data_prioridade']) || empty($this->Data['usr_id_prioridade']) || empty($this->Data['ativ_motivo_prioridade'])):
                                                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Campo Obrigatório: </strong>Se um campo de Prioridade estiver preenchido, todos os demais passam a ser. </div>";
                                                endif;
                                                
                                            else: 
                                               $create = new Create;
                                                $create->ExeCreate('tb_atividades', $this->Data);

                                                if ($create->getResult()):
                                                    $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong> #{$create->getResult()} cadastrada com sucesso.</div>";
                                                else:    
                                                    $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha ao cadastrar: </strong>Atividade não foi cadastrada.</div>";
                                                endif; 
                                            endif;
                                        endif;
                                    else:

                                        $create = new Create;
                                        $create->ExeCreate('tb_atividades', $this->Data);

                                        if ($create->getResult()):
                                            $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong> #{$create->getResult()} cadastrada com sucesso.</div>";
                                        else:    
                                            $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha ao cadastrar: </strong>Atividade não foi cadastrada.</div>";
                                        endif;
                                    endif;    
                                endif;
                            endif;                               
                        else:
                            $create = new Create;
                            $create->ExeCreate('tb_atividades', $this->Data);

                            if ($create->getResult()):
                                $this->Result = "<div class='alert alert-success alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong> #{$create->getResult()} cadastrada com sucesso.</div>";
                            else:    
                                $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha ao cadastrar: </strong>Atividade não foi cadastrada.</div>";
                            endif;
                        endif;
                    else:
                        $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Erro: </strong>Sistema não conseguiu ler as informações do formulário. Tente novamente.</div>";
                    
                    endif;
                    
                endif;

            endif;
  
            unset($this->Data);
                               
        }
        
        // UPDATE ATIVIDADE 
        function udt_atividade($Data){
            $this->Data = $Data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;
            
                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                    
                        if(!empty($this->Data['ativ_data_prioridade']) || !empty($this->Data['usr_id_prioridade']) || !empty($this->Data['ativ_motivo_prioridade'])):
                            $this->Data['ativ_flag_prioridade'] = 1;
                        else:
                            $this->Data['ativ_flag_prioridade'] = 0;
                        endif;
                                          
                        if(!empty($this->Data['ativ_data_termino'])):
                            if(strtotime($this->Data['ativ_data_inicio']) > strtotime($this->Data['ativ_data_termino'])):
                                $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Data inválida: </strong>Data Encerramento não pode ser menor que a Data Inicio.</div>";
  
                            else:
                                if(empty($this->Data['ativ_solucao'])):
                                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Solução Obrigatória: </strong>Solução se torna obrigatória ao encerrar uma atividade.</div>";
                                    
                                elseif($this->Data['ativ_solucao'] == '.' || $this->Data['ativ_solucao'] == '..' || $this->Data['ativ_solucao'] == '...' || $this->Data['ativ_solucao'] == '-' || $this->Data['ativ_solucao'] == ',' || $this->Data['ativ_solucao'] == ';' ):
                                    $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Ai não né zé: </strong>Preenche a solução direito.</div>";
                                    
                                elseif(empty($this->Data['ativ_data_inicio']) || empty($this->Data['ativ_hora_inicio']) || empty($this->Data['ativ_hora_termino']) || empty($this->Data['tpate_id']) || empty($this->Data['tpati_id']) || empty($this->Data['usr_id']) ):
                                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Dados inválidos: </strong>Ao encerrar uma atividade todos os campos se tornam obrigatórios.</div>";
                                
                                elseif($this->Data['ativ_flag_prioridade'] == 1 && (empty($this->Data['ativ_data_prioridade']) || empty($this->Data['usr_id_prioridade']) || empty($this->Data['ativ_motivo_prioridade']))): 
                                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Campos Prioridade Obrigatórios: </strong>Quando chamado é priorizado, todos os campos referente Prioridade se tornam obrigatórios ao encerrar o chamado.</div>";    
                                
                                elseif((int)$this->Data['ativ_corrente_sla'] > (int)$this->Data['tpati_sla']):
                                    if(empty($this->Data['ativ_motivo_sla'])):
                                        $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>SLA Estourou: </strong>Quando SLA estoura, o preenchimento do campo Estouro SLA se torna obrigatório ao encerrar o chamado.</div>";
                                    else:
                                        unset($this->Data['tpati_sla']);
                                        $update = new Update;

                                        $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", ":id={$this->Data['ativ_id']}");

                                        if($update->getResult()):
                                            $this->Result = "<div class='alert alert-info alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong>#{$this->Data['ativ_id']} alterada com sucesso.</div>";
                                        else:
                                            $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha na Alteração: </strong>#{$this->Data['ativi_id']} não foi alterada.</div>";
                                        endif; 
                                    endif;  
                                    
                                else: 
                                    if($this->Data['ativ_tp_entrada'] != 'SAC'):
                                        $this->Data['ativ_sac'] = '';
                                    endif;
                                    
                                    if(strtotime($this->Data['ativ_data_inicio']) == strtotime($this->Data['ativ_data_termino'])):
                                        if(strtotime($this->Data['ativ_hora_inicio']) >= strtotime($this->Data['ativ_hora_termino'])):
                                            $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Hora Inválida: </strong>Hora Encerramento não pode ser menor que a Hora Entrada.</div>";
                                        
                                        else:
                                            unset($this->Data['tpati_sla']);
                                            $update = new Update;

                                            $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", ":id={$this->Data['ativ_id']}");

                                            if($update->getResult()):
                                                $this->Result = "<div class='alert alert-info alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong>#{$this->Data['ativ_id']} alterada com sucesso.</div>";
                                            else:
                                                $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha na Alteração: </strong>#{$this->Data['ativi_id']} não foi alterada.</div>";
                                            endif; 
                                            //////////////////////////////////////
                                            $update = new Update;
                                            $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", ":id={$this->Data['ativ_id']}");
                                        
                                        endif;
                                    else:
                                        unset($this->Data['tpati_sla']);
                                        $update = new Update;

                                        $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", ":id={$this->Data['ativ_id']}");

                                        if($update->getResult()):
                                            $this->Result = "<div class='alert alert-info alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong>#{$this->Data['ativ_id']} alterada com sucesso.</div>";
                                        else:
                                            $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha na Alteração: </strong>#{$this->Data['ativi_id']} não foi alterada.</div>";
                                        endif;
                                    endif;    
                                endif; 
                            endif;
                            
                        else: 
                            if($this->Data['ativ_tp_entrada'] != 'SAC'):
                                $this->Data['ativ_sac'] = '';
                            endif;
                            
                            unset($this->Data['tpati_sla']);
                            
                            $update = new Update;

                            $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", ":id={$this->Data['ativ_id']}");

                            if($update->getResult()):
                                $this->Result = "<div class='alert alert-info alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Atividade: </strong>#{$this->Data['ativ_id']} alterada com sucesso.</div>";
                                
                            else:
                                $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha na Alteração: </strong>#{$this->Data['ativi_id']} não foi alterada.</div>";
                            endif;
                        endif; 
                    else:
                        echo '';
                    endif;
                endif;
            endif;    
            unset($this->Data);
            //unset($_SESSION['ativi_id']);
        }
        
                  
        // DELETE ATIVIDADE 
        
        // PAUSE|PLAY SLA
        function pause($Data){
            $this->Data = $Data; // ativ_status e ativ_id
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;
            
                    if(isset($this->Data)):
                        unset($this->Data['submit']);

                        $this->Data['ativ_status'] = ($this->Data['ativ_status'] == 'info' ? 1 : 0); 

                        $update = new Update;
                        $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", "id={$this->Data['ativ_id']}");

                        $query_novo =    "SELECT
                                                sla.sla_tempo,
                                                CASE
                                                  WHEN sla.sla_tempo IS NULL
                                                        THEN TIMEDIFF(CURRENT_TIMESTAMP(),concat(ativ.ativ_data_entrada, ' ' ,ativ.ativ_hora_entrada))
                                                  WHEN sla.sla_tempo IS NOT NULL
                                                        THEN TIMEDIFF(CURRENT_TIMESTAMP(),sla_log)
                                                  END AS sla_tempo_soma			

                                          FROM tb_sla sla
                                          RIGHT JOIN tb_atividades ativ
                                                ON sla.ativ_id = ativ.ativ_id
                                                WHERE ativ.ativ_id = :id
                                          ORDER BY sla.sla_id DESC
                                          LIMIT 1";

                        $read = new Read;
                        $read->FullRead($query_novo, "id={$this->Data['ativ_id']}");

                        if($read->getResult()):
                            if($this->Data['ativ_status'] == 1):
                                $this->Data['usr_id'] = $_SESSION['usr_id'];                
                                $this->Data['sla_tempo'] = $read->getResult()[0]['sla_tempo'];
                                $this->Data['sla_tipo'] = $this->Data['ativ_status'];
                                unset($this->Data['ativ_status']);

                            else:
                                $this->Data['usr_id'] = $_SESSION['usr_id'];                
                                $this->Data['sla_tempo'] = $read->getResult()[0]['sla_tempo_soma'];
                                $this->Data['sla_tipo'] = $this->Data['ativ_status'];
                                unset($this->Data['ativ_status']);

                            endif;

                        $insert = new Create;
                        $insert->ExeCreate('tb_sla', $this->Data); 

                        $query_total = "SELECT
                                            SEC_TO_TIME(SUM( ( TIME_TO_SEC(sla_tempo )))) AS ativ_sla_tempo
                                        FROM 
                                            tb_sla
                                        WHERE
                                            ativ_id = :id AND sla_tipo = 0";

                        $read->FullRead($query_total, "id={$this->Data['ativ_id']}");

                        unset($this->Data['usr_id']);
                        unset($this->Data['sla_tempo']);
                        unset($this->Data['sla_tipo']);

                        $this->Data['ativ_sla_tempo'] = $read->getResult()[0]['ativ_sla_tempo'];

                        $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", "id={$this->Data['ativ_id']}");

                        endif; 

                    else:
                        echo '';
                    endif;
                    
                unset($this->Data);
            
            endif; 
        endif;    
        }
        
        // GRAVA MOTIVO PAUSA
        function udt_motivo($Data){
            $this->Data = $Data;
            
            if(isset($this->Data)):
                unset($this->Data['submit']);
                
                $update = new Update;
                
                $update->ExeUpdate('tb_sla', $this->Data, "WHERE ativ_id=:id", ":id={$_SESSION['ativ_id']}");   
                    
            else:
                echo '';
            endif;
            
            unset($this->Data);
            unset($_SESSION['ativi_id']);
        }
        /// FIM MOTIVO PAUSA
        
        
        function getResult() {
            return $this->Result;
        }
        
        /*************************************************************************************
         *
         *  CALCULO DO SLA
         * 
         * 
         * @var type 
         *************************************************************************************/
        
        private $Id;
        private $Tp;
        private $ResultSla;
        private $DtEntrada;
        private $DtTermino;
        private $HrEntrada;
        private $HrTermino;
        private $TotalDias;
        private $Dias;
        private $Sla;
        //private $Tarde;


        public function calcSla($id, $dTermino = null, $hTermino = null) {
            $this->Id = $id;

            $this->setData($this->Id, $dTermino, $hTermino);
            $this->setDiasUteis();
            $this->corrigeEntrada();
            $this->corrigeTermino();

            $diaEntrada = 0;
            $entrada = 0; 

            // Abre e Fecha no mesmo dia.
            if($this->Dias == 1 && $this->DtEntrada == $this->DtTermino):
                $dia = strtotime($this->HrTermino) - strtotime($this->HrEntrada);

                $hora   = floor($dia / 3600);
                $min    = floor(($dia - ($hora * 3600)) / 60);
                $minuto = (strlen($min) == 1 ? "0{$min}" : $min);

                $this->Sla = "{$hora}:{$minuto}:00";

            else:
                // Calculo parcial Sla - Entrada
                if(strtotime($this->HrEntrada) < strtotime('13:00:00')):
                    $entrada = strtotime('13:00:00') - strtotime($this->HrEntrada);
                    $diaEntrada = $entrada + (4 * 3600); 

                elseif(strtotime($this->HrEntrada) > strtotime('14:00:00')):    
                    $entrada = strtotime('18:00:00') - strtotime($this->HrEntrada);
                    $diaEntrada = $entrada; 

                endif;

                // Calculo parcial Sla - Termino
                $termino = strtotime($this->HrTermino) - strtotime('09:00:00');

                // Calculo Sla
                $diasCompletos = $this->TotalDias;

                $horasCompletas = $diasCompletos * 8 * 3600;

                $horasTotal = $diaEntrada + $horasCompletas + $termino;
                //echo "horasTotal: {$horasTotal} | diaEntrada: {$diaEntrada} | horasCompletas: {$horasCompletas} | termino: {$termino}";
                $hora   = floor($horasTotal / 3600);
                $min    = floor(($horasTotal - ($hora * 3600)) / 60);
                $minuto = (strlen($min) == 1 ? "0{$min}" : $min);

                $this->Sla = "{$hora}:{$minuto}:00";
                //var_dump($this);
            endif;

            return $this->Sla;
        }

        /**
         * <b>set Data: </b> Atribui Data e Hora da Entrada e Termino em variáveis privadas. 
         * Result - boolean
         * DtEntrada
         * DtTermino
         * HrEntrada
         * HrTermino
         */
        private function setData($id, $dTermino = null, $hTermino = null) {
            //echo 'Id: '.$this->Id.'<br>';
            if(is_null($dTermino)):
				$readSla = new Read;
				$readSla->FullRead("SELECT ativ_data_entrada AS dtEntrada, ativ_data_termino AS dtTermino, ativ_hora_entrada AS hrEntrada, ativ_hora_termino AS hrTermino FROM tb_atividades WHERE ATIV_ID = :id", "id={$this->Id}");
				//var_dump($readSla->getResult());
				if($readSla->getResult()):
					$this->DtEntrada = $readSla->getResult()[0]['dtEntrada'];
					$this->HrEntrada = $readSla->getResult()[0]['hrEntrada'];

					if(is_null($readSla->getResult()[0]['dtTermino'])):
						$this->DtTermino = date('Y-m-d');
						$this->HrTermino = date('H:i:s');
						$this->ResultSla = 'aberto';
					else:
						$this->DtTermino = $readSla->getResult()[0]['dtTermino'];
						$this->HrTermino = $readSla->getResult()[0]['hrTermino'];
						$this->ResultSla = 'fechado';
					endif;
				else:
					$this->ResultSla = false;
				endif;
			else:
				$readSla = new Read;
				$readSla->FullRead("SELECT ativ_data_entrada AS dtEntrada, ativ_hora_entrada AS hrEntrada FROM tb_atividades WHERE ATIV_ID = :id", "id={$this->Id}");
				//var_dump($readSla->getResult());
				if($readSla->getResult()):
					$this->DtEntrada = $readSla->getResult()[0]['dtEntrada'];
					$this->HrEntrada = $readSla->getResult()[0]['hrEntrada'];

					$this->DtTermino = $dTermino;
					$this->HrTermino = $hTermino;
					//$this->ResultSla = 'fechado';
					
				else:
					$this->ResultSla = false;
					
				endif;
			endif;
			    

            //echo 'DtEntrada: '.$this->DtEntrada.'<br>';
            //echo 'DtTermino: '.$this->DtTermino.'<br>';

        }

        /**
         * <b>Dias Úteis: </b> Retorna o número de dias úteis! Sem Feriados, Sábado e Domingo
         * Exclui os feriados ativos na tb_feriados - frd_ativo = 1
         * @return INT $totalDias = Quantidade de dias úteis.
         */
        private function setDiasUteis() {
            $entrada = strtotime($this->DtEntrada);
            $termino = strtotime($this->DtTermino);
            $totalDias = 0;
            $readFeriado = new Read;

            $count = 1;

            while($entrada <= $termino):
                $proximoDia = date('Y-m-d', $entrada);
                $readFeriado->FullRead("SELECT frd_data AS feriado FROM tb_feriados WHERE frd_ativo = 1 AND frd_data = :data", "data={$proximoDia}");
                $numLinhas = $readFeriado->getRowCount();

                if($numLinhas == 0):
                    if(date('w', $entrada) <> 6 && date('w', $entrada) <> 0):
                        $totalDias++;
                    endif;

                endif;

                $entrada += 86400;

                $count++;
            endwhile;
            
            $this->Dias = $totalDias; 
            
            $totalDias = $totalDias - 2;
            
            $totalDias = ($totalDias <= 0 ? 0 : $totalDias);
            
            $this->TotalDias = $totalDias;

            //echo "Total dias: {$this->TotalDias} | Dias: {$this->Dias} <br>";

        }

        /**
         * <b>Tratamento Entrada: </b> Corrige considerando horário comercial.
         * @return DATETIME $entradaCorrigida.
         */
        private function corrigeEntrada() {
            if(strtotime($this->HrEntrada) < strtotime('09:00:00')):
                $this->HrEntrada = date('H:i:s', strtotime('09:00:00'));

            elseif(strtotime($this->HrEntrada) >= strtotime('18:00:00')):
                $this->HrEntrada = date('H:i:s', strtotime('18:00:00'));

            elseif(strtotime($this->HrEntrada) > strtotime('13:00:00') && strtotime($this->HrEntrada) <= strtotime('14:00:00')):     
                $this->HrEntrada = date('H:i:s', strtotime('14:00:00'));

            else:
                $this->HrEntrada;
            endif;
            //echo 'HrEntrada: '.$this->HrEntrada.'<br>';
        }

        /**
         * <b>Tratamento Término: </b> Corrige apenas quando término for antes das 09:00:00.
         * @return DATETIME $terminoCorrigido.
         */
        private function corrigeTermino() {
            if(strtotime($this->HrTermino) < strtotime('09:00:00')):
                $this->HrTermino = date('H:i:s', strtotime('09:00:00'));
            else:
                $this->HrTermino;
            endif;
            //echo 'HrTermino: '.$this->HrTermino.'<br>';
        }
        
        // ATUALIZA SLA
        
        function upt_sla($Data){
            $this->Data = $Data;
            
            $update = new Update;
            $update->ExeUpdate('tb_atividades', $this->Data, "WHERE ativ_id=:id", "id={$this->Data['ativ_id']}");
            unset($this->Data);
            
        }    
        
        
        /*************************************************************************************
         *
         *  CALCULO DO ESFORÇO
         * 
         * 
         * @var type 
         *************************************************************************************/
        
        private $IdEsforco;
        //private $Tp;
        private $ResultEsforco;
        private $DtInicio;
        //private $DtTermino;
        private $HrInicio;
        //private $HrTermino;
        private $TotalDiasEsforco;
        private $DiasEsforco;
        private $Esforco;
        //private $Tarde;


        public function calcEsforco($id, $dTermino = null, $hTermino = null) {
            $this->IdEsforco = $id;

            $this->setDataEsforco($this->IdEsforco, $dTermino, $hTermino);
            $this->setDiasUteisEsforco();
            $this->corrigeInicio();
            $this->corrigeTermino();

            $diaEntrada = 0;
            $entrada = 0; 

            // Abre e Fecha no mesmo dia.
            if($this->Dias == 1 && $this->DtInicio == $this->DtTermino):
                $dia = strtotime($this->HrTermino) - strtotime($this->HrEntrada);

                $hora   = floor($dia / 3600);
                $min    = floor(($dia - ($hora * 3600)) / 60);
                $minuto = (strlen($min) == 1 ? "0{$min}" : $min);

                $this->Sla = "{$hora}:{$minuto}:00";

            else:
                // Calculo parcial Esforço - Inicio
                if(strtotime($this->HrInicio) < strtotime('13:00:00')):
                    $inicio = strtotime('13:00:00') - strtotime($this->HrInicio);
                    $diaInicio = $inicio + (4 * 3600); 

                elseif(strtotime($this->HrInicio) > strtotime('14:00:00')):    
                    $inicio = strtotime('18:00:00') - strtotime($this->HrInicio);
                    $diaInicio = $inicio; 

                endif;

                // Calculo parcial Esforço - Termino
                $termino = strtotime($this->HrTermino) - strtotime('09:00:00');

                // Calculo Sla
                $diasCompletos = $this->TotalDiasEsforco;

                $horasCompletas = $diasCompletos * 8 * 3600;

                $horasTotal = $diaInicio + $horasCompletas + $termino;
                //echo "horasTotal: {$horasTotal} | diaEntrada: {$diaEntrada} | horasCompletas: {$horasCompletas} | termino: {$termino}";
                $hora   = floor($horasTotal / 3600);
                $min    = floor(($horasTotal - ($hora * 3600)) / 60);
                $minuto = (strlen($min) == 1 ? "0{$min}" : $min);

                $this->Esforco = "{$hora}:{$minuto}:00";
                //var_dump($this);
            endif;

            return $this->Esforco;
        }

        /**
         * <b>set Data: </b> Atribui Data e Hora da Entrada e Termino em variáveis privadas. 
         * Result - boolean
         * DtEntrada
         * DtTermino
         * HrEntrada
         * HrTermino
         */
        private function setDataEsforco($id, $dTermino = null, $hTermino = null) {
            //echo 'Id: '.$this->Id.'<br>';
            if(is_null($dTermino)):
				$readEsforco = new Read;
				$readEsforco->FullRead("SELECT ativ_data_inicio AS dtInicio, ativ_data_termino AS dtTermino, ativ_hora_inicio AS hrInicio, ativ_hora_termino AS hrTermino FROM tb_atividades WHERE ATIV_ID = :id", "id={$this->IdEsforco}");
				//var_dump($readSla->getResult());
				if($readEsforco->getResult()):
					$this->DtInicio = $readEsforco->getResult()[0]['dtInicio'];
					$this->HrInicio = $readEsforco->getResult()[0]['hrInicio'];

					if(is_null($readEsforco->getResult()[0]['dtTermino'])):
						$this->DtInicio = date('Y-m-d');
						$this->HrInicio = date('H:i:s');
						$this->ResultEsforco = 'aberto';
					else:
						$this->DtTermino = $readEsforco->getResult()[0]['dtTermino'];
						$this->HrTermino = $readEsforco->getResult()[0]['hrTermino'];
						$this->ResultEsforco = 'fechado';
					endif;
				else:
					$this->ResultEsforco = false;
				endif;
			else:
				$readEsforco = new Read;
				$readEsforco->FullRead("SELECT ativ_data_inicio AS dtInicio, ativ_hora_inicio AS hrInicio FROM tb_atividades WHERE ATIV_ID = :id", "id={$this->IdEsforco}");
				//var_dump($readSla->getResult());
				if($readEsforco->getResult()):
					$this->DtInicio = $readEsforco->getResult()[0]['dtInicio'];
					$this->HrInicio = $readEsforco->getResult()[0]['hrInicio'];

					$this->DtTermino = $dTermino;
					$this->HrTermino = $hTermino;
					//$this->ResultSla = 'fechado';
					
				else:
					$this->ResultEsforco = false;
					
				endif;
			endif;
			    

            //echo 'DtInicio: '.$this->DtInicio.'<br>';
            //echo 'DtTermino: '.$this->DtTermino.'<br>';

        }

        /**
         * <b>Dias Úteis: </b> Retorna o número de dias úteis! Sem Feriados, Sábado e Domingo
         * Exclui os feriados ativos na tb_feriados - frd_ativo = 1
         * @return INT $totalDias = Quantidade de dias úteis.
         */
        private function setDiasUteisEsforco() {
            $inicio = strtotime($this->DtInicio);
            $termino = strtotime($this->DtTermino);
            $totalDias = 0;
            $readFeriado = new Read;

            $count = 1;

            while($inicio <= $termino):
                $proximoDia = date('Y-m-d', $inicio);
                $readFeriado->FullRead("SELECT frd_data AS feriado FROM tb_feriados WHERE frd_ativo = 1 AND frd_data = :data", "data={$proximoDia}");
                $numLinhas = $readFeriado->getRowCount();

                if($numLinhas == 0):
                    if(date('w', $inicio) <> 6 && date('w', $inicio) <> 0):
                        $totalDias++;
                    endif;

                endif;

                $inicio += 86400;

                $count++;
            endwhile;
            
            $this->Dias = $totalDias; 
            
            $totalDias = $totalDias - 2;
            
            $totalDias = ($totalDias <= 0 ? 0 : $totalDias);
            
            $this->TotalDiasEsforco = $totalDias;

            //echo "Total dias: {$this->TotalDias} | Dias: {$this->Dias} <br>";

        }

        /**
         * <b>Tratamento Entrada: </b> Corrige considerando horário comercial.
         * @return DATETIME $entradaCorrigida.
         */
        private function corrigeInicio() {
            if(strtotime($this->HrInicio) < strtotime('09:00:00')):
                $this->HrInicio = date('H:i:s', strtotime('09:00:00'));

            elseif(strtotime($this->HrInicio) >= strtotime('18:00:00')):
                $this->HrInicio = date('H:i:s', strtotime('18:00:00'));

            elseif(strtotime($this->HrInicio) > strtotime('13:00:00') && strtotime($this->HrInicio) <= strtotime('14:00:00')):     
                $this->HrInicio = date('H:i:s', strtotime('14:00:00'));

            else:
                $this->HrInicio;
            endif;
            //echo 'HrEntrada: '.$this->HrEntrada.'<br>';
        }
        
    }
    
    
    
