$('#example5').Tabledit({
    url: 'example.php',
    rowIdentifier: 'data-id',
    editButton: false,
    restoreButton: false,
    buttons: {
        delete: {
            class: 'btn btn-sm btn-danger',
            html: '<span class="glyphicon glyphicon-trash"></span> &nbsp DELETE',
            action: 'delete'
        },
        confirm: {
            class: 'btn btn-sm btn-default',
            html: 'Are you sure?'
        }
    },
    columns: {
        identifier: [0, 'id'],
        editable: [[1, 'nickname'], [2, 'firstname'], [3, 'lastname']]
    }
});

