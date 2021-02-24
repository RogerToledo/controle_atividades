<?php
    
    class navBar{
        /**
         * Exibe Barra de Navegação.
         * 
         * @param type $nAtiv = 1 ativa Nova Atividade
         */
        function showNavbar($nAtiv){
            
            $navBar = "<nav class='navbar navbar-inverse'>
                <div class='container-fluid'>
                    <div class='navbar-header'>
                        <a class='navbar-brand' href='integracao_abertas.php'>Integração</a>
                    </div>
                    <ul class='nav navbar-nav dropdown'>";

                        if($_SESSION['usr_sist_1'] != 1 && $nAtiv == 1):
                            $navBar .= "<li><a href='#' data-toggle='modal' data-target='#modalControleAtiv'><span class='glyphicon glyphicon-plus-sign'></span> Nova Atividade</a></li>";
                        endif;

                            $navBar .= "<li class='dropdown'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' id='dropdownCadastro' hidden='hidden'><span class='glyphicon glyphicon-list'></span> Cadastros <span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdownCadastro'>
                                <li><a href='#' data-toggle='modal' data-target='#modalCliente'>Cliente</a></li>
                                <li><a href='#' data-toggle='modal' data-target='#modalDivida'>Dívida Ativa</a></li>";

                                    if($_SESSION['usr_sist_1'] == 9):
                                        $navBar .= "<li><a href='#' data-toggle='modal' data-target='#modalIntegrante'>Integrante</a></li>
                                                <li><a href='#' data-toggle='modal' data-target='#modalAtividade'>Tipo de Atividade</a></li>
                                                <li><a href='#' data-toggle='modal' data-target='#modalAtendimento'>Tipo de Atendimento</a></li>";
                                    endif;  


                            $navBar .= "</ul>
                        </li>    
                        <li class='dropdown'>
                        <a href='#' class='dropdown-toggle' data-toggle='dropdown' id='dropdownRelatorios' hidden='hidden'><span class='glyphicon glyphicon-stats'></span> Relatórios <span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdownRelatorios'>
                                <!--<li><a href='system/grafico.php'>Gráfico</a></li>-->
                                <li><a href='system/prioridade_aberta_excel.php'>Atividades Priorizadas em Aberto | Excel</a></li>
                                <li><a href='system/todas_excel.php'>Todas Atividades | Excel</a></li>
                                <li><a href='system/clientes_excel.php'>Clientes | Excel</a></li>
                                <li><a href='system/da_excel.php'>Dívida Ativa | Excel</a></li>
                            </ul>
                        </li>

                    </ul>
                    <ul class='nav navbar-nav navbar-right'>
                        <li>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown' id='dropdownSistema' hidden=''><span class='glyphicon glyphicon-flash'></span> Sist. <span class='caret'></span></a>
                            <ul class='dropdown-menu' aria-labelledby='dropdownRelatorios'>
                                <li><a href='suporte_abertas.php'>Suporte</a></li>
                            </ul>
                        </li>
                        </li>
                        <li>
                            <a href='#'><{$_SESSION['usr_nome']}></a>
                        </li>
                        <li>
                            <a href='logout.php'><span class='glyphicon glyphicon-log-in'></span> Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>";
                            
            echo $navBar;                

        }
     }
    
