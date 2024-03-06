<?php

    require './_app/Config.inc.php';
    /**
     * Chega Usuário e Senha
     *
     * @author roger.toledo
     */

    class login {
        
        private $Data;
        private $User;
        private $Error;
        private $Result;
    
        function login($Data) {
            
            $this->Data = $Data;
            
            $email = isset($Data['usr_email']) ? $Data['usr_email'] : '';
            $pass = isset($Data['usr_pass']) ? $Data['usr_pass'] : '';
            
            if (empty($email) || empty($pass)):
                $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha no Login: </strong>Por favor informe usuário e senha.</div>";
            else:
                $read = new Read;
                $read->FullRead("SELECT usr_id, usr_nome, usr_email, usr_pass, usr_sist, usr_nivel FROM tb_usuario WHERE usr_email = :email","email={$email}");
                
                if(!$read->getResult()):
                    $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha no Login: </strong>Usuário não cadastrado.</div>";
                
                elseif($read->getResult()[0]['usr_pass'] == '202cb962ac59075b964b07152d234b70'):                         
                    header('Location: altera_senha.php');
                
                else:
                    $readPass = $read->getResult()[0]['usr_pass'];
                
                    if(md5($pass) != $readPass):
                        $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha no Login: </strong>Senha incorreta.</div>";
                    else:
                        if($read->getResult()[0]['usr_nivel'] == '0'):
                            $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha no Login: </strong>Usuário Bloqueado.</div>";
                        
                        else:
                            session_start();
                        
                            $sistema  = $read->getResult()[0]['usr_sist']; 
                            $nivel  = $read->getResult()[0]['usr_nivel']; 
                            $sistemas = explode(',', $sistema);
                            $niveis = explode(',', $nivel);
                            
                            $_SESSION['login'] = true;
                            $_SESSION['usr_id'] = $read->getResult()[0]['usr_id'];
                            $_SESSION['usr_nome'] = $read->getResult()[0]['usr_nome'];
                            $_SESSION['usr_email'] = $read->getResult()[0]['usr_email'];    
                            
                            for($i = 0; $i < count($sistemas); $i++):
                                $_SESSION["usr_sist_{$sistemas[$i]}"] = $niveis[$i]; 
                            endfor;
                            
                            if( (isset($_SESSION['usr_sist_1']) && $_SESSION['usr_sist_1'] >= 2)):
                                header('Location: integracao_abertas.php');
                            else:
                            //elseif($_SESSION['usr_sist_2']):
                                header('Location: suporte_abertas.php');
                            endif;
                            
                        
                        endif;
                    endif;
                endif;
                
            endif;
        }
        
        function novaSenha($Data) {
            $this->Data = $Data;
            unset($this->Data['submit']);
            
            $read = new Read;
            $read->ExeRead('tb_usuario', "WHERE usr_email = :email", "email={$this->Data['usr_email']}");
            
            if(!$read->getResult()):
                $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha no Login: </strong>Email incorreto.</div>";
            else:
                if($read->getResult()[0]['usr_pass'] != md5($this->Data['usr_pass'])):
                   $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha no Login: </strong>Senha incorreta.</div>"; 
                
                else: 
                    $this->Data['usr_pass'] = md5($this->Data['usr_pass_new']);
                    $this->Data['usr_id'] = $read->getResult()[0]['usr_id'];
                    unset($this->Data['usr_pass_new']);
                    unset($this->Data['usr_email']);
                    
                    $update = new Update;
                    $update->ExeUpdate('tb_usuario', $this->Data, "WHERE usr_id = :id", "id={$this->Data['usr_id']}");

                    if(!$update->getResult()):
                        $this->Result = "<div class='alert alert-danger alert-dismissable'><a href='#' class='close' data-dismiss='alert' aria-label='close'>×</a><strong>Falha na alteração: </strong>Senha não alterada.</div>";
                    else:    
                        header('Location: index.php');
                    endif; 
                endif;
                
            endif;
    
        }
        
        function logout(){
            $_SESSION['login'] = false;
            $_SESSION['usr_id'] = '';
            $_SESSION['usr_nome'] = '';
            $_SESSION['usr_email'] = ''; 
            
            if (ini_get("session.use_cookies")):
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 1800,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            endif;

            
            session_destroy();
            
            header('Location: index.php');
        }
        
        function getResult() {
            return $this->Result;
        }
        
    }
    
    