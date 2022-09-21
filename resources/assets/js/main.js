$(function() {

    var $self = $(this);

    $('.modal.new-employee').each(function() {

        var $modal = $(this);

        $modal.modal({backdrop: 'static', keyboard: false});

        $modal.modal('show');

        $modal.on('click', '.btn.btn-save-employee', function() {

            $('form').trigger("submit");

            $modal.modal('hide');

        });
    });

    $('.dropdown, .dropdown-menu').on('mouseover', function() {

        var $this = $(this);

        $this.find('.dropdown-menu').show();

    }).on('mouseout', function() {

        $('.dropdown-menu').hide()
    });


    var searchParams = new URL(document.location).searchParams;


    var paramsOrder = searchParams.get('order');

    var paramsColumn = searchParams.get('column');

    $span = $self.find('.'+paramsColumn);


    if (paramsOrder == 'asc') {

        $span.eq(1).removeClass('d-none');

    } else if (paramsOrder == 'desc') {

        $span.eq(0).removeClass('d-none');

    } else {

        $span.eq(0).addClass('d-none');

        $span.eq(1).addClass('d-none');
    }

    $('.order').on('click', function () {

        var $this = $(this);

        console.log($this);

        var name = $this.data('field');
        var url = $this.data('url');
        var order = $this.data('order');

        url = url+'?column='+encodeURIComponent(name)+'&order='+encodeURIComponent(order);

        window.location.href = url;
    })

    $('.select-qty').on('change', function() {

        var $this = $(this);

        var qty = $this.find('option:selected').data('value');
        var url = $this.data('url');

        if (qty) {

            url = url+'?qtyPaginate='+encodeURIComponent(qty);

            window.location.href = url;
        }

    });

    // $('form').parsley();

    $('form').parsley({
        namespace: 'data-parsley-',
        inputs: 'input, textarea, select',

        excluded: 'input[type=button], input[type=submit], input[type=reset], input[type=hidden]',
        prorityEnabled: true,

        multiple: null,
        group: null,
        uiEnabled: true,

        validationThreshold: 3,
        focus: 'first',
        trigger: false,

        errorClass:'parsley-error',
        successClass: 'parsley-success',

        classHandler: function(Field) {},

        errosContainer: function (Field) {},

        errorsWrapper: '<div class="parsley-errors"></div>',
        errorTemplate: '<p style="color: red"></p>',

    });

});
