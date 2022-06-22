/*
Funciones de empleados. carga masiva y data tienda.
*/

$(document).ready(function () {
    window.setTimeout(function () {
        $(".alert").fadeTo(1000, 0).slideUp(1000, function () {
            $(this).remove();
        });
    }, 5000);

    let table = $('#example').DataTable({
        responsive: true,
        dom: 'Blfrtip',
        buttons: [
            'excel',
        ]
    }).columns.adjust().responsive.recalc();

});



function ShowSelected() {
    /* Para obtener el valor */
    var cod = document.getElementById("tiendas").value;
    /* Para obtener el texto */
    var combo = document.getElementById("tiendas");

    //var combo = document.getElementById("tipoEmpleado");




    var selected = combo.options[combo.selectedIndex].text;
    if (cod === "") {
        document.getElementById("seleccionTienda").innerHTML = "";
    } else {
        document.getElementById("seleccionTienda").innerHTML = selected;
        //document.getElementById("idTienda").innerHTML = cod;
    }
}



/*
Funcion de empleados Data Tienda
*/

$(function () {
    $("#tiendas").change(function () {
        if ($(this).val() === "") {
            $("#mostrarTabla").prop("disabled", true);
        } else {
            $("#mostrarTabla").prop("disabled", false);
            var cod = document.getElementById("tiendas").value;
            var combo = document.getElementById("tiendas");
        }
    });
});


