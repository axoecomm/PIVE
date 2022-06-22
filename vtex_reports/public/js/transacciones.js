/*
Funciones de empleados. carga masiva y data tienda.
*/ 

$(document).ready(function () {
  window.setTimeout(function() {
      $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
          $(this).remove(); 
      });
  }, 5000);
  });
function ShowSelected(){
/* Para obtener el valor */
var cod = document.getElementById("tiendas").value;
/* Para obtener el texto */
var combo = document.getElementById("tiendas");
var selected = combo.options[combo.selectedIndex].text;
  if (cod === "") {
      document.getElementById("seleccionTienda").innerHTML = "";
  } else {
      document.getElementById("seleccionTienda").innerHTML = selected;
      document.getElementById("idTienda").innerHTML = cod;
  }
}

/*
Funcion de Data Tienda
*/ 

$( function() {
  $("#tiendas").change( function() {
      if ($(this).val() === "") {
          $("#mostrarTabla").prop("disabled", true);
      } else {
          $("#mostrarTabla").prop("disabled", false);
          var cod = document.getElementById("tiendas").value;
          var combo = document.getElementById("tiendas");
      }
  });
});
//exportar tabla
$(document).ready(function () {
  let table = $('#example').DataTable({
      responsive: true,
      dom: 'Blfrtip',
      buttons: [
          'excel', 
      ]
  }).columns.adjust().responsive.recalc();
});


window.onload=function() {
    //Bloquear fecha 2 hasta seleccionar fecha 1
    var bloq = document.querySelector("#fechaF");
    bloq.setAttribute("disabled",  true);
    
    //Precargar la fecha actual, restar un dia y restringir el date de dias posteriores
    var limiteF = new Date();
    limiteF.setDate(limiteF.getDate() - 1);

    const d = new Date(limiteF);
    const anio = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
    const mes = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d);
    const dia = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
    var fechaLimite = `${anio}-${mes}-${dia}`; 
    console.info("La fecha maxima es: " + fechaLimite);

    var limiteFecha = document.querySelector("#fechaI");
    limiteFecha.setAttribute("max",  fechaLimite);

    var limiteFecha = document.querySelector("#fechaF");
    limiteFecha.setAttribute("max",  fechaLimite);
}
//recuperar el dia seleccionado inicial y sumarle 14 días para setearlo el date 2
$('.fechaI').on('change',function(){
    var fecha1 = new Date($('.fechaI').val());
    var fecha2 = new Date($('.fechaI').val());
    
    fecha1.setDate(fecha1.getDate());
    var dias = 15;
    fecha2.setDate(fecha1.getDate() - dias);
    fecha1.setDate(fecha1.getDate() + 1);

    var seteof2 = document.querySelector("#fechaI");

    const d1 = new Date(fecha1);
    const anio1 = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d1);
    const mes1 = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d1);
    const dia1 = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d1);
    
    console.info("La fecha 1 seleccionada es: " + `${anio1}-${mes1}-${dia1}`);
    var fechaC1 = `${anio1}-${mes1}-${dia1}`; 
    seteof2.setAttribute("value",  fechaC1);

    const d2 = new Date(fecha2);
    const anio2 = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d2);
    const mes2 = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d2);
    const dia2 = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d2);
    console.info("La fecha 2 limitada es: " + `${anio2}-${mes2}-${dia2}`);

    var fechaFinal = `${anio2}-${mes2}-${dia2}`; 
    console.info(fechaFinal);
    var seteof1 = document.querySelector("#fechaF");
    var seteof3 = document.querySelector("#fechaF");
    //var seteof2 = document.querySelector("#fechaI");
    var valor = document.querySelector("#fechaF");
    var bloq = document.querySelector("#fechaF");

    seteof1.setAttribute("min",  fechaFinal);
    seteof3.setAttribute("value",  fechaC1);
    bloq.removeAttribute("disabled");
    console.info(seteof2);
    console.info(valor);

});



$('.fechaF').on('change',function(){
    var seteof2 = document.querySelector("#fechaF");
    

    var fecha2 = new Date($('.fechaF').val());
    fecha2.setDate(fecha2.getDate() + 1);
    
    const d2 = new Date(fecha2);
    const anio2 = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d2);
    const mes2 = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(d2);
    const dia2 = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d2);
    console.info("La fecha 2 de 2da funcion limitada es: " + `${anio2}-${mes2}-${dia2}`);
    var fechaFinal = `${anio2}-${mes2}-${dia2}`; 
    seteof2.setAttribute("value",  fechaFinal);
    var valor = document.querySelector("#fechaF");
    console.info(valor);


});
