<?php
    require "./_app/Config.inc.php";
    $read = new Read();
    $read->ExeRead('agua');
    
    var_dump($read);
    
    if(!$read->getResult()):
                echo Erro("<span class='al_center icon-info ds_block'>Desculpe, mas não existem usuários cadastrados!</span>", E_USER_NOTICE);
            else:
                echo "<div class='jwc_content_add'></div>";
                foreach ($read->getResult() as $c):
                    extract($c);
                    //$user_datebirth = date("d/m/Y", strtotime($user_datebirth));
                    
                    var_dump($c);    
                    
                endforeach;
            endif;

?>    