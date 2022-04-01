
var url = window.location.origin + window.location.pathname

$(document).ready(function () {

    $(document).on('change', '#type', function (event) {
        let tab = $(this).val()
        getTab(tab)
    });

    $(document).on('submit', "#settings", function(event){
        event.preventDefault()
        type = $('#type').val()
        content = {}
        if(type == 'masterclass'){
            content = {
                'content' : String($('#body').val())
            }
        } else if (type == 'webinair'){
            content = {
                'date' : $('#date').val(),
                'time' : $('#time').val()
            }
            
            if(!$('#presences').val().length == 0){
                content['n_presences'] = $('#presences').val()
            }
        }

        let teaching = {
            'ID_group' : $('#settings').attr('id_group'),
            'category' : $('#category').val(),
            'type' : $('#type').val(),
            'name' : $('#name').val(),
            'price' : parseFloat($('#price').val()),
            'category_detail' : $('#detail').val(),
            'description' : $('#description').val(),
            'content' : content,
            'active' : Number($("#active").is(":checked"))
        }

        if($('#settings').attr('action') == 'update'){
            teaching['ID_content'] = $('#settings').attr('id_content')
            updateTeaching(teaching)
        } else {
            createTeaching(teaching)
        }
    });
    
})

function getTab(tabName) {
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'GET',
        data: {action: 'getTeachingTab', 'teaching':tabName},
    }).done(function (data) {
        $('#content-page').html(data)
    }).fail(function () {

    });
}

function createTeaching(teaching){
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'POST',
        data: {action: 'createTeaching', 'teaching':teaching},
    }).done(function (data) {
        response = JSON.parse(data)
        if(response['result']){
            location.replace(url+'?ID_group='+response['ID_group']+'&ID_content='+response['ID_content']);
        }
    }).fail(function () {
    });
}

function updateTeaching(teaching){
    $.ajax({
        url: 'php/api-teacher.php',
        method: 'POST',
        data: {action: 'updateTeaching', 'teaching':teaching},
    }).done(function (data) {
    }).fail(function () {
    });
}