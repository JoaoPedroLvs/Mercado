$(function(){

    $('.page.page-users.page-form').each(function() {
        var $self = $(this);

        var $switch = $self.find('.switch');

        $password = $self.find('.password');

        $switch.on('change', function() {

            if ($switch.is(':checked')) {

                $password.removeClass('d-none');
                $password.children('input').prop('required', true);

            } else {

                $password.addClass('d-none');
                $password.children('input').prop('required',false);
            }

        });

        $self.find('.checkbox').on('change', function() {

            var $checkbox = $(this);

            var $this = $(this);

            var type = $this.data('type');

            var $select = $this.parents('.row').find(`.${type}`);

            if ($checkbox.is(':checked')) {

                $select.removeClass('d-none');

            } else {

                $select.addClass('d-none');

            }
        })


    });

});
