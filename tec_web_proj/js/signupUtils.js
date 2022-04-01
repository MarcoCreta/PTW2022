$(document).ready(function(){
    //check all
    $check = [false,false,false,false,false]

    $("input").blur(function(){
        if($(this).val().length == 0){
            showErrorMessage($(this),' You cannot leave this form blank')
            $check[0] = false
        } else {
            $(this).next().html('')
            $check[0] = true
        }
    });

    $("#r-username").blur(function(){
        if($(this).val().length == 0){

        } else if (!/^[A-Za-z0-9_]+$/.test($(this).val())){
            showErrorMessage($("#r-username"),' Username should not contain symbols')
            $check[1] = false
        } else if ($(this).val().length < 4) {
            showErrorMessage($("#r-username"),' Username should contain at least 5 characters')
            $check[1] = false
        } else if ($(this).val().length > 10) {
            showErrorMessage($("#r-username"),' Username can contain maximun 10 characters')
            $check[1] = false
        } else {
            $.post("php/api-signup.php", {action:'checkUsername', username:$(this).val()}, function(data){
                response = JSON.parse(data)
                if(response['result']){
                    showErrorMessage($("#r-username"),' Username already taken')
                    $check[1] = false
                } else {
                    $("#r-username").next().html('')
                    $check[1] = true
                }
            })
        }
    });

  
    $("#r-email").blur(function(){
        if($(this).val().length != 0){
            if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val())){
                showErrorMessage($(this),' Email is not valid')
            } else { 
                $.post("php/api-signup.php", {action:'checkEmail', email:$(this).val()}, function(data){
                    response = JSON.parse(data)
                    if(response['result']){
                        showErrorMessage($("#r-email"),' Email already used')
                        $check[2] = false
                    } else {
                        $("#r-email").next().html('')
                        $check[2] = true
                    }
                });
            }
        }
    });

    $("#r1-password").blur(function(){
        if($(this).val().length == 0){

        } else if ($(this).val().length < 4) {
            showErrorMessage($("#r1-password"),' Password should contain at least 5 characters')
            $check[1] = false
        } else if ($(this).val().length > 10) {
            showErrorMessage($("#r1-password"),' Password can contain maximun 10 characters')
            $check[1] = false
        } else if (!/^(?=.*\d)/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should contain at least 1 digit')
            $check[1] = false
        } else if (!/(?=.*[a-z])/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should contain at least 1 lower case letter')
            $check[1] = false
        } else if (!/(?=.*[A-Z])/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should contain at least 1 upper case letter')
            $check[1] = false
        } else if (!/(?=.*\d)/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should contain at least 1 digit')
            $check[1] = false
        } else if (/(?=.*\s)/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should not contain whitespaces')
            $check[1] = false
        } else if (!/(?=.*(?=.*[^a-zA-Z0-9]))/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should contain at least one symbol')
            $check[1] = false
        } else if (!/[ -~]/.test($(this).val())){
            showErrorMessage($("#r1-password"),' Password should not contain special symbols')
            $check[1] = false
        } else {
            $(this).next().html('')
            $check[3] = true;
            if($("#r2-password").val().length != 0){
                $("#r2-password").trigger('blur')
            }
        }
    });

    $("#r2-password").blur(function(){
        if($("#r1-password").val() != $("#r2-password").val()){ 
            showErrorMessage($(this),' The password does not match')
            $check[4] = false;
        } else {
            if($("#r1-password").val().length != 0){
                $(this).next().html('')
                $check[4] = true;
            }
        }
    });

    $("#r-submit").click(function(event){
        if($check.every(Boolean)){

        } else {
            event.preventDefault();
        }
    });

    $(document).on('submit', "#signup-form", function(event){
        event.preventDefault()

        $.ajax({
            url: "php/api-signup.php",
            method: 'POST',
            data: {action:'signup', 'r-username':$('#r-username').val(), 'r-email':$('#r-email').val(), 'r1-password':$('#r1-password').val(), 'r2-password':$('#r2-password').val()},
        }).done(function(data){
            let response = JSON.parse(data)
            if(response['result']){
                location.reload()
            } else {
                $('#singup-error').html(response['message'])
            }
        }).fail(
    
        );
    })

});

function showErrorMessage($item,$message){
    $item.next().html('<span class=" form-warning" id="r-username-warning"><i class="bi bi-exclamation-circle-fill text-danger">'+$message+'</i></span>')
}