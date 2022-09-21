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

        var $select = $self.find('select').first();

        $switch.on('change', function() {

            if ($switch.is(':checked')) {

                $label.text('Nova pessoa');

                $person.addClass('d-none');

                $newPerson.removeClass('d-none');

                $inputs.attr({required:true});

                $select.attr({disabled: true});

                $inputs.removeAttr('disabled');

                $form.attr({action: window.location.origin+'/person'});

            } else {

                $label.text('Pessoa já criada')

                $person.removeClass('d-none');

                $newPerson.addClass('d-none');

                $inputs.removeAttr('required');

                $inputs.attr({disabled:true});

                $select.removeAttr('disabled');

                $form.attr({action : window.location.origin+'/admin'});

            }

        });

    });

});
