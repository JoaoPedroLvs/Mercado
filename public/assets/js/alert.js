$(function(){

    var alertDelete = function($element) {

        var delay = 5000;

        setTimeout(function() {

            setTimeout(function() {

                $element.remove();

            }, 500);

        }, delay);
    }

    $('.alert-container').each(function() {

        alertDelete($(this));

    });


});