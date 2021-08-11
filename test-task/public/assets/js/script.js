$(document).ready(function()
{
    mainSelect();
    actionSelect();
    roleSelect();
})
function mainSelect() {
    $("#main-select").on("change", function () {
        var path = $(this).val();
        window.location.href = "/" + path;
    })
}
function actionSelect() {
    $("#action-select").on("change", function () {
        var data = $(this).serialize();
        var id = $(this).val();
        $.ajax(
            {
                url: '/table/action',
                method: 'GET',
                dataType: 'html',
                data: {data: data, id:id},
                success: function(result){
                    $('#result-action').html(result);
                }
            })
    })
}
function roleSelect() {
    $("#role-select").on("change", function () {
        var data = $(this).serialize();
        var id = $(this).val();
        $.ajax(
            {
                url: '/table/role',
                method: 'GET',
                dataType: 'html',
                data: {data: data, id:id},
                success: function(result){
                    $('#result-role').html(result);
                }
            })
    })
}