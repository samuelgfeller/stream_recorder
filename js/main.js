/**
 *
 * @param table Table where it should search
 * @param row starting by 0! So 1 is the second row
 */
function filter(table,row) {
    var input, filter, tr, clientTd, i;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById(table);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        clientTd = tr[i].getElementsByTagName("td")[row];
        if (clientTd) {
            if (clientTd.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
    $("tr").css({"background-color": "#FFF"});
    $("tr:visible:odd").css({"background-color": "#f2f2f2"});
}