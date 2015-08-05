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

    var form = $('#product_history').parent();
    var path = window.location.pathname;

    form.on('submit', function(e){
        e.preventDefault();
        var id = path.split('/')[2];

        $.ajax({
            type: "POST",
            dataType: "text",
            url: Routing.generate('productacquisition_ajax_show', {id: id}),
            success: function(response) {
                $('#dialog').html(response);
                $('#dialog').dialog();

        }
        })
    })
})