var url = window.location.href;
var res = url.split('/');
var url_true = "";
for (var i = 2; i <= 4; i++) {

    if (res[i] == 'add' || res[i] == 'edit' || res[i] == 'view' || res[i] == 'sent' || res[i] == 'trash' || res[i] == 'fav_message') {
        url_true += '/index';
    } else {
        url_true += '/' + res[i];
    }
}
url = res[0] + '/' + url_true;

if ($("a[href$='" + url + "']").parent().parent().attr('class') == 'treeview-menu') {
    $("a[href$='" + url + "']").parent().parent().css('display', 'block');
    $("a[href$='" + url + "']").parent().parent().parent().addClass('active');
    $("a[href$='" + url + "']").parent().addClass('active');
} else {
    $("a[href$='" + url + "']").parent().addClass('active');
}

toast = function (message, type = 'success') {
    toastr[type](message);
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "500",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $('.toast-message').html(message); //this is over ride method
}