<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ordenes') }}
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
                            <p>Indique el rango de fechas en las que desea generar el reporte, se recomienda no exeder de 15 días.</p>
                        </div>
                    </div>
                    <form id="dataTableCarga" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Seleccione la fecha de inicio: </label>
                               
                            </div>
                            <div class="col">
                                <label>Seleccione la fecha de cierre: </label>
                            
                            </div>
                            <div class="col">
                                <label>Seleccione la tienda: </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <input type="date" name="fechaI" required>
                            </div>
                            <div class="col">
                                <input type="date" name="fechaF" required>
                                <!-- <input type="date" name="fechaF" min="2015-02-20" max="2015-04-24" step="7" required> -->
                            </div>
                            <div class="col">
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
                        </div>
                    <p></p>
                        <div class="row">
                            <div class="col">
                            </div>
                            <div class="col">
                                <button id="mostrarTabla" name='mostrarTabla' class="btn btn-primary">Consultar ordenes</button>
                            </div>
                            <div class="col">
                            </div>
                        </div>
                        <hr color="blue" size=3>
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
                <table id="example">
                    <thead>
                        <tr class="c">
                            <td>#</td>
                            <td>Tienda</td>
                            <td>order Id</td>
                            <td>creation Date</td>
                            <td>client Name</td>
                            <td>total Value</td>
                            <td>status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="container">
                            @foreach($ordenes as $k => $orden)
                            <tr class="c">
                                <td>{{ $k+1 }}</td>
                                <td>{{ $orden['hostname'] }}</td>
                                <td>{{ $orden['orderId'] }}</td>
                                <td>{{ utc_a_fecha($orden['creationDate']) }}</td>
                                <td>{{ $orden['clientName'] }}</td>
                                <td style="text-align: right;">${{ number_format($orden['totalValue'] / 100, 2, '.', ',') }}</td>
                                <td>{{ $orden['status'] }}</td>
                            </tr>
                            @endforeach
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
