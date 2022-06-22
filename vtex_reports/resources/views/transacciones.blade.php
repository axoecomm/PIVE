<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transacciones') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/transacciones.js') !!}" async></script>
    
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
                            <p>Seleccione la tienda e indique el rango de fechas en las que desea generar el reporte, te recordamos que solo se pueden generar de un día anterior como máximo.</p>
                        </div>
                    </div>
                    <form id="transacciones" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label>Seleccione la tienda: </label>
                            </div>
                            <div class="col">
                                <label>Seleccione la fecha de corte: </label>
                               
                            </div>
                            <div class="col">
                                <label>Seleccione la fecha de inicio: </label>
                            
                            </div>
                        </div>
                        <div class="row">
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
                            <div class="col">
                                <input type="date" id="fechaI" name="fechaI" class="fechaI" placeholder="DD/MM/AAAA" required>
                                
                            </div>
                            <div class="col">
                                <input type="date" id="fechaF" name="fechaF" class="fechaF" placeholder="DD/MM/AAAA" required>
                            </div>
                        </div>
                    <p></p>
                        <div class="row">
                            <div class="col">

                            </div>
                            <div class="col">
                               
                            </div>
                            <div class="col">
                                <button id="mostrarTabla" name='mostrarTabla' class="btn btn-primary btn-lg float-right" disabled>Generar reporte</button>
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
            <div class="bg-white overflow-scroll shadow-xl sm:rounded-lg" >
                <table id="example">
                    <thead>
                        <tr class="c">
                            <th>#</th>
                            <th>ID</th>
                            <th>referenceKey</th>
                            <th>id</th>
                            <th>transactionId</th>
                            <th>paymentSystemId</th>
                            <th>paymentSystemName</th>
                            <th>group</th>
                            <th>value</th>
                            <th>installments</th>
                            <th>status</th>
                            <th>authorizationToken</th>
                            <th>authorizationDate</th>
                            <th>referenceValue</th>
                            <th>installmentsValue</th>
                            <th>installmentsInterestRate</th>
                            <th>keyVersion</th>
                            <th>connectorName</th>
                            <th>antifraudImplementation</th>
                            <!--
                            <th>settlements</th>
                            <th>autoSettlements</th>
                            <th>refunds</th>
                            <th>cancels</th>
                            -->
                            <th>tid</th>
                            <th>accountId</th>
                            <th>originalPaymentId</th>
                            <th>currencyCode</th>
                            <th>totalRefunds</th>
                            <th>status</th>
                            <th>value</th>
                            <th>startDate</th>
                            <th>authorizationToken</th>
                            <th>authorizationDate</th>
                            <th>commitmentToken</th>
                            <th>commitmentDate</th>
                            <th>refundingToken</th>
                            <th>refundingDate</th>
                            <th>cancelationToken</th>
                            <th>cancelationDate</th>
                            <th>clientProfile</th>
                            <th>ipAddress</th>
                            <th>antifraudTid</th>
                            <th>id</th>
                            <th>name</th>
                            <th>channel</th>
                            <th>salesChannel</th>
                            <th>urn</th>
                            <th>softDescriptor</th>
                            <th>vtexFingerprint</th>
                            <th>chargeback</th>
                            <th>whiteSignature</th>
                            <th>firstName</th>
                            <th>lastName</th>
                            <th>documentType</th>
                            <th>document</th>
                            <th>email</th>
                            <th>address</th>
                            <th>phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <div class="container">
                            @if (isset($transacciones))
                            @foreach($transacciones as $k => $transaccion)
                            <tr class="c">
                                <td>{{ $k+1 }}</td>
                                <td>{{ $transaccion['id'] }}</td>
                                <td>{{ $transaccion['referenceKey'] }}</td>
                                @foreach($transaccion['payments'] as $k => $payment)
                                    <td>{{ $payment['id'] }}</td>
                                    <td>{{ $payment['transactionId'] }}</td>
                                    <td>{{ $payment['paymentSystemId'] }}</td>
                                    <td>{{ $payment['paymentSystemName'] }}</td>
                                    <td>{{ $payment['group'] }}</td>
                                    <td>{{ $payment['value'] }}</td>
                                    <td>{{ $payment['installments'] }}</td>
                                    <td>{{ $payment['status'] }}</td>
                                    <td>{{ $payment['authorizationToken'] }}</td>
                                    <td>{{ $payment['authorizationDate'] }}</td>
                                    <td>{{ $payment['referenceValue'] }}</td>
                                    <td>{{ $payment['installmentsValue'] }}</td>
                                    <td>{{ $payment['installmentsInterestRate'] }}</td>
                                    <td>{{ $payment['keyVersion'] }}</td>
                                    <td>{{ $payment['connectorName'] }}</td>
                                    <td>{{ $payment['antifraudImplementation'] }}</td>

                                    <td>{{ $payment['tid'] }}</td>
                                    <td>{{ $payment['accountId'] }}</td>
                                    <td>{{ $payment['originalPaymentId'] }}</td>
                                    <td>{{ $payment['currencyCode'] }}</td>
                                @endforeach
                                <td>{{ $transaccion['totalRefunds'] }}</td>
                                <td>{{ $transaccion['status'] }}</td>
                                <td>{{ $transaccion['value'] }}</td>
                                <td>{{ $transaccion['startDate'] }}</td>
                                <td>{{ $transaccion['authorizationToken'] }}</td>
                                <td>{{ $transaccion['authorizationDate'] }}</td>
                                <td>{{ $transaccion['commitmentToken'] }}</td>
                                <td>{{ $transaccion['commitmentDate'] }}</td>
                                <td>{{ $transaccion['refundingToken'] }}</td>
                                <td>{{ $transaccion['refundingDate'] }}</td>
                                <td>{{ $transaccion['cancelationToken'] }}</td>
                                <td>{{ $transaccion['cancelationDate'] }}</td>
                                <td>{{ $transaccion['clientProfile'] }}</td>
                                <td>{{ $transaccion['ipAddress'] }}</td>
                                <td>{{ $transaccion['antifraudTid'] }}</td>
                                <td>{{ $transaccion['merchant']['id'] }}</td>
                                <td>{{ $transaccion['merchant']['name'] }}</td>
                                <td>{{ $transaccion['channel'] }}</td>
                                <td>{{ $transaccion['salesChannel'] }}</td>
                                <td>{{ $transaccion['urn'] }}</td>
                                <td>{{ $transaccion['softDescriptor'] }}</td>
                                <td>{{ $transaccion['vtexFingerprint'] }}</td>
                                <td>{{ $transaccion['chargeback'] }}</td>
                                <td>{{ $transaccion['whiteSignature'] }}</td>
                                <td>{{ $transaccion['buyer']['firstName'] }}</td>
                                <td>{{ $transaccion['buyer']['lastName'] }}</td>
                                <td>{{ $transaccion['buyer']['documentType'] }}</td>
                                <td>{{ $transaccion['buyer']['document'] }}</td>
                                <td>{{ $transaccion['buyer']['email'] }}</td>
                                <td>{{ $transaccion['buyer']['address'] }}</td>
                                <td>{{ $transaccion['buyer']['phone'] }}</td>
                            </tr>
                            @endforeach
                            @endif
                        </div>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    
</x-app-layout>
