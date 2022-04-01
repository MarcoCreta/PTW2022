$(document).ready(function(){

    //$("#switchMode").click(function(){

    $("#switchMode").closest("li").click(function(){

        if($("body").hasClass("dark")){
            mode = 'light';
            $("body").removeClass("dark")
        } else {
            mode = 'dark';
            $("body").addClass("dark")
        }

        $.ajax({
            url: "php/api-cookies.php",
            method: 'POST',
            data: {action:"switchMode",mode:mode},
        }).done(function(data){

        }).fail(
            
        );
    });
    
})