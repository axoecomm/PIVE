<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Convertidor') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/empleados.js') !!}" async></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container" style="margin: 30px;">
                    <nav class="navbar navbar-light bg-light">
                        <form class="form-inline">
                            <button class="btn btn-success btn-lg" style="margin: 10px" type="button" onclick="location.href = '{{ route('convertidor') }}'">Convertir a JSON desde URL</button>
                            <button class="btn btn-outline-secondary btn-lg" style="margin: 10px" type="button" onclick="location.href = '{{ route('convertidorJson') }}'">Convertir a JSON desde JSON</button>
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
                    <div class="form-row">
                        <div class="col">
                            <p>Ingrese la URL que desea convertir.</p>
                        </div>
                        <div class="col">
                            
                        </div>
                    </div>
                    <form id="convertidorURL" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col">
                                <label>URL:</label>
                                <input type="text" class="form-control" placeholder="http://.." id="url" name="url" onkeyup="verificar(this.value);" required>
                            </div>
                        </div>
                    <p></p>
                        <div class="form-row">
                            <div class="col">
                                    <p>Todos los campos son obligatorios.</p>
                            </div>
                            <div class="col">
                               
                            </div>
                            <div class="col">
                                <button class="btn btn-primary btn-lg float-right" type="submit" id="btnEnviar">Convertir</button>
                            </div>
                        </div>
                    </form>

                    <hr color="blue" size=3>
                </div>
            </div>
        </div>
    </div> 


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container" style="margin: 30px;">
                    <hr color="blue" size=3>
                    <div class="form-row">
                        <div class="col">
                            <p><h3>Arreglo original:</h3></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            @if (! empty($response))
                            <p>{{ $response }}</p>
                            @endif
                        </div>
                    </div>
                    <hr color="blue" size=3>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container" style="margin: 30px;">
                    <hr color="blue" size=3>
                    <div class="form-row">
                        <div class="col">
                            <p><h3>Arreglo States:</h3></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            @if (! empty($response2))
                            <p>{{ $response2 }}</p>
                            @endif
                        </div>
                    </div>
                    <hr color="blue" size=3>
                </div>
            </div>
        </div>
    </div> 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container" style="margin: 30px;">
                    <hr color="blue" size=3>
                    <div class="form-row">
                        <div class="col">
                            <p><h3>Arreglo Store Default:</h3></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            @if (! empty($response3))
                            <p>{{ $response3 }}</p>
                            @endif
                        </div>
                    </div>
                    <hr color="blue" size=3>
                </div>
            </div>
        </div>
    </div> 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container" style="margin: 30px;">
                    <hr color="blue" size=3>
                    <div class="form-row">
                        <div class="col">
                            <p><h3>Arreglo Stores:</h3></p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            @if (! empty($response4))
                            <p>{{ $response4 }}</p>
                            @endif
                        </div>
                    </div>
                    <hr color="blue" size=3>
                </div>
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
        if (texto.textContent == 'Crear Empleado') {
            texto.textContent = 'Cargando..';
        }
        
    }

    // Definimos los campos que se han de verificar, contruimos un array con los id de los mismos
    var campos = ["url"];
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
