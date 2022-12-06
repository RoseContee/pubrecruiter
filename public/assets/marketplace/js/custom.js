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

function copyClipboard(value) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(value).then(function() {
        }, function(err) {
        })
    } else {
        if (fallbackCopyTextToClipboard(value)) {
        }
    }
}

function fallbackCopyTextToClipboard(text) {
    let textArea = document.createElement("textarea")
    textArea.value = text
    textArea.style.top = "0"
    textArea.style.left = "0"
    textArea.style.position = "fixed"
    document.body.appendChild(textArea)
    textArea.focus()
    textArea.select()
    let copied = false
    try {
        document.execCommand('copy')
        copied = true
    } catch (err) {
    }
    document.body.removeChild(textArea)
    return copied
}
