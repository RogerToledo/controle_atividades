<?php

require '../_app/Config.inc.php';
require './model.class.php';


/**
 * Description of sla
 *
 * @author roger.toledo
 */
class sla {
   
    private $Id;
    private $Tp;
    private $Result;
    private $DtEntrada;
    private $DtTermino;
    private $HrEntrada;
    private $HrTermino;
    private $TotalDias;
    private $Sla;
    private $Manha;
    private $Tarde;


    public function calcSla($id) {
        $this->Id = $id;
              
        //$this->setData($this->Id);
        $this->setDiasUteis();
        $this->corrigeEntrada();
        $this->corrigeTermino();
        
        $diaEntrada = 0;
        $entrada = 0; 
        
        // Abre e Fecha no mesmo dia.
        if($this->TotalDias == 1):
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
            $hora   = floor($horasTotal / 3600);
            $min    = floor(($horasTotal - ($hora * 3600)) / 60);
            $minuto = (strlen($min) == 1 ? "0{$min}" : $min);

            $this->Sla = "{$hora}:{$minuto}:00";
            
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
    private function setData($id) {
        //echo 'ID: '.$this->Id = $id.'<br>';
        $readSla = new Read;
        $readSla->FullRead("SELECT ativ_data_entrada AS dtEntrada, ativ_data_termino AS dtTermino, ativ_hora_entrada AS hrEntrada, ativ_hora_termino AS hrTermino FROM tb_atividades WHERE ATIV_ID = :id", "id={$this->Id}");
        var_dump($readSla->getResult());
        if($readSla->getResult()):
            $this->DtEntrada = $readSla->getResult()[0]['dtEntrada'];
            $this->HrEntrada = $readSla->getResult()[0]['hrEntrada'];
            
            if(is_null($readSla->getResult()[0]['dtTermino'])):
                $this->DtTermino = date('Y-m-d');
                $this->HrTermino = date('H:i:s');
                $this->Result = 'aberto';
            else:
                $this->DtTermino = $readSla->getResult()[0]['dtTermino'];
                $this->HrTermino = $readSla->getResult()[0]['hrTermino'];
                $this->Result = 'fechado';
            endif;
        else:
            $this->Result = false;
        endif;    
        
        echo 'DtEntrada: '.$this->DtEntrada.'<br>';
        echo 'DtTermino: '.$this->DtTermino.'<br>';
       
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
        
        $totalDias = $totalDias - 2;
               
        echo 'Total dias: '.$this->TotalDias = $totalDias.'<br>';
       
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
        echo 'HrEntrada: '.$this->HrEntrada.'<br>';
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
        echo 'HrTermino: '.$this->HrTermino.'<br>';
    }
}

$slaCli = new model;
$rst = $slaCli->calcSla(25);
var_dump($rst);

