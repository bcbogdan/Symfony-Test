$(function () {
    setupUi();
});
function setupUi() {
    $(':input').addClass('ui-widget-content');
    $('input[type="submit"], .button, #footer a').button();
    $('th').addClass('ui-widget-header');
    $('.tree').menu();
}

$(document).ready(function() {
    $('.ui-button').click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');

        var components = url.split("/");

        url = "ajax" + "/" + components[4];
        $.ajax({
            type: "POST",
            dataType: 'text',
            url: url,
            success: function(response) {
                $('#dialog').dialog().html(response);
            }
        });

    })
})