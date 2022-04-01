var lg = window.matchMedia("(max-width: 992px)")
var sm = window.matchMedia("(max-width: 576px)")
var tab = null

var url = window.location.origin + window.location.pathname

$(document).ready(function () {
    tab = new URLSearchParams(window.location.search).get('tab')
    sm.onchange = display
    lg.onchange = display
    
    display()
    
})


function display() {
    if (sm.matches) {
        if (tab != null) {
            $('.side-nav').addClass('hidden')
            $('#content-page').children('article').find('.back-button').removeClass('hidden')
        } else {
            $('#content-page').children('article').find('.back-button').removeClass('hidden')
        }
    } else if (lg.matches){
        $('#content-page').children('article').find('.back-button').addClass('hidden')
        $('.side-nav').removeClass('hidden')
        $('#right-content-page').addClass('hidden')
        $('#left-content-page').addClass('col-sm-3')
    } else {
        $('#content-page').children('article').find('.back-button').addClass('hidden')
        $('#right-content-page').removeClass('hidden')
        $('.side-nav').removeClass('hidden')
    }
}

