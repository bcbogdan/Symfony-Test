$(function () {
    $('#admin-tabs').tabs();
});
function adminGrid() {
    $("#grid-users").jqGrid({
        url: '/admin/users/find',
        colNames: ['Username', 'Roles', 'Password'],
        colModel: [
            {name: 'username', index: 'username', editable: true},
            {'name': 'roles', index: 'roles', editable: true},
            {'name': 'password', index: 'password', editable: true}
        ],
        pager: '#pager-users',
        datatype: "json",
        viewrecords: true,
        editurl: '/admin/users/edit',
        autowidth: true,
        height: 'auto'
    });
    $("#grid-users").jqGrid('navGrid',
        '#pager-users',
        {edit: true, add: true, del: true}
    );
    $("#grid-users").jqGrid('inlineNav', "#grid-users");
}