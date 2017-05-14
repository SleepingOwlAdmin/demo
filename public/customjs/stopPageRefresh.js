$(function() {
    //DatatablesAsync sorting ang deleting without page refresh

    $('.datatables').on('submit','form', function () {
        $(this).ajaxSubmit({
            success: function() {
                $('.datatables').DataTable().api().draw();
            }
        });
        return false;
    });

});