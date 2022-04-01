$(document).ready(function(){

    $(document).on('submit', "#teacher-form", function(event){
        event.preventDefault();
  
        form = $('#teacher-form')
        
        teacher = {
           name : $("#fname").val(), 
           surname : $("#lname").val(), 
           CF : $("#CF").val(), 
           bday : $("#dob").val(), 
        }
        update_teacher(teacher, form)
  
     });

     $(document).on('submit', "#privacy-form", function(event){
        event.preventDefault();
  
        form = $('#privacy-form')
        
        settings = {
            private: Number($("#profile-privacy").is(":checked"))
        }
        update_privacy(settings, form)
  
     });

     $(document).on('click', ".settings-selector", function(event){
        target = $(this).children('a').attr('class')
        $(".formset-vertical").find('form').removeClass('active')
        $(".formset-vertical").find('.'+target).addClass('active')
     });


    get_teacher_info();
    get_privacy_settings();
})

function get_teacher_info(){
    $.ajax({
        url: "php/api-settings.php",
        method: 'GET',
        data: {action:"getTeacherInfo"},
    }).done(function(data){
        response = JSON.parse(data)
        if(response['result']){
            $("#fname").val(response['teacher']['name'])
            $("#lname").val(response['teacher']['surname'])
            $("#dob").val(response['teacher']['bday'])
            $("#CF").val(response['teacher']['CF'])
            $("#CF").prop('disabled', true)
        }
    }).fail(function(data){
  
    });
}

function get_privacy_settings(){
    $.ajax({
        url: "php/api-settings.php",
        method: 'GET',
        data: {action:"getPrivacySettings"},
    }).done(function(data){
        response = JSON.parse(data)
        if(response['result']){
            $("#profile-privacy").prop( "checked",  Boolean(response['settings']['private']));
        }     
    }).fail(function(data){
  
    });
}

function update_teacher(teacher,form_element){
    $.ajax({
        url: "php/api-settings.php",
        method: 'POST',
        data: {action:"updateTeacher", teacher:teacher},
    }).done(function(data){

    }).fail(function(data){
  
    });
}

function update_privacy(privacy_settings,form_element){
    $.ajax({
        url: "php/api-settings.php",
        method: 'POST',
        data: {action:"updatePrivacy", settings:privacy_settings},
    }).done(function(data){

    }).fail(function(data){
  
    });
}
