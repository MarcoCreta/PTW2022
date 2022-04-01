$(document).ready(function () {


    $(document).on('click', '#new-group-submit', function (event) {
        
        group_name = $("#new-group-name").val()

        create_group(group_name)
    });

    $(document).on('click', '#add-teacher-submit', function (event) {
        
        username = $("#add-teacher-name").val()
        ID_group = $("#info").attr('id_group')

        addCollaboration(username, ID_group)
    });

    $(document).on('blur', '#new-group-name', function (event) {
        check_group_name($(this).val())
    });

    $(document).on('blur', '#add-teacher-name', function (event) {
        username = $(this).val()
        ID_group = $("#info").attr('id_group')
        check_teacher(username,ID_group)
    });

    $(document).on('click', '.c-button', function (event) {
        group_element = $(this).closest(".group")

        group_name = group_element.find(".group-name").html()
        leave_group(group_name,group_element)
    });

    $(document).on('click', ".t-button", function(event){

        let user_element = $(this).closest(".user")
        
        let username = user_element.find(".user-username").html()
        let ID_group = $('#info').attr('id_group')

        removeCollaboration(username, ID_group, user_element)

     });

})


function create_group(name) {
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'POST',
        data: { action: 'createGroup', name:name},
    }).done(function (data) {
        $('#new-group-name').removeClass("is-invalid");
        $('#new-group-name').next().html('')
        $('#new-group-name').val("")
        $("#newGroup").modal('hide')

        $('#groups-list').append(data)

    }).fail(function (data) {
        $('#new-group-name').addClass("is-invalid");
        $('#new-group-name').next().html('An error has occurred')
    });
}

function check_group_name(name){
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'GET',
        data: { action: 'checkGroupName', 'name':name},
    }).done(function (data) {
        response = JSON.parse(data)
        if(response['result']) {
            $('#group-warning').attr('hidden', true);
            $('#group-warning').children().first().html('')
        } else {
            $('#group-warning').attr('hidden', false);
            $('#group-warning').children().first().html(response['message'])
        }
    }).fail(function (data) {
    });
}

function check_teacher(username, ID_group){
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'GET',
        data: { action: 'checkTeacher', 'username':username, 'ID_group':ID_group},
    }).done(function (data) {
        response = JSON.parse(data)
        if(response['result']) {
            $('#teacher-warning').attr('hidden', true);
            $('#teacher-warning').children().first().html('')
        } else {
            $('#teacher-warning').attr('hidden', false);
            $('#teacher-warning').children().first().html(response['message'])
        }
    }).fail(function (data) {
    });
}

function leave_group(name, group) {
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'POST',
        data: { action: 'leaveGroup', 'name':name},
    }).done(function (data) {
        response = JSON.parse(data)

        if (response['result']){
            button = group.find(".c-button")
            if(button.hasClass("join-group")){
                button.removeClass('join-group').addClass("leave-group")
                button.removeClass('btn-primary').addClass('btn-secondary')
            } else if (button.hasClass("leave-group")){
                group.slideToggle("slow", function(){
                    group.remove()
                });
            }
        }

    }).fail(function (data) {
    });
}

function addCollaboration(username,ID_group){
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'POST',
        data: { action: 'addCollaboration', 'username':username, 'ID_group':ID_group},
    }).done(function (data) {
        response = JSON.parse(data)
        if (response["result"]) {
            location.reload()
        }
    }).fail(function (data) {
    });
}

function removeCollaboration(username, ID_group, user_element){
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'POST',
        data: { action: 'removeCollaboration', 'username':username, 'ID_group':ID_group},
    }).done(function (data) {
        response = JSON.parse(data)
        if (response['result']){
            user_element.slideToggle("slow", function(){
                user_element.remove()
            });
        }
    }).fail(function (data) {
    });
}