$(function(){

    $('.page.page-admin.page-form').each(function() {
        var $self = $(this);

        var $switch = $self.find('.switch');


        $password = $self.find('.password');

        $switch.on('change', function() {

            if ($switch.is(':checked')) {

                $password.removeClass('d-none');
                $password.children('input').prop('required',true);

            } else {

                $password.addClass('d-none');
                $password.children('input').prop('required',false);
            }

        });

    });

});
