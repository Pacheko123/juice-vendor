$('.remove').on('click', function () {
    return confirm('Are you sure?');
});
$('.order').on('click', function () {
    return confirm('Are you sure to place this order?');
});

$('#order_status').on('change', function () {
    var domain = 'http://localhost';
    var pathname = window.location.pathname;
    var stock = $('#stock_type').val();

    if ($(this).val()) {
        var full_url = domain + pathname + '?status=' + $(this).val();
        if (stock) {
            full_url = full_url + '&stock=' + stock;
        }
        window.location.href = full_url;
    } else {
        window.location.href = domain + pathname;
    }
});

$('#stock_type').on('change', function () {
    var domain = 'http://localhost';
    var pathname = window.location.pathname;
    var status = $('#order_status').val();

    if ($(this).val()) {
        var full_url = domain + pathname + '?stock=' + $(this).val();
        if (status) {
            full_url = full_url + '&status=' + status;
        }
        window.location.href = full_url;
    } else {
        window.location.href = domain + pathname;
    }
});

$('#clear_all').on('click', function () {
    return confirm('Are you sure you want to clear all orders? This action is not reversal');
})


SetNavActive($('.list-inline li a'), 'active');

function SetNavActive(links, cls) {
    $(links).each(function (i, link) {

        link = $(link);
        var url = link.attr('href');

        var path = window.location.href;
        var file = path.substr(path.lastIndexOf("/") + 1);
        file = file.split('?')[0];

        if (file == url) {
            link.parent().addClass(cls);

        } else {
            link.parent().removeClass(cls);
        }
    });
}

function TableSearch(column) {
    var input = document.getElementById("table_search");
    var filter = input.value.toUpperCase();
    var table = document.getElementById("table");
    var tr = table.getElementsByTagName("tr");

    var i, td;

    if (!column) {
        column = 1;
    } else {
        column--
    }

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[column];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}
