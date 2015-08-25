$(function () {
    $('#dashboard').jqDesktop({
        iconWidth: 70,
        iconHeight: 70
    });
    $('.window').each(function () {
        var route = $(this).data('route');
        var jqWindow = $(this).jqWindow({
            icon: $(this).data('icon'),
            width: 800,
            height: 500}
                );
        $('#dashboard').jqDesktop('addWindow', jqWindow);
        jqWindow[0].bind('windowFirstOpen', function () {
            $(this).jqWindow('setContent', '<iframe src="' + route + '" ></iframe>');
        });
    });

    $('#dashboard .jqdesktop-statusbar').append($('#logout').button());
    var loginWindow = $('#div-login').jqWindow({
        width: 300,
        height: 150,
        visible: true,
        showInTaskBar: false,
        showDesktopIcon: false,
        resizable: false,
        maximizable: false,
        closable: false,
        minimizable: false
    });
    $('#dashboard').jqDesktop('addWindow', loginWindow);
});