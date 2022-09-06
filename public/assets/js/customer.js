$(function () {

    $('.page-customer.page-form').each(function() {

        var $self = $(this);

        var $span = $self.find('.file-input');

        $('#image').on('change', function() {

            var $this = $(this);

            var file = $this.prop('files');

            if (file.length > 0) {

                var name = file[0].name;
                $span.text(name);

            } else {

                $span.text('Nenhum arquivo selecionado');
            }

        })

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
