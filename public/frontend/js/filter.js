// const rangeInput = document.querySelectorAll(".RangeInput input"),
//     priceInput = document.querySelectorAll(".PriceInput input"),
//     range = document.querySelector(".PriceRange .PriceSlider");
// let priceGap = 50;
// rangeInput.forEach((input) => {

//     input.addEventListener("input", (e) => {
//         let minVal = parseInt(rangeInput[0].value),
//             maxVal = parseInt(rangeInput[1].value);
//         if ((maxVal - minVal) < priceGap) {
//             if (e.target.className === "min-range") {
//                 rangeInput[0].value = maxVal - priceGap;
//             } else {
//                 rangeInput[1].value = minVal + priceGap;
//             }
//         } else {
//             priceInput[0].value = minVal;
//             priceInput[1].value = maxVal;
//             range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
//             range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
//         }
//     });

//     input.addEventListener("change", (e) => {
//         filterFormSubmit()
//     });
// });

// window.addEventListener('regeneratePriceSlider', function (event) {
//     const filterMin = event?.detail?.filterMin;
//     const filterMax = event?.detail?.filterMax;
//     console.warn(event?.detail);

//     setTimeout(() => {
//         regeneratePriceSlider(filterMin, filterMax);
//     }, 10);
// });

// function regeneratePriceSlider(filterMin, filterMax) {
//     minVal = filterMin;
//     maxVal = filterMax;
//     priceInput[0].value = minVal;
//     priceInput[1].value = maxVal;

//     range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
//     range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
// }
// $('.DropdownS .dropdown-menu.Sort li').on('click', function (e) {
//     e.preventDefault();
//     var exp = $(this).html();
//     var expimg = $(this).data('img');
//     $(this).closest(".DropdownS").find('.dropdown-toggle i').text(exp);
//     $(this).closest(".DropdownS").find('.dropdown-toggle img').attr('src', expimg);

// });

// function sortFilter(sortData) {
//     $('#sort').val(sortData);
//     filterFormSubmit();
// }

getfilterData();

function filterLoaderShow() {
    let Html = "<div class='text-center'>";
    Html += '<div class="spinner-border" role="status"></div>';
    Html += "</div>";
    $('#items-list').html(Html);
}

$('#FilterBar').submit(function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    let queryString = `?${formData}`;
    getfilterData(queryString);
});

function getfilterData(queryString = '') {
    filterLoaderShow();
    $('#mobFilterBar').attr('href', '#');
    if (queryString == '') {
        const formData = window.location.search;
        queryString = `${formData}`;
    }
    $.ajax({
        url: filterURL + queryString,
        method: 'GET',
        success: function (response) {
            $('#items-list').html(response?.results);
            $('#totalRecords').html(response?.totalProducts);
            history.pushState(null, '', queryString);
            // livewireFilterLeftBar(queryString);
            $('#mobFilterBar').attr('href', '#FilterBar');
        }
    });
}

$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    let url = $(this).attr('href');
    $.ajax({
        url: url,
        method: 'GET',
        data: {},
        success: function (response) {
            $('html, body').animate({ scrollTop: 0 }, 'slow');
            $('#items-list').html(response?.results);
            $('#totalRecords').html(response?.totalProducts);
            history.pushState(null, '', url);
        }
    });
});

