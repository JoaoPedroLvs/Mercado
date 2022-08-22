$(function(){

    $('.page.sale.form').each(function() {

        var $self = $(this)

        var $btnNewProduct = $self.find('.new.product');

        $btnNewProduct.on('click', function(){

            var $btn = $(this);
            var $div = $btn.parent();
            var $products = $div.find('.products.itens');
            var $itens = $products.eq(0).clone().find("input").val("").end();
            $div.append($itens);

        });

        $self.on('click', '.btn-delete-product' , function(){

            var countItems = $self.find('.products.itens').length;

            if (countItems >= 2) {

                var $btn = $(this);
                var $div = $btn.parent();

                $div.remove();

            }

        });

    });
});
