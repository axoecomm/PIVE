<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Carga masiva de empleados') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/empleados.js') !!}" async></script>
    <script language="javascript" type="text/javascript" src="{!! asset('js/disableSubmits.js') !!}"></script>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container" style="margin: 30px;">
                    
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <button class="btn btn-outline-secondary btn-lg" style="margin: 10px" type="button" onclick="location.href = '{{ route('empleados') }}'">Nuevo empleado</button>
                            <button class="btn btn-success btn-lg"           style="margin: 10px" type="button" onclick="location.href = '{{ route('empleadosCargaMasiva') }}'">Carga masiva</button>
                            <button class="btn btn-outline-secondary btn-lg" style="margin: 10px" type="button" onclick="location.href = '{{ route('empleadosDataTienda') }}'">Consultar tiendas</button>
                        </form>
                    </nav>
                    <div class="form-row">
                        <div class="col">
                            <h1 id="seleccionTienda"></h1>
                            <div class="flash-message">
                                @foreach (['danger', 'warning', 'success', 'info'] as $msg) 
                                @if(Session::has('alert-' . $msg)) 
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p> 
                                @endif 
                                @endforeach 
                            </div>
                        </div>
                    </div>

                    
                    
                    <hr color="blue" size=3>
                    <p>Solamente serán cargados los usuarios pertenecientes a Grupo Axo.</p>
                    <form id="cargaMasiva" method="post" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col">
                                    <label>Seleccione la tienda: </label>
                                    <select id="tiendas" name='make' class="form-control" onchange="ShowSelected();" required> 
                                        <option value='' selected>Seleccione una opción..</option>
                                        <option value='2'>Bath & Body Works</option>
                                        <option value='3'>Brooks Brothers</option>
                                        <option value='4'>Calvin Klein</option>
                                        <option value='5'>Coach</option>
                                        <option value='6'>Crate & Barrel</option>
                                        <option value='7'>Guess</option>
                                        <option value='8'>Rapsodia</option>
                                        <option value='9'>Taf</option>
                                        <option value='10'>Tommy Hilfiger</option>
                                        <option value='11'>Victoria’s Secret</option>
                                        <option value='12'>Taf QA</option>
                                        <option value='13'>Promoda QA</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label>Seleccione el archivo .CSV para cargar la información:</label>
                                    <input type="file"  class="form-control" id="file" name="file" accept=".csv, application/vnd.ms-excel" required>
                                </div>
                            </div>

                            <p></p>
                            <div class="form-row">
                                <div class="col">
                                    <p>Todos los campos son obligatorios.</p>
                                </div>
                                <div class="col">
                                    <button class="btn btn-primary btn-lg float-right" type="submit" id="btnEnviar"  >Importar Empleados</button>
                                    <!-- <button class="btn btn-primary btn-lg float-right" type="submit" id="btnEnviar" onclick="cambiarMensaje()" >Importar Empleados</button> -->
                                
                                </div>

                            </div>
                    </form>
                    
                    <hr color="blue" size=3>
                    <p></p>
                    <!--
                        <div class="form-row">
                            <div class="col">
                                <button class="btn btn-danger" onclick="history.back()">Cancelar</button>
                            </div>
                        </div>
                    
                    -->


                </div>
            </div>
        </div>
    </div>


    <!--Regular Datatables CSS-->
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <!--Responsive Extension Datatables CSS-->
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
    <!--Button Extension Datatables CSS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
    <!--Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.22/b-1.6.4/b-flash-1.6.4/b-html5-1.6.4/b-print-1.6.4/datatables.min.js"></script>
    

    
    <div class="py-12" id="data_tienda">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/empleados.css') }}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p>Empleados dados de Alta</p>
                <hr color="blue" size=3>
                <table id="example">
                    <thead>
                        <tr class="c">
                            <th>#</th>
                            <th>Email</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="container">
                            @if (isset($empleadosAlta))
                            @foreach($empleadosAlta as $k => $empleado)
                            <tr class="c">
                                <td>{{ $k+1 }}</td>
                                <td>{{ $empleado['email'] }}</td>
                                <td>{{ $empleado['nombre'] }}</td>
                                <td>{{ $empleado['apellidos'] }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    <div class="py-12" id="data_tienda1">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/empleados.css') }}">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <p>Empleados dados de baja</p><p id="demo"></p>
                <hr color="blue" size=3>
                <table id="example1">
                    <thead>
                        <tr class="c">
                            <th>#</th>
                            <th>Email</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Tienda</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="container">
                            @if (isset($empleadosBaja))
                            @foreach($empleadosBaja as $k => $empleado)
                            <tr class="c">
                                <td>{{ $k+1 }}</td>
                                <td>{{ $empleado['email'] }}</td>
                                <td>{{ $empleado['nombre'] }}</td>
                                <td>{{ $empleado['apellidos'] }}</td>
                                <td>{{ $empleado['tienda'] }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    

    
    


 

    <script type="text/javascript">
        var tmrReady = setInterval(isPageFullyLoaded, 100);
        
        function isPageFullyLoaded() {
            if (document.readyState == "loaded" || document.readyState == "complete") {
                subclassForms();
                clearInterval(tmrReady);
            }
        }
         
       function submitDisabled(_form, currSubmit) {
           return function () {
               var mustSubmit = true;
               if (currSubmit != null)
                   mustSubmit = currSubmit();
        
               var els = _form.elements;
               for (var i = 0; i < els.length; i++) {
                   if (els[i].type == "submit")
                       if (mustSubmit)
                           els[i].disabled = true;
               }
               return mustSubmit;
           }
       }
        
       function subclassForms() {
           for (var f = 0; f < document.forms.length; f++) {
               var frm = document.forms[f];
               frm.onsubmit = submitDisabled(frm, frm.onsubmit);
           }
       }
       function cambiarMensaje() {
        var texto = document.getElementById('btnEnviar');
        if (texto.textContent == 'Importar Empleados') {
            texto.textContent = 'Cargando..';
        }
        
    }

    // Definimos los campos que se han de verificar, contruimos un array con los id de los mismos
    var campos = ["tiendas", "file"];
    var c;
    function activar() {
    c = 0;
    for(var i in campos){
    i = parseInt(i);
    var cadenaL = document.getElementById(campos[i]).value;
    // hacemos un trim previo a la verificación
    cadenaL = cadenaL.replace(/^\s+/g,'').replace(/\s+$/g,'')
    if(cadenaL != ""){
    c++; // incrementamos c por cada campo que no está vacío
    }
    if(c == (i+1)){ // si c es = al total de los campos habilitamos el submit
    document.getElementById('btnEnviar').disabled = false;
    }else{
    document.getElementById('btnEnviar').disabled = true;
    }
    }
    }
     
    function validar_select(){
        var tiendas = document.getElementById('tiendas').value;
        console.log(c + '-' +campos.length );
            if(tiendas != ""){
                for(var d in campos){
                document.getElementById(campos[d]).disabled = false;
                }
                if(c== campos.length){
                document.getElementById('btnEnviar').disabled = false;
                }
            }else{
                for(var d in campos){
                document.getElementById(campos[d]).disabled = true;
                }
                document.getElementById('btnEnviar').disabled = true;
            }
        }

     
    // agregamos el evento onkeyup dinamicamente a los campos requeridos
    window.onload = function(){
        for(var e in campos){
        var elem = document.getElementById(campos[e]);
        if (elem.addEventListener){
        elem.addEventListener("keyup", function(){activar()}, false);
        }else{ // <IE9
            if (elem.attachEvent){
            elem.attachEvent ("onkeyup", function () {activar(elem)});
            }
        }
        }
    }
     
    //]]>
    </script>


    



</x-app-layout>
