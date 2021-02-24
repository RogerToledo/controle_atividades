<?php

    class Ajax{
        
        public function Atividades() {
            $jSON = array();
    
            $readAtiv = new Read;
            $readAten = new Read;

            $readAten->FullRead("SELECT tpate_id ,tpate_desc FROM tb_tipo_atendimento");
            
//            $Read->FullRead("SELECT tpate_desc, tpati_tipo FROM tb_tipo_atendimento ATE INNER JOIN tb_tipo_atividades ATI ON ATE.tpate_id = ATI.tpate_id ORDER BY ATE.tpate_desc, ATI.tpati_tipo ");
            $rst = $readAten->getResult();
            //var_dump($rst);
                        
            foreach($readAten->getResult() as $atendimento):
                extract($atendimento);
                $readAtiv->FullRead("SELECT tpati_tipo FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$tpate_id}");
                
                foreach ($readAtiv->getResult() as $atividades):
                    extract($atividades);
                    
                    $arrayAti[] = $tpati_tipo; 
                    
                endforeach;
                $jSON["{$tpate_desc}"] = $arrayAti; 
                
            endforeach;

            json_encode($jSON);
        }
        
    }

    

?>