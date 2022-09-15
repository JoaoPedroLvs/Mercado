$(function(){

    $('.page.page-admin.page-form').each(function() {
        var $self = $(this);

        var $switch = $self.find('.switch');

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

                $form.attr({action: window.location.origin+'/person'});


            } else {

                $label.text('Pessoa já criada')

                $person.removeClass('d-none');

                $newPerson.addClass('d-none');

                $inputs.removeAttr('required');

                $form.attr({action : window.location.origin+'/admin'});

            }

        });

    });

});
