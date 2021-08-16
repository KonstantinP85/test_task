$(document).ready(function() {
    mainSelect();
    actionSelect();
    roleSelect();
    ff();
})
function ff() {
    var entity = window.location.pathname.split("/")[1]
    if (entity !== "") {
        $("#main-select").val(entity);
    }
}
function mainSelect() {
    $("#main-select").on("change", function () {
        var path = $(this).val();
        window.location.href = "/" + path;
        $("#main-select").val(path);
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
                    var minus = $('span[id="minus"]');
                    $.each(minus, function () {
                        $(this).hide();
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
    var trAll = $('tr');
    var td = $(this).parent();
    var tr = $(td).parent();
    if($(this).is(':checked')) {
            $.ajax  (
                {
                    url: '/create',
                    method: 'GET',
                    dataType: 'html',
                    data: {action: action, object: object, role: role, oId: oId},
                    success: function (result) {
                        $(trAll).each(function(i, item) {
                            if ($(tr).attr('id')) {
                                $(trAll).each(function(i, item) {
                                    if ($(item).attr('data-id') === $(tr).attr('id')) {
                                        if ($(item).find('input[action-id="' + action+ '"').attr('action-id') === action) {
                                            $(item).find('input[action-id="' + action+ '"').prop("checked", true);
                                        }
                                    }
                                });
                            }
                            if ($(tr).attr('data-id')) {
                                console.log(oId);
                                console.log("ggg");
                            }
                        });
                    }
                })
        } else {
            $.ajax  (
                {
                    url: '/delete',
                    method: 'GET',
                    dataType: 'html',
                    data: {action: action, object: object, role: role, oId: oId},
                    success: function () {
                        console.log("ppp");
                        $(trAll).each(function(i, it) {
                            if ($(tr).attr('id')) {
                                $(trAll).each(function(i, it) {
                                    if ($(it).attr('data-id') === $(tr).attr('id')) {
                                        if ($(it).find('input[action-id="' + action+ '"').attr('action-id') === action) {
                                            $(it).find('input[action-id="' + action+ '"').prop("checked", false);
                                        }
                                    }
                                });
                            }
                        });
                    }
                })
    }}
)
$(document).on('click', '#plus', function () {
    var td = $(this).parent();
    var tr = $(td).parent().attr('id');
    var path = $(this).attr('s-name');
    var role = $('#role-select').val();
    $(td).children("#minus").show();
    $(td).children("#plus").hide();
        $.ajax(
            {
                url: '/'+path,
                method: 'GET',
                dataType: 'json',
                data: {role: role},
                success: function(result){
                    var trHTML = '';
                    $.each(result.descendants, function (i, item) {
                        trHTML += '<tr data-id=' + path + ' ';
                        if (item.parentId) {
                            trHTML += 'id='+item.parentId;
                        }
                        console.log($(td).css("padding-left"));
                        trHTML += '><td style="padding-left: calc(' + $(td).css("padding-left") + ' + 30px);">';
                            if (item.parentId) {
                                trHTML += '<span id="plus" style="cursor: pointer;" s-name=' + item.parentId + '>+</span><span id="minus" style="cursor: pointer; display: none;" s-name=' + item.parentId + '>-</span> ';
                            }
                            trHTML += item.name + '</td>';
                            var oId = item.id;
                        $.each(result.actions, function (k, it) {
                            trHTML += '<td>' + '<input id="access" object-id=' + path + ' o-id=' + oId + ' action-id=' + it.id + ' class="form-check-input" type="checkbox"';
                            anId = it.id;
                            $.each(result.accessesMatrix, function (k, i) {
                                if (i.action === anId && i.objectId === oId) {
                                    trHTML += 'checked';
                                }
                            })
                            trHTML += '></td>';
                        });
                        trHTML += '</tr>';
                    });
                    $('#'+tr).after(trHTML);
                }
            })
})
$(document).on('click', '#minus', function () {
    var objectClassId = $(this).attr('s-name');
    var td = $(this).parent();
    $(td).children("#minus").hide();
    $(td).children("#plus").show();
    var tr = $('tr');
    $(tr).each(function() {
        if ($(this).attr('data-id') === objectClassId) {
            $(this).hide();
        }
    });
})