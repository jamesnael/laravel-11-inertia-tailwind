$("#upload").change(function () {
    var fileName = $(this).val().split("\\").pop(); // Dapatkan nama file dari path
    $("#fileName").text("Nama File: " + fileName);
});

$(window).scroll(function () {
    var sticky = $(".header"),
        scroll = $(window).scrollTop();

    if (scroll >= 30) sticky.addClass("scroller");
    else sticky.removeClass("scroller");
});

$(".menu-mobile").click(function (e) {
    e.preventDefault();
    $(".icon-humnurger").toggleClass("ico-menu ico-close");
    $(".menu-popup").toggleClass("show");
    $("body").toggleClass("no-scroll");
});

(function ($) {
    var Defaults = $.fn.select2.amd.require("select2/defaults");

    $.extend(Defaults.defaults, {
        searchInputPlaceholder: "",
    });

    var SearchDropdown = $.fn.select2.amd.require("select2/dropdown/search");

    var _renderSearchDropdown = SearchDropdown.prototype.render;

    SearchDropdown.prototype.render = function (decorated) {
        // invoke parent method
        var $rendered = _renderSearchDropdown.apply(
            this,
            Array.prototype.slice.apply(arguments)
        );

        this.$search.attr(
            "placeholder",
            this.options.get("searchInputPlaceholder")
        );

        return $rendered;
    };
})(window.jQuery);

$(".country").select2({
    theme: "bootstrap-5",
    searchInputPlaceholder: "Search a country...",
    language: {
        noResults: function () {
            return "No result";
        },
    },
});
$(".filter-country").select2({
    theme: "bootstrap-5",
    placeholder: "Country",
    minimumResultsForSearch: -1,
});

$(".filter-status").select2({
    theme: "bootstrap-5",
    placeholder: "Status",
    minimumResultsForSearch: -1,
});

$(".filter-category").select2({
    theme: "bootstrap-5",
    placeholder: "All Categories",
    minimumResultsForSearch: -1,
});

$(".laws-flag").select2({
    theme: "bootstrap-5",
    placeholder: "All Categories",
    minimumResultsForSearch: -1,
    templateResult: formatState,
    templateSelection: formatSelected
})
.trigger("change");

$(".see-more").click(function (e) {
    e.preventDefault();
    $(".second-page-content").toggleClass("show");
    var x = $(this);
    if (x.text() === "SEE MORE") {
        x.text("SEE LESS");
    } else {
        x.text("SEE MORE");
    }
});

function formatState(state) {
    if (!state.id) {
        return state.text;
    }
    var url_image = $(state.element).attr('img');
    var baseUrl = "images/flag";
    var fileName =
        state.element.value.toLowerCase().replace(/\s+/g, "-") + ".svg";
    var $state = $(
        '<span><img src="' +
            url_image +
            '" class="img-flag" /> ' +
            state.text +
            "</span>"
    );
    return $state;
}

function formatSelected(state) {
    if (!state.id) {
        return state.text;
    }

    var url_image = $(state.element).attr('img');

    var baseUrl = "images/flag";
    var fileName = state.id.toLowerCase().replace(/\s+/g, "-") + ".svg";

    var $state = $(
        '<span class="d-flex align-items-center gap-2"><img src="' +
            url_image +
            '" class="img-flag" /> ' +
            state.text +
            "</span>"
    );

    return $state;
}

$(document).ready(function () {
    $(".accordion-item").on("click", function () {
        $(this)
            .closest(".accordion")
            .find(".accordion-item")
            .not(this)
            .removeClass("active");
        $(this).addClass("active");
    });
});
