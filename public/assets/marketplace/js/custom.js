$(function() {
    /* PRELOADER*/
    $('.preloader-outer').delay(1000).fadeOut()
    $('.loader').delay(500).fadeOut("slow")

    $('[data-toggle="tooltip"]').tooltip()

    $(window).on('scroll', function() {
        if (document.documentElement.scrollTop > 50) {
            $('body').addClass('sticky')
        } else {
            $('body').removeClass('sticky')
        }
    })
});
