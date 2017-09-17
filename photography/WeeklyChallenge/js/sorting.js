/* SORTING */

jQuery(function () {
    if (jQuery('.fs_blog_module').size() > 0) {
        var $container = jQuery('.fs_blog_module');
    } else {
        var $container = jQuery('.fs_grid_portfolio');
    }

    $container.isotope({
        itemSelector: '.element'
    });

    var $optionSets = jQuery('.blog_filter'),
        $optionLinks = $optionSets.find('a'),
        $showAll = jQuery('.show_all');

    $optionLinks.on('click', function () {
        var $this = jQuery(this);
        // don't proceed if already selected
        if ($this.parent('li').hasClass('selected')) {
            return false;
        }
        var $optionSet = $this.parents('.blog_filter');
        $optionSet.find('.selected').removeClass('selected');
        $this.parent('li').addClass('selected');
		if ($this.attr('data-option-value') == "*") {
			$container.removeClass('now_filtering');
		} else {
			$container.addClass('now_filtering');
		}

        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[key] = value;
        if (key === 'layoutMode' && typeof changeLayoutMode === 'function') {
            // changes in layout modes need extra logic
            changeLayoutMode($this, options)
        } else {
            // otherwise, apply new options
            $container.isotope(options);
        }
        return false;
    });

    if (jQuery('.fs_blog_module').size() > 0) {
        jQuery('.fs_blog_module').find('img').load(function () {
            $container.isotope('reLayout');
        });
    } else {
        jQuery('.fs_grid_portfolio').find('img').load(function () {
            $container.isotope('reLayout');
        });
    }
});

jQuery(window).load(function () {
    if (jQuery('.fs_blog_module').size() > 0) {
        jQuery('.fs_blog_module').isotope('reLayout');
        setTimeout("jQuery('.fs_blog_module').isotope('reLayout')", 500);
    } else {
        jQuery('.fs_grid_portfolio').isotope('reLayout');
        setTimeout("jQuery('.fs_grid_portfolio').isotope('reLayout')", 500);
    }
    jQuery('.blog_filter a').on('click', function () {
        setTimeout("jQuery('.fs_blog_module').isotope('reLayout')", 800);
    });
});
jQuery(window).resize(function () {
    if (jQuery('.fs_blog_module').size() > 0) {
        jQuery('.fs_blog_module').isotope('reLayout');
    } else {
        jQuery('.fs_grid_portfolio').isotope('reLayout');
    }
});