<?php

    require '../_app/Config.inc.php';

    $jSON = array();
    
    $getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    if(empty($getPost['callback_action'])):
        $jSON['trigger'] = AjaxErro("<span class='icon-cross al_center ds_block'>Nenhuma ação não foi selecionada no formulário!</span>", E_USER_ERROR);
    
    else:
        $Post = array_map("strip_tags", $getPost);
        $Action = $Post['callback_action'];
        unset($Post['callback_action'], $Post['callback']);
        
        $Create = new Create;
        $Read   = new Read;
                
        switch($Action):
            case 'user_create':
                $jSON['user'] = $Post; 
                
                //VERIFICA CAMPOS EM BRANCO
                if(in_array('', $Post)):
                    $jSON['trigger'] = AjaxErro("<span class='icon-warning al_center ds_block'>Para cadastrar um usuário, preencha todos os campos!</span>", E_USER_WARNING);
                    break;
                endif;
                
//                //VERIFICA SE EMAIL JÁ EXISTE
//                $Read->FullRead("SELECT user_id FROM users WHERE user_email = :email", "email={$Post['user_email']}");
//                if($Read->getResult()):
//                    $jSON['trigger'] = AjaxErro("<span class='icon-cross al_center ds_block'>O e-mail {$Post['user_email']} já existe!</span>", E_USER_ERROR);
//                    break;
//                endif;              
                
                $chamCreate = [
                    'cham_analista' => $Post['cham_analista'], 
                    'cham_sac' => $Post['cham_sac'], 
                    'cham_complexidade' => $Post['cham_complexidade'], 
                    'cham_prioridade' => $Post['cham_prioridade'], 
                    'cham_descricao' => $Post['cham_descricao'], 
                    'cham_detalhe' => $Post['cham_detalhe'],                  
                    //'cham_detalhe' => date("Y-m-d H:i:s")
                ];
                                
                $Create->ExeCreate('tbl_chamado', $chamCreate);
                
                $chamId = $Create->getResult();
                
                extract($chamCreate);
                
//                $userAddress = [
//                    'user_id' => $userId,
//                    'addr_state' => $Post['addr_state'],
//                    'addr_city' => $Post['addr_city'],
//                    'addr_street' => $Post['addr_street'],
//                    'addr_number' => $Post['addr_number']
//                ];
//                
//                $Create->ExeCreate('address', $userAddress);
//                
                $jSON['content_add'] = "<div class='wc_single_user' id='{$chamId}'>"
                    . "<p class='row title'>{$cham_sac}</p>"
                    . "<p class='row'>{$cham_descricao}</p>"
                    . "<p class='row'>{$cham_complexidade}</p>"
                    . "<p class='row'>{$cham_prioridade}</p>"
                    . "<p class='row'>{$cham_analista}</p>"
                    . "<p class='row al_right'>"
                    . "<span class='btn btn_blue icon-pencil2 icon-notext wc_edit wc_tooltip'><span class='wc_tooltip_balloon'>Editar Dados de {$cham_analista}!</span></span>"
                    . "<span class='btn btn_red icon-cross icon-notext wc_delete wc_tooltip' id='{$chamId}'><span class='wc_tooltip_balloon'>Deletar conta de {$cham_analista}!</span></span>"
                    . "</p>"
                    . "</div>";
                $jSON['trigger'] = AjaxErro("<span class='icon-checkmark al_center ds_block'>Chamado {$chamId} cadastrado com sucesso!</span>");
                $jSON['clear'] = true; 
                
                break;
            
            default :
                $jSON['trigger'] = AjaxErro("<span class='icon-cross al_center ds_block'>Nenhuma ação não foi selecionada no formulário!</span>", E_USER_ERROR);
                break;
        endswitch;
        
    endif;
    
    echo json_encode($jSON);

?>