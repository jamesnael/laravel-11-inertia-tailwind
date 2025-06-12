$("body").on("click", ".reference .accordion-item", function (e) {
    if ($(this).hasClass("reference-opened")) {
        $(this).removeClass("reference-opened");
    } else {
        $(".reference .accordion-item").each(function (e) {
            $(this).removeClass("reference-opened");

            $(this).find(".accordion-collapse").removeClass("show");
        });

        $(this).addClass("reference-opened");
        $(`${$(this).data("show")}`).addClass("show");
    }
});

const tableHeaders = document.querySelectorAll(".flexi-wrapper .table th");

tableHeaders.forEach((items) => {
    if (
        parseInt(items.getAttribute("rowspan")) > 1 ||
        parseInt(items.getAttribute("colspan")) > 1
    ) {
        items.style.verticalAlign = "middle";
    }
});

const tableBody = document.querySelectorAll(".flexi-wrapper .table td");

tableBody.forEach((items) => {
    if (
        parseInt(items.getAttribute("rowspan")) > 1 ||
        parseInt(items.getAttribute("colspan")) > 1
    ) {
        items.style.verticalAlign = "middle";
    }
});

const tables = document.querySelectorAll("table tbody");

tables.forEach((table) => {
    const children = table.children;

    // get first children row
    const firstGrandChildren = children[0].children;
    // get second children row
    const secondGrandChildren = children[1].children;
    // get third children row
    const thirdGrandChildren = children[2].children;

    // row is merged with header
    if (firstGrandChildren.length != secondGrandChildren.length) {
        for (let i = 0; i < firstGrandChildren.length; i++) {
            firstGrandChildren[i].classList.add("merged-header");
            firstGrandChildren[i].childNodes[0].style.color = "#fff";
        }
    }

    // if (thirdGrandChildren.length) {
    //     if (secondGrandChildren.length != thirdGrandChildren.length) {
    //         for (let i = 0; i < secondGrandChildren.length; i++) {
    //             secondGrandChildren[i].classList.add("merged-header");
    //             secondGrandChildren[i].childNodes[0].style.color = "#fff";
    //         }
    //     }
    // }
});

$(".section-filter").select2({
    theme: "bootstrap-5",
    placeholder: "All",
    minimumResultsForSearch: -1,
    width: "180px",
    height: "40px",
});

$(".search-country-filter").select2({
    theme: "bootstrap-5",
    placeholder: "All",
    searchInputPlaceholder: "Search a country...",
    language: {
        noResults: function () {
            return "No result";
        },
    },
    dropdownCssClass: "country-filter-dropdown",
    width: "180px",
    height: "40px",
});

$(".section-filter-mobile").select2({
    theme: "bootstrap-5",
    placeholder: "All",
    minimumResultsForSearch: -1,
    width: "100%",
    height: "40px",
    dropdownCssClass: "mobile-filter-dropdown",
});

$(".search-country-filter-mobile").select2({
    theme: "bootstrap-5",
    placeholder: "All",
    searchInputPlaceholder: "Search a country...",
    language: {
        noResults: function () {
            return "No result";
        },
    },
    dropdownCssClass: "mobile-filter-dropdown",
    width: "100%",
    height: "40px",
});

$(".search-page-input").on("keydown", function (e) {
    // on enter
    if (e.which === 13) {
        e.preventDefault();
        const searchQuery = e.target.value;

        if (!searchQuery.length) {
            return Swal.fire({
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                title: "Oops...",
                text: "Please submit any search parameter!",
                customClass: {
                    confirmButton: "bg-primary",
                },
            });
        }

        let targetUrl = `${searchPage}?query=${searchQuery}`;

        window.location = targetUrl;
    }
});

$("#searchInputMobile").on("keydown", function (e) {
    // on enter
    if (e.which === 13) {
        e.preventDefault();
        const searchQuery = e.target.value;

        if (!searchQuery.length) {
            return Swal.fire({
                icon: "error",
                allowOutsideClick: false,
                allowEscapeKey: false,
                title: "Oops...",
                text: "Please submit any search parameter!",
                customClass: {
                    confirmButton: "bg-primary",
                },
            });
        }

        let targetUrl = `${searchPage}?query=${searchQuery}`;

        window.location = targetUrl;
    }
});

$(".form-search-page").on("submit", function (e) {
    e.preventDefault();
    const searchQuery = $(".page-search").val();

    if (!searchQuery.length) {
        return Swal.fire({
            icon: "error",
            allowOutsideClick: false,
            allowEscapeKey: false,
            title: "Oops...",
            text: "Please submit any search parameter!",
            customClass: {
                confirmButton: "bg-primary",
            },
        });
    }

    let targetUrl = `${searchPage}?query=${searchQuery}`;

    window.location = targetUrl;
});

