let cartProducts = []

$(document).ready(function(){

    $(document).on('click', ".remove-product", function(event){
        product = $(this).closest(".cart-product")
        removeFromCart(product.attr('id'), product)
     });

    //todelete
    $("#addCartB").click(function(){
        addToCart($(this).prev().val())
    });

    //todelete
    $("#removeCartB").click(function(){
        removeFromCart($(this).prev().val())
    });


    $("#place-order").click(function(event){
        event.preventDefault();
        placeOrder()
    });

    getCart()
});

function addToCart(productID){
    $.ajax({
        url: "php/api-cart.php",
        method: 'POST',
        data: {action:"addToCart", productID:productID},
    });
}

function removeFromCart(productID, product_element){
    $.ajax({
        url: "php/api-cart.php",
        method: 'POST',
        data: {action:"removeFromCart", productID:productID},
    }).done(function (data) {
        response = JSON.parse(data)
        if(response["result"]){

            product_element.slideToggle("slow", function(){
                product_element.remove()
                getCart()
            });
        }
    }).fail(

    );
}

function getCart(){
    $.ajax({
        url: "php/api-cart.php",
        method: 'GET',
        data: {action:"getCart"},
        async: false,
    }).done(function(data){
        cart=JSON.parse(data)
        if(cart['products'] !==  null){
            getProducts(cart['products'])
        } else {
            cartProducts = []
            updateOrderDetails()
        }
    });
}

function getProducts(productsList){
    $.ajax({
        url: "php/api-cart.php",
        method: 'GET',
        data: {action:"getCartProducts", products:productsList},
    }).done(function(data){
        cartProducts=JSON.parse(data)
        updateOrderDetails()
    });
}

function placeOrder() {
    $.ajax({
        url: "php/api-cart.php",
        method: 'POST',
        data: { action: "placeOrder" }
    }).done(function (data) {
        response = JSON.parse(data)
        if (response["result"]) {
            $('.cart-product').slideToggle("slow", function () {
                $('.cart-product').remove()
            });
            location.reload()
        }

    });
}

function updateOrderDetails() {
    let productsPrice = 0
    let productsNumber = 0

    if (cartProducts.length != 0) {
        for (const k in cartProducts) {
            productsPrice += parseFloat(cartProducts[k]["price"])
            productsNumber += 1
        }
    }
    finalPrice = productsPrice

    $("#total").text(productsPrice + '€')
    $("#final-price").text(finalPrice + '€')
    $("#products-number").text('cart(' + productsNumber + ')')

    if ($('.cart-product').length == 0) {
        $("#place-order").prop('disabled', true);
    }
}