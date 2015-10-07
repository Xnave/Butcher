
function highlight(e) {
    if (selected[0]) selected[0].className = '';
    if(e.target.parentNode.id != 'table')
    {
        e.target.parentNode.className = 'selected';
        window.location.href = '/Customers/' + e.target.parentNode.getAttribute("data-customerid");
    }
}

var table = document.getElementById('table'),
    selected = table.getElementsByClassName('selected');
table.onclick = highlight;