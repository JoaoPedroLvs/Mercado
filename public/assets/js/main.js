$(function() {

    $self = $(this);

    $('.modal.new-employee').each(function() {

        var $modal = $(this);

        $modal.modal({backdrop: 'static', keyboard: false});

        $modal.modal('show');

        $modal.on('click', '.btn.btn-save-employee', function() {

            $('form').trigger("submit");

            $modal.modal('hide');


            // if ($('form').first().trigger("submit")) {


            // }


        });
    });

});