$(".see-more-desktop").on("click", function (e) {
    e.preventDefault();

    const selectedSection = $("#searchInputSection").val();
    const selectedCountry = $('#searchInputCountry').val();

    let hidden = $(".desktop-result > .hide-search");

    if (selectedSection != "All") {
        // change hidden item by selected section class
        hidden = $(`.desktop-result > .${selectedSection}.hide-search`);
    }

    if (selectedCountry != 'All') {
        hidden = [...hidden].filter(item => {
            const ids = item.dataset.country.split(',');

            return ids.includes(selectedCountry);
        });
    }

    // get 5 hidden search results
    hidden = hidden.slice(0, 5);

    // show hidden result
    [...hidden].forEach(function (elem) {
        elem.classList.remove("hide-search");
    });

    // check remaining hidden
    let remains = $(".desktop-result > .hide-search");

    if (selectedSection != "All") {
        // check remaining hidden selected section
        remains = $(`.desktop-result > .${selectedSection}.hide-search`);
    }

    if (selectedCountry != 'All') {
        // check remaining hidden selected country
        remains = [...remains].filter(item => {
            const ids = item.dataset.country.split(',');

            return ids.includes(selectedCountry);
        });
    }

    if (!remains.length) {
        return $(this).hide();
    }
});

$(".see-more-mobile").on("click", function (e) {
    e.preventDefault();

    const selectedSection = $("#searchInputSectionMobile").val();
    const selectedCountry = $('#searchInputCountryMobile').val();

    let hidden = $(".mobile-result > .hide-search");

    if (selectedSection != "All") {
        // change hidden item by selected section class
        hidden = $(`.mobile-result > .${selectedSection}.hide-search`);
    }

    if (selectedCountry != 'All') {
        hidden = [...hidden].filter(item => {
            const ids = item.dataset.country.split(',');

            return ids.includes(selectedCountry);
        });
    }

    // get 5 hidden search results
    hidden = hidden.slice(0, 5);

    // show hidden result
    [...hidden].forEach(function (elem) {
        elem.classList.remove("hide-search");
    });

    // check remaining hidden
    let remains = $(".mobile-result > .hide-search");

    if (selectedSection != "All") {
        // check remaining hidden selected section
        remains = $(`.mobile-result > .${selectedSection}.hide-search`);
    }

    if (selectedCountry != 'All') {
        // check remaining hidden selected country
        remains = [...remains].filter(item => {
            const ids = item.dataset.country.split(',');

            return ids.includes(selectedCountry);
        });
    }

    if (!remains.length) {
        return $(this).hide();
    }
});

// desktop section filter
$("#searchInputSection").on("change", function (e) {
    const section = $(this).val();
    const country = $('#searchInputCountry').val();

    if (section != "All") {
        let showSections = document.querySelectorAll(`.desktop-result > .${section}`);

        // check country
        if (country != 'All') {
            showSections = [...showSections].filter(item => {
                const ids = item.dataset.country.split(',');
    
                return ids.includes(country);
            });
        }

        showSections.forEach((item, index) => {
            // only show 5 sections, the rest stays hidden
            if (index > 4) {
                return false;
            }

            item.classList.remove("hide-search");
        });

        // hide results of not selected section
        const hideSections = document.querySelectorAll(`.desktop-result > div:not(.${section})`);

        hideSections.forEach((item) => item.classList.add("hide-search"));

        if (showSections.length <= 5) {
            return $(".see-more-desktop").hide();
        }

        return $(".see-more-desktop").show();
    }

    // show all
    let showSections = document.querySelectorAll(`.desktop-result > div`);

    if (country != 'All') {
        showSections = [...showSections].filter(item => {
            const ids = item.dataset.country.split(',');

            return ids.includes(country);
        });
    }

    return showSections.forEach((item, index) => {
        // only show 5 results
        if (index > 4) {
            item.classList.add("hide-search");
            $(".see-more-desktop").show();
        } else {
            item.classList.remove("hide-search");
        }
    });
});

// mobile section filter
$("#searchInputSectionMobile").on("change", function (e) {
    const section = $(this).val();
    const country = $('#searchInputCountryMobile').val();

    if (section != "All") {
        let showSections = document.querySelectorAll(`.mobile-result > .${section}`);

        // check country
        if (country != 'All') {
            showSections = [...showSections].filter(item => {
                const ids = item.dataset.country.split(',');
    
                return ids.includes(country);
            });
        }

        showSections.forEach((item, index) => {
            // only show 5 sections, the rest stays hidden
            if (index > 4) {
                return false;
            }

            item.classList.remove("hide-search");
        });

        // hide results of not selected section
        const hideSections = document.querySelectorAll(`.mobile-result > div:not(.${section})`);

        hideSections.forEach((item) => item.classList.add("hide-search"));

        if (showSections.length <= 5) {
            return $(".see-more-mobile").hide();
        }

        return $(".see-more-mobile").show();
    }

    // show all
    let showSections = document.querySelectorAll(`.mobile-result > div`);

    if (country != 'All') {
        showSections = [...showSections].filter(item => {
            const ids = item.dataset.country.split(',');

            return ids.includes(country);
        });
    }

    return showSections.forEach((item, index) => {
        // only show 5 results
        if (index > 4) {
            item.classList.add("hide-search");
            $(".see-more-mobile").show();
        } else {
            item.classList.remove("hide-search");
        }
    });
});

