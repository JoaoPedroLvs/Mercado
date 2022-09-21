$(function() {

    $('.page.page-people.page-index').each(function() {

        var $self = $(this);

        var $delete = $self.find('.delete');

        $delete.on('click', function() {

            $this = $(this);

            bootbox.dialog({
                message: "Isso irá remover tudo relacionado à está pessoa?",
                title: "Deletar pessoa",
                onEscape: function() {},
                show: true,
                backdrop: "static",
                onEscape: false,
                closeButton: false,
                animate: true,
                className: "my-modal",
                buttons: {
                success: {
                    label: "Cancelar",
                    className: "btn-outline-primary",
                    callback: function() {}
                },
                delete: {
                    label: "Deletar",
                    className: "btn-outline-danger",
                    callback: function() {

                        window.location.replace(window.location.origin+'/'+$this.data('url'));

                    }
                }}
            });

        });

    });



});
