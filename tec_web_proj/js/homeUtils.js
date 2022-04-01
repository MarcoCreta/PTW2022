$(document).ready(function () {




    getUserSuggestions('interests')
    getUserSuggestions('similar')
    getProductSuggestions('interests')

})

function getUserSuggestions(target) {
    $.ajax({
        url: "php/api-utilities.php",
        method: 'GET',
        dataType: "html",
        data: { 'action': 'getUserSuggestions', 'target': target },
    }).done(function (data) {

        $('#left-content-page').prepend(data)

    })
}

function getProductSuggestions(target) {
    $.ajax({
        url: "php/api-utilities.php",
        method: 'GET',
        dataType: "html",
        data: { 'action': 'getProductSuggestions', 'target': target },
    }).done(function (data) {

        $('#right-content-page').prepend(data)

        $('.shop-product').removeClass('col-md-4')
        $('.shop-product').addClass('col-md-12')
        $('.shop-product').closest('.inner-container').addClass('row row-cols-1 row-cols-md-3')
    })

}