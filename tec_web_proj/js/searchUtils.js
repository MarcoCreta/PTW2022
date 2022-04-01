$(document).ready(function(){

    $(document).on('click', ".f-button", function(event){

        user_element = $(this).closest(".user")
        
        friendship = {
           user_2 : user_element.find(".user-username").html(), 
        }
  
        if($(this).hasClass("f-add")){
            action = 'addFriendship' 
        } else if($(this).hasClass("f-remove")) {
            action = 'deleteFriendship'
        }

        friendshipEventHandler(user_element, action, friendship)

     });
})

function getUsers(username){
    $.ajax({
        url: "php/api-search.php",
        method: 'GET',
        data: {action:"getUsers",username:username},
    }).done(function(data){
        $(".search-model").html(data)
    }).fail(
  
    );
}

function friendshipEventHandler(user, action, friendship){
    $.ajax({
        url: "php/api-search.php",
        method: 'POST',
        data: {action:action,friendship:friendship},
    }).done(function(data){
        response = JSON.parse(data)

        if (response['result']){
            button = user.find(".f-button")
            if(button.hasClass("f-add")){
                button.removeClass('f-add').addClass("f-remove")
                button.removeClass('btn-primary').addClass('btn-secondary')
            } else if (button.hasClass("f-remove")){
                button.removeClass('f-remove').addClass("f-add")
                button.removeClass('btn-secondary').addClass('btn-primary')
            }
        }
    }).fail(

    );
}
