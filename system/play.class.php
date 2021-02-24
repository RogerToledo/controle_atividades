<?php
    /**
     * Description of pause
     *
     * @author roger.toledo
     */

    class Play {
        private $Data;
        private $Result;
        
        // ALTERA STATUS - PAUSE OU PLAY
        function alteraStatus($data){
            $this->Data = $data;
            
            if( $_SERVER['REQUEST_METHOD']=='POST' ):

                $hash = md5( implode( $_POST ) );

                if( isset( $_SESSION['hash'] ) && $_SESSION['hash'] == $hash ):
                    $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Refresh: </strong>Dados não enviados.</div>";
                    
                else:
                    $_SESSION['hash']  = $hash;
            
                    if(isset($this->Data)):
                        unset($this->Data['submit']);
                        $tempoSoma = $this->tempo_soma($this->Data['ativ_id'])[0];
                        
                        if($tempoSoma):
                            if($this->Data['pla_tipo'] == 1):
                                $this->Data['usr_id'] = $_SESSION['usr_id'];                
                                $this->Data['pla_tempo'] = $tempoSoma['pla_tempo'];
                                $this->insere($this->Data);
                                $this->Data['tpati_id'] = $tempoSoma['tpati_id'];
                                $this->pausa_auto($this->Data);
                               
                            else:        
                                $this->Data['usr_id'] = $_SESSION['usr_id'];                
                                $this->Data['pla_tempo'] = $tempoSoma['pla_tempo_soma'];
                                $this->insere($this->Data);   
                                
                            endif;
                        endif; 
                    else:
                        $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Oops! </strong>Falha ao atualizar. Entre em contato com o Adm. </div>";
                    endif;
                    
                unset($this->Data);
            
            endif; 
        endif;    
        }
        
        function pausaTermino($data){
            $this->Data['ativ_id'] = $data;
                            
            if(isset($this->Data)):

                $tempoSoma = $this->tempo_soma($this->Data['ativ_id'])[0];

                if($tempoSoma):
                    $this->Data['usr_id'] = $_SESSION['usr_id'];                
                    $this->Data['pla_tempo'] = $tempoSoma['pla_tempo_soma'];
                    $this->Data['pla_tipo'] = 0;

                    $this->insere($this->Data);

                endif; 
            else:
                $this->Result = "<div class='alert alert-warning alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Oops! </strong>Falha ao atualizar. Entre em contato com o Adm. </div>";
            endif;          
                
        }
              
        // GRAVA MOTIVO PAUSA  --->> NÃO ESTÁ EM USO
//        function udt_motivo($Data){
//            $this->Data = $Data;
//            
//            if(isset($this->Data)):
//                unset($this->Data['submit']);
//                
//                $update = new Update;
//                
//                $update->ExeUpdate('tb_play', $this->Data, "WHERE ativ_id=:id", ":id={$_SESSION['ativ_id']}");   
//                    
//            else:
//                echo '';
//            endif;
//            
//            unset($this->Data);
//            unset($_SESSION['ativi_id']);
//        }
        /// FIM MOTIVO PAUSA
    
     
        function somaTempo($id) {
            $query = "SELECT TIME_FORMAT( SEC_TO_TIME( SUM( TIME_TO_SEC( pla_tempo ) ) ),'%H:%i:%s') AS pla_tempo FROM tb_play WHERE pla_tipo = 0 AND ativ_id = :ativId";
            $read = new Read;
            
            $read->FullRead($query, "ativId={$id}");
            
            return $read->getResult()[0]['pla_tempo'];
        }
        
    /**
     * 
     * METODOS PRIVADO
     * 
     */ 
    
    private function tempo_soma($id){
        $query =    "SELECT
                        ativ.tpati_id as tpati_id,
                        pla.pla_tempo,	
                        TIMEDIFF(CURRENT_TIMESTAMP(),pla_log)AS pla_tempo_soma			
                    FROM tb_play pla
                    RIGHT JOIN tb_atividades ativ
                        ON pla.ativ_id = ativ.ativ_id
                            WHERE ativ.ativ_id = :id
                    ORDER BY pla.pla_id DESC
                    LIMIT 1";

        $read = new Read;
        $read->FullRead($query, "id={$id}");
        
        return $read->getResult();
        
    }    
        
    // INSERE REGISTRO PAUSA/PLAY
    private function insere($Data) {
        $insert = new Create;
        unset($Data['tpati_id']);
        $insert->ExeCreate('tb_play', $Data);
    }  
    
    // PAUSA AUTOMÁTICAMENTE ATIVIDADES
    private function pausa_auto($Data){
        $read = new Read;
        $query = "SELECT DISTINCT pla.ativ_id, ati.tpati_id FROM tb_play pla INNER JOIN tb_atividades ati ON pla.ativ_id = ati.ativ_id WHERE pla.usr_id = :usrId AND ati.ativ_data_termino IS NULL AND ati.tpati_id <> 9 AND pla.ativ_id <> :ativId ORDER BY pla_id, pla_log DESC";
        
        $read->FullRead($query,"usrId={$Data['usr_id']}&ativId={$Data['ativ_id']}");
        
        $dist = $read->getResult();
        
        foreach($dist as $atividade):
            $readMax = new Read;
            $readMax->FullRead("SELECT MAX(pla_id) as pla_id, pla_tipo, ativ_id FROM tb_play WHERE ativ_id = :ativId","ativId={$atividade['ativ_id']}");
            $max = $readMax->getResult()[0];
            
            if($Data['tpati_id'] != 9):
                if($max['pla_tipo'] != 0):
                    $tempoSoma = $this->tempo_soma($atividade['ativ_id'])[0];
                    
                    $Data['pla_tempo'] = $tempoSoma['pla_tempo_soma'];
                    $Data['pla_motivo'] = 'Pausada pelo início da Atividade: ' . $Data['ativ_id'];
                    $Data['ativ_id'] = $max['ativ_id'];
                    $Data['pla_tipo'] = 0;
                    
                    $this->insere($Data);
                endif;
            endif;    
                
        endforeach;
        
    }    
        
  
    }
