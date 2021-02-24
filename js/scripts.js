$(document).ready(
    function(){
   
        $('#ativTpEntrada').change(function(){
            var tpEntrada = $('#ativTpEntrada :selected').text();

            if (tpEntrada == "SAC") {
                $('#ativTpEntradaSac').removeAttr('disabled');
            }else{
                $('#ativTpEntradaSac').attr('disabled','disabled');
                $('#ativTpEntradaSac').val(' ');
            };
        });


        $('#abertas').change(function () {
            $('#ativ-abertas').removeAttr('hidden');
            $('#ativ-fechadas').attr('hidden', 'hidden');
        });

        $('#fechadas').change(function () {
            $('#ativ-fechadas').removeAttr('hidden');
            $('#ativ-abertas').attr('hidden', 'hidden');
        });

        //CRITICIDADE ATIVIDADE E TIPO ATENDIMENTO NOVA 
        $('.js_ativTpAtividade').change(function(){

            var ativTpAtividade = $(this).find(':selected').attr('value');

            var ativCritic = $('#idCri_'+ativTpAtividade).text();

            var option = '#ativCriticSelect option[value="'+ ativCritic +'"]';
            
            $(option).attr({selected: 'selected'});
            
            $('#ativCriticSelectHidden').text(ativCritic);
            $('#ativCriticSelectHidden').val(ativCritic);
            
            var criticidade = $('#ativCriticSelect').find(':selected').attr('value');
            
            //alert('ativTpAtividade: '+ ativTpAtividade + ' | ativCritic: ' + ativCritic + ' | option: ' + option + ' | criticidade: ' + criticidade);
            
            if(criticidade != ativCritic){
                location.reload();
            }
            
            var txtAtivAtend = $('#idAte_'+ativTpAtividade).text();
            var valAtivAtend = $('#idAte_'+ativTpAtividade).val();
            
            $('.js_ativAtendimento_txt').val(txtAtivAtend);
            $('.js_ativAtendimento_val').val(valAtivAtend);
            
                        
            //atividade_id = '';ativCriticSelectHidden
            ativTpAtividade = '';
            ativCritic = '';
            option = '';
            criticidade = '';

        });
        
        //CRITICIDADE ATIVIDADE E TIPO ATENDIMENTO ALTERAÇÃO
        $('.js_ativTpAtividadeAlt').change(function(){

            var atividade_id = $(this).attr('id'); //3

            var ativTpAtividadeAlt = $(this).find(':selected').attr('value');

            var ativCriticAlt = $('#idCri_'+ativTpAtividadeAlt).val();

            var option = '#ativCriticAlt' + atividade_id + ' option[value="'+ ativCriticAlt +'"]';

            $(option).attr({selected: 'selected'});

            var criticidade = $('#ativCriticAlt' + atividade_id).find(':selected').attr('value');

            //alert(criticidade +' | '+ ativCriticAlt+' | '+ option);
            
            if(criticidade != ativCriticAlt){
                location.reload();
            }
            
            var txtAtivAtend = $('#idAte_'+ativTpAtividadeAlt).text();
            var valAtivAtend = $('#idAte_'+ativTpAtividadeAlt).val();
            
            $('.js_ativAtendimentoAlt_txt').val(txtAtivAtend);
            $('.js_ativAtendimentoAlt_val').val(valAtivAtend);
            
            atividade_id = '';
            ativTpAtividadeAlt = '';
            ativCriticAlt = '';
            option = '';
            criticidade = '';

        });
        
        function isNumeric(str) {
            var er = /^[0-9]+$/;
            return (er.test(str));
        };
        
        ///// Valida SLA
        $('#slaAtiv').change(function(){
            var sla = $(this).val();
            var len = sla.length;
            
            if(!isNumeric(sla)){
                $(this).val('');
                $(this).attr("placeholder","Apenas inteiro.");               
            }else{
                if(len > 3){
                    $(this).val('');
                    $(this).attr("placeholder","Máximo de 999 horas.");
                }
            }
        });
        
        
        $('.js_ativAtendimento').change(function(){

            var atendimento = $(this).find(':selected').attr('value');

            var option = '#ativCriticAlt' + atividade_id + ' option[value="'+ ativCriticAlt +'"]';

            $(option).attr({selected: 'selected'});

            var criticidade = $('#ativCriticAlt' + atividade_id).find(':selected').attr('value');

            //alert(criticidade +' | '+ ativCriticAlt+' | '+ option);
            
            if(criticidade != ativCriticAlt){
                location.reload();
            }
            
            atividade_id = '';
            ativTpAtividadeAlt = '';
            ativCriticAlt = '';
            option = '';
            criticidade = '';

        });
        
});


