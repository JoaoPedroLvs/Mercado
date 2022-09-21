$(function () {

    $('.page-product.page-form').each(function() {

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

        });

    });

    $('.page.page-products.page-cart').each(function() {

        var $self = $(this);

        var $sale = $self.find('.sale');

        $sale.on('click', function(e) {

            e.preventDefault();

            $self.find('.sale-form').trigger('submit');

        });

    });

});
