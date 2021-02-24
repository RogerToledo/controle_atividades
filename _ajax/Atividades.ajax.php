<?php

    //require '../_app/Config.inc.php';


    $jSON = array();
    
    $Read = new Read;
    
    $Read->FullRead("SELECT ATE.tpate_desc, ATI.tpati_tipo FROM tb_tipo_atendimento ATE INNER JOIN tb_tipo_atividades ATI ON ATE.tpate_id = ATI.tpate_id ORDER BY ATE.tpate_desc, ATI.tpati_tipo ");
    
    foreach($Read->getResult() as $atividades):
        $jSON[] = $atividades;
    endforeach;
    
//    $readAtiv = new Read;
//    $readAten = new Read;
//
//    $readAten->FullRead("SELECT tpate_desc FROM tb_tipo_atendimento");
//
//    $qtdAte = $readAten->getRowCount();
//
//    for($i = 1; $qtdAte >= $i; $i++):
//        $readAtiv->FullRead("SELECT tpati_tipo FROM tb_tipo_atividades WHERE tpate_id = :idAti ORDER BY tpati_tipo", "idAti={$i}");
//
//        $qtdAti = $readAtiv->getRowCount();
//
//        $readAten->FullRead("SELECT tpate_desc FROM tb_tipo_atendimento WHERE tpate_id = :id", "id={$i}");
//
//        $atend = $readAten->getResult()[0];
//
//
//        for($j = 1; $qtdAti >= $j; $j++):
//            $x = $j - 1;
//            $ativ = $readAtiv->getResult()[$x];
//
//            //var_dump($ativ);   
//
//            $jSON[] = "{$atend['tpate_desc']}_{$x}" = $ativ['tpati_tipo'];
//
//        endfor;
//
//    endfor;
    //var_dump($jSON);
    json_encode($jSON);


?>