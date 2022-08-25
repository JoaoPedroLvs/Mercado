$(function() {

    $('.page.page-form').each(function() {

        $self = $(this);

        $('.cpf').mask('000.000.000-00');

        $('.phone').mask('(00) 00000-0000');

        $('.work-code').mask('0000000/0000');

        $('.price').mask('# ##0,00', {reverse:true});

    });
});