// desktop country filter
$('#searchInputCountry').on('change', function(e) {
    const country = $(this).val();
    const section = $('#searchInputSection').val();

    if (country != "All") {
        let showCountries = document.querySelectorAll(`.desktop-result > div`);

        if (section != 'All') {
            showCountries = document.querySelectorAll(`.desktop-result > .${section}`);
        }

        // only show items that has selected country
        const selectedCountry = [...showCountries].filter(item => {
            const ids = item.dataset.country.split(',');
            return ids.includes(country);
        });

        [...selectedCountry].forEach((item, index) => {
            // only show 5 item
            if (index < 5) {
                item.classList.remove('hide-search');
            } else {
                item.classList.add('hide-search');
            }
        });

        // hide all item if not included in selected countries
        [...showCountries].forEach((item, index) => {
            const ids = item.dataset.country.split(',');

            if (!ids.includes(country) || ids[0] == '') {
                item.classList.add('hide-search');
            }
        });

        // count selected country item
        if (selectedCountry.length <= 5) {
            return $(".see-more-desktop").hide();
        }

        return $(".see-more-desktop").show();
    }

    // show all
    let showSections = document.querySelectorAll(`.desktop-result > div`);

    if (section != 'All') {
        showSections = document.querySelectorAll(`.desktop-result > .${section}`);
    }

    return showSections.forEach((item, index) => {
        // only show 5 results
        if (index > 4) {
            item.classList.add("hide-search");
            $(".see-more-desktop").show();
        } else {
            item.classList.remove("hide-search");
        }
    });
});

// mobile country filter
$('#searchInputCountryMobile').on('change', function(e) {
    const country = $(this).val();
    const section = $('#searchInputSectionMobile').val();

    if (country != "All") {
        let showCountries = document.querySelectorAll(`.mobile-result > div`);

        if (section != 'All') {
            showCountries = document.querySelectorAll(`.mobile-result > .${section}`);
        }

        // only show items that has selected country
        const selectedCountry = [...showCountries].filter(item => {
            const ids = item.dataset.country.split(',');
            return ids.includes(country);
        });

        [...selectedCountry].forEach((item, index) => {
            // only show 5 item
            if (index < 5) {
                item.classList.remove('hide-search');
            } else {
                item.classList.add('hide-search');
            }
        });

        // hide all item if not included in selected countries
        [...showCountries].forEach((item, index) => {
            const ids = item.dataset.country.split(',');

            if (!ids.includes(country) || ids[0] == '') {
                item.classList.add('hide-search');
            }
        });

        // count selected country item
        if (selectedCountry.length <= 5) {
            return $(".see-more-mobile").hide();
        }

        return $(".see-more-mobile").show();
    }

    // show all
    let showSections = document.querySelectorAll(`.mobile-result > div`);

    if (section != 'All') {
        showSections = document.querySelectorAll(`.mobile-result > .${section}`);
    }

    return showSections.forEach((item, index) => {
        // only show 5 results
        if (index > 4) {
            item.classList.add("hide-search");
            $(".see-more-mobile").show();
        } else {
            item.classList.remove("hide-search");
        }
    });
});

// auto resize detail banner
function setHeightImageAuto() {
    if ($('.banner-detail').length) {
        const positionImage = $('.banner-detail').offset().top;
        const heightImage = $('.banner-detail').height() * 0.5;
        const minHeightImage = positionImage + heightImage;
        const valMinHeightImage = Math.round(minHeightImage)+'px';
        $('.page-header').css('min-height', valMinHeightImage);
    }
}

$(document).ready(function() {
    setHeightImageAuto();
});

$(window).on('resize', function(){
    setHeightImageAuto();
});

$('.copy-link').on('click', async function(e) {
    e.preventDefault();

    const url = $(this).attr('href');
    try {
        const copy = await navigator.clipboard.writeText(url);
        return Swal.fire({
            icon: "success",
            allowOutsideClick: false,
            allowEscapeKey: false,
            title: "Success",
            text: "The link has been copied to your clipboard!",
            customClass: {
                confirmButton: "bg-primary",
            },
        });
    } catch (err) {
        console.log(err);
        return Swal.fire({
            icon: "error",
            allowOutsideClick: false,
            allowEscapeKey: false,
            title: "Oops..",
            text: "An error has occurred!",
            customClass: {
                confirmButton: "bg-primary",
            },
        });
    }
});