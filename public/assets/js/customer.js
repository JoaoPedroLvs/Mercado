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


        var $label = $self.find('.label-switch');

        var $person = $self.find('.person')

        var $newPerson = $self.find('.new-person');

        var $inputs = $newPerson.find(':input');

        var $form = $self.find('form');

        $switch.on('change', function() {

            if ($switch.is(':checked')) {

                $label.text('Nova pessoa');

                $person.addClass('d-none');

                $newPerson.removeClass('d-none');

                $inputs.attr({required:true});

                // $form.attr({action: window.location.origin+'/person'});


            } else {

                $label.text('Pessoa já criada')

                $person.removeClass('d-none');

                $newPerson.addClass('d-none');

                $inputs.removeAttr('required');

                // $form.attr({action : window.location.origin+'/customer'});

            }

        });
    });
});
