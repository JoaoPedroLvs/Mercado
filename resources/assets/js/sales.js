$(function() {

    $('.page.page-sale.sale-form').each(function() {

        var $self = $(this)

        var $btnNewProduct = $self.find('.btn-new-product');

        var $select = $self.find('.select');

        $btnNewProduct.on('click', function() {

            var $btn = $(this);
            var $div = $btn.parent();
            var $products = $div.find('.products-itens');
            var $itens = $products.eq(0).clone().find("input").val("").end();
            $div.append($itens);

        });

        $self.on('click', '.btn-delete-product' , function() {

            var countItems = $self.find('.products-itens').length;

            if (countItems >= 2) {

                var $btn = $(this);
                var $div = $btn.parents('.products-itens');

                $div.remove();

            }

        });

    });
});
