$(document).ready(function(){

    $(document).ajaxStart(function(){        
        //$(".loader_overlay").show();
        $('button').prop('disabled', true);
        $('.btn').attr('disabled','disabled');
        $(':input[type="submit"]').prop('disabled', true);
    });

    $(document).ajaxComplete(function(){         
        //$(".loader_overlay").hide();
        $('button').prop('disabled', false);
        $('.btn').removeAttr('disabled','disabled');
        $(':input[type="submit"]').prop('disabled', false);
    });

    $(".services_offered_checkbox").on('click', function(){
        var option = $(this).data('option');
        if($("#"+option+"_freq").attr('disabled')){
            $("#"+option+"_freq").removeAttr('disabled','disabled');
        }else{
            $("#"+option+"_freq").attr('disabled','disabled');
        }
    })

    $("#filter_option").on('click', function(){
        $("#filter_box").toggleClass("show");
        $("#export_box").removeClass("show");
    })

    $("#export_option").on('click', function(){
        $("#export_box").toggleClass("show");
        $("#filter_box").removeClass("show");
    })

})