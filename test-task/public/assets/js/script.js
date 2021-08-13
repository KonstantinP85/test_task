$(document).ready(function() {
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
                    $("#minus").hide();
                    var html = '';
                    $( "tr" ).each(function( index ) {
                      /*  if ($(this).attr( "id" ) === 'add-tr') {
                            $(this).append('<tr>+ '<a href="#">' + "<input type='checkbox' id='" + item.ModuleID + "' name='ModuleUserViews' class='my_chkBox' />" + " " + item.ModuleName +  '</a></tr>');
                        }*/
                    })
                }
            })
    })
}
$(document).on('click', '#access', function () {
    var action = $(this).attr('action-id');
    var object = $(this).attr('object-id');
    var oId;
    if ($(this).attr('o-id')) {
        oId = $(this).attr('o-id');
    } else {
        oId = "";
    }
    var role = $('#role-select').val();
    if($(this).is(':checked')) {
        console.log(action);
            $.ajax  (
                {
                    url: '/create',
                    method: 'GET',
                    dataType: 'html',
                    data: {action: action, object: object, role: role, oId: oId},
                    success: function (result) {

                    }
                })
        } else {
            $.ajax  (
                {
                    url: '/delete',
                    method: 'GET',
                    dataType: 'html',
                    data: {action: action, object: object, role: role},
                    success: function (result) {

                    }
                })
    }}
)
$(document).on('click', '#plus', function () {
    var td = $(this).parent();
    var tr = $(td).parent().attr('id');
    var path = $(this).attr('s-name');
    var role = $('#role-select').val();
    $("#minus").show();
    $("#plus").hide();
        $.ajax(
            {
                url: '/'+path,
                method: 'GET',
                dataType: 'json',
                data: {role: role},
                success: function(result){
                    var trHTML = '';
                    $.each(result.descendants, function (i, item) {
                        trHTML += '<tr><td style="padding-left: 30px;">';
                            if (item.parentId) {
                                trHTML += '<span id="plus" style="cursor: pointer;" s-name=' + item.parentId + '>+</span><span id="minus" style="cursor: pointer; display: none;">-</span> ';
                            }
                            trHTML += item.name + '</td>';

                            var oId = item.id;
                        $.each(result.actions, function (k, it) {
                            trHTML += '<td>' + '<input id="access" object-id=' + path + ' o-id=' + oId + ' action-id=' + it.id + ' class="form-check-input" type="checkbox"';
                            anId = it.id;
                            $.each(result.accessMatrix, function (k, i) {
                                if (i.action.id === anId && i.objectId.id ===oId) {
                                    trHTML += 'checked';
                                }
                            })
                            trHTML += '></td>';
                        });
                        trHTML += '</tr>';
                    });
                    console.log(trHTML);
                    $('#'+tr).after(trHTML);
                }
            })
})