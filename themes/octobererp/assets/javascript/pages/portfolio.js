(function($) {

    var $container = $('#portfolioItems');

    $container.isotope({
        itemSelector: '.portfolio-item',
    });

    $('#filters').on('click', "a", function() {
        $(this).siblings().removeClass("active").end().addClass("active");
        var selector = $(this).attr('data-filter');
        $container.isotope({ filter: selector });
        return false;
    })

})(jQuery);
