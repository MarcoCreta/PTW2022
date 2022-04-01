const MAX_DISPLAY = 6

$(document).ready(function(){

    $(document).on('click', ".shop-product", function(event){
        addToCart($(this).attr('id'))
    });

    $(document).on('click', ".category-button", function(event){
        $("#content-page").html('')
        getTeachings($(this).closest('.category-header').attr('id'))
        console.log($(this).closest('.category-header').attr('id'))
    });

    /*
    const urlParams = new URLSearchParams(window.location.search);

    getTeachings(urlParams.get('category'));
    */
})

function getTeachings(category){
    if (category != null){
        data = {action:"getTeachings",category:category}
    } else {
        data = {action:"getTeachings"}
    }
    $.ajax({
       url: "php/api-shop.php",
       method: 'GET',
       data,
   }).done(function(data){
        /*
        response=JSON.parse(data)

        for(const category in response){
            $("#content-page").append(map_category(category))
            for(let i = 0; i < response[category].length && i <= MAX_DISPLAY; i++){
                $(`#${category}`).find('#category-body').append(map_teaching(response[category][i]))
            }
        }
        */
   }).fail(

   );
}

function addToCart(productID){
    $.ajax({
        url: "php/api-cart.php",
        method: 'POST',
        data: {action:"addToCart", productID:productID},
    });
}