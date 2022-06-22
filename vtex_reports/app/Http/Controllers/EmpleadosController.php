<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use DB;
use App\Exports\UsersExport;
use App\Imports\EmpleadosArchivo;
use App\Imports\EmpleadosImport;
use App\Models\Empleado;
use App\Models\Empleados_masterdata;
use App\Models\Empleados_archivo;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class EmpleadosController extends Controller
{
    //Retornar vista empleados
    public function empleados()
    {
        return view('empleados');
    }

    //Retornar vista empleadosCargaMasiva
    public function empleadosCargaMasiva()
    {
        return view('empleadosCargaMasiva');
    }

    //Retornar vista empleadosDataTienda
    public function empleadosDataTienda()
    {
        return view('empleadosDataTienda');
    }


    /***
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
        Funcion crear baja empleado, valida el correo perteneciente a Grupo AXO e inserta el empleado en MasterData, en caso de 
        que el empleado ya exista en alguna de las tiendas, este actualiza los demás campos a excepción del correo electrónico y finalmente
        inserta el registro en la BD para tener un respaldo.
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
     ***/
    function bajaEmpleado(Request $request)
    {
    }
/*
    function bajaEmpleado(Request $request)
    {

        //$value = $_POST["make"];
        //$operacion = 'Alta';
        $email = request('email');
        //$nombre = request('nombre');
        //$apellidos = request('apellidos');
        $estado = 'Activo';
        //$tipoAlta = $_POST["tipoEmpleado"];
        switch ($tipoAlta) {
            case 1: // Empleado Grupo AXO
                $clusterId = '';
                //"@grupoaxo.com"
                $email_formulario = substr($email, strlen($email) - 13);
                $arrayAlta = array(
                    "email" => $email,
                    //"firstName" => $nombre,
                    //"lastName" => $apellidos,
                    "clusterId" => $clusterId,
                );
                if ($email_formulario == "@grupoaxo.com") {
                    //Verificar dependiendo de la tienda seleccionada se inserta en masterdata
                    switch ($value) {
                        case 1: // Todas
                            $curlBBW = curl_init();
                            curl_setopt_array($curlBBW, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlBB = curl_init();
                            curl_setopt_array($curlBB, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCK = curl_init();
                            curl_setopt_array($curlCK, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCH = curl_init();
                            curl_setopt_array($curlCH, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCB = curl_init();
                            curl_setopt_array($curlCB, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlGUESS = curl_init();
                            curl_setopt_array($curlGUESS, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlRAP = curl_init();
                            curl_setopt_array($curlRAP, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTAF = curl_init();
                            curl_setopt_array($curlTAF, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTH = curl_init();
                            curl_setopt_array($curlTH, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlVS = curl_init();
                            curl_setopt_array($curlVS, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));

                            $response = curl_exec($curlBBW);
                            $response = curl_exec($curlBB);
                            $response = curl_exec($curlCK);
                            $response = curl_exec($curlCH);
                            $response = curl_exec($curlCB);
                            $response = curl_exec($curlGUESS);
                            $response = curl_exec($curlRAP);
                            $response = curl_exec($curlTAF);
                            $response = curl_exec($curlTH);
                            $response = curl_exec($curlVS);

                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {

                                $curlBBW = curl_init();
                                curl_setopt_array($curlBBW, array(
                                    CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                        'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlBB = curl_init();
                                curl_setopt_array($curlBB, array(
                                    CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                        'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCK = curl_init();
                                curl_setopt_array($curlCK, array(
                                    CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                        'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCH = curl_init();
                                curl_setopt_array($curlCH, array(
                                    CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                        'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCB = curl_init();
                                curl_setopt_array($curlCB, array(
                                    CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                        'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlGUESS = curl_init();
                                curl_setopt_array($curlGUESS, array(
                                    CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                        'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlRAP = curl_init();
                                curl_setopt_array($curlRAP, array(
                                    CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                        'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTAF = curl_init();
                                curl_setopt_array($curlTAF, array(
                                    CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                        'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTH = curl_init();
                                curl_setopt_array($curlTH, array(
                                    CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                        'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlVS = curl_init();
                                curl_setopt_array($curlVS, array(
                                    CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                        'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));

                                $response = curl_exec($curlBBW);
                                $response = curl_exec($curlBB);
                                $response = curl_exec($curlCK);
                                $response = curl_exec($curlCH);
                                $response = curl_exec($curlCB);
                                $response = curl_exec($curlGUESS);
                                $response = curl_exec($curlRAP);
                                $response = curl_exec($curlTAF);
                                $response = curl_exec($curlTH);
                                $response = curl_exec($curlVS);

                                $request->session()->flash('alert-warning', 'El empleado ya se encuentra registrado en algunas tiendas, los datos de estas fueron actualzados.' . $response);
                            } else {

                                $request->session()->flash('alert-success', 'Empleado creado correctamente en todas las tiendas!' . $response);
                            }

                            curl_close($curlBBW);
                            curl_close($curlBB);
                            curl_close($curlCK);
                            curl_close($curlCH);
                            curl_close($curlCB);
                            curl_close($curlGUESS);
                            curl_close($curlRAP);
                            curl_close($curlTAF);
                            curl_close($curlTH);
                            curl_close($curlVS);

                            break;
                        case 2: // Bath & Body Works
                            break;

                        case 3: // Brooks Brothers
                            break;

                        case 4: // Calvin Klein
                            break;

                        case 5: // Coach
                            break;

                        case 6: // Crate & Barrel
                            break;

                        case 7: // Guess
                            break;

                        case 8: // Rapsodia
                            break;

                        case 9: // Taf
                            break;

                        case 10: // Tommy Hilfiger
                            break;

                        case 11: // Victoria’s Secret
                            break;

                    } //fin de switch
                    //return redirect()->route("empleados"); 
                    return back();
                } else { // fin de if 
                    $request->session()->flash('alert-danger', 'El correo no pertenece a Grupo AXO!');
                    return back();
                }
                break;
            
        }
    } //fin de metodo
                


    /***
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
        Funcion crear nuevo empleado, valida el correo perteneciente a Grupo AXO e inserta el empleado en MasterData, en caso de 
        que el empleado ya exista en alguna de las tiendas, este actualiza los demás campos a excepción del correo electrónico y finalmente
        inserta el registro en la BD para tener un respaldo.
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
     ***/

    function nuevoEmpleado(Request $request)
    {

        $value = $_POST["make"];
        $operacion = 'Alta';
        $email = request('email');
        $nombre = request('nombre');
        $apellidos = request('apellidos');
        $estado = 'Activo';
        $tipoAlta = $_POST["tipoEmpleado"];
        switch ($tipoAlta) {
            case 1: // Empleado Grupo AXO
                $clusterId = '1';
                //"@grupoaxo.com"
                $email_formulario = substr($email, strlen($email) - 13);
                $arrayAlta = array(
                    "email" => $email,
                    "firstName" => $nombre,
                    "lastName" => $apellidos,
                    "clusterId" => $clusterId,
                );
                if ($email_formulario == "@grupoaxo.com") {
                    //Verificar dependiendo de la tienda seleccionada se inserta en masterdata
                    switch ($value) {
                        case 1: // Todas
                            $curlBBW = curl_init();
                            curl_setopt_array($curlBBW, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlBB = curl_init();
                            curl_setopt_array($curlBB, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCK = curl_init();
                            curl_setopt_array($curlCK, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCH = curl_init();
                            curl_setopt_array($curlCH, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCB = curl_init();
                            curl_setopt_array($curlCB, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlGUESS = curl_init();
                            curl_setopt_array($curlGUESS, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlRAP = curl_init();
                            curl_setopt_array($curlRAP, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTAF = curl_init();
                            curl_setopt_array($curlTAF, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-AGOBTI',
                                    'X-VTEX-API-AppToken: MMFFRSDPYWAOUMNGVPGHNOEYFQLOYOUICESDXQEPWOOYOZHTKZRMCQQYHHAAHOQKBRMPUJIEKRLZZGJFIREYWHGMOUVQQDIIYEWWNSZARMCLFRYBXUSPKRNULABAORNG',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTH = curl_init();
                            curl_setopt_array($curlTH, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlVS = curl_init();
                            curl_setopt_array($curlVS, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            /*
                            $curlTafQA = curl_init();
                            curl_setopt_array($curlTafQA, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlPromodaQA = curl_init();
                            curl_setopt_array($curlPromodaQA, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
*/
                            $response = curl_exec($curlBBW);
                            $response = curl_exec($curlBB);
                            $response = curl_exec($curlCK);
                            $response = curl_exec($curlCH);
                            $response = curl_exec($curlCB);
                            $response = curl_exec($curlGUESS);
                            $response = curl_exec($curlRAP);
                            $response = curl_exec($curlTAF);
                            $response = curl_exec($curlTH);
                            $response = curl_exec($curlVS);
                            //$response = curl_exec($curlTafQA);
                            //$response = curl_exec($curlPromodaQA);

                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {

                                $curlBBW = curl_init();
                                curl_setopt_array($curlBBW, array(
                                    CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                        'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlBB = curl_init();
                                curl_setopt_array($curlBB, array(
                                    CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                        'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCK = curl_init();
                                curl_setopt_array($curlCK, array(
                                    CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                        'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCH = curl_init();
                                curl_setopt_array($curlCH, array(
                                    CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                        'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCB = curl_init();
                                curl_setopt_array($curlCB, array(
                                    CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                        'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlGUESS = curl_init();
                                curl_setopt_array($curlGUESS, array(
                                    CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                        'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlRAP = curl_init();
                                curl_setopt_array($curlRAP, array(
                                    CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                        'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTAF = curl_init();
                                curl_setopt_array($curlTAF, array(
                                    CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmx-AGOBTI',
                                        'X-VTEX-API-AppToken: MMFFRSDPYWAOUMNGVPGHNOEYFQLOYOUICESDXQEPWOOYOZHTKZRMCQQYHHAAHOQKBRMPUJIEKRLZZGJFIREYWHGMOUVQQDIIYEWWNSZARMCLFRYBXUSPKRNULABAORNG',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTH = curl_init();
                                curl_setopt_array($curlTH, array(
                                    CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                        'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlVS = curl_init();
                                curl_setopt_array($curlVS, array(
                                    CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                        'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                /*
                                $curlTafQA = curl_init();
                                curl_setopt_array($curlTafQA, array(
                                    CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                        'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlPromodaQA = curl_init();
                                curl_setopt_array($curlPromodaQA, array(
                                    CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                        'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                /*
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                */

                                $response = curl_exec($curlBBW);
                                $response = curl_exec($curlBB);
                                $response = curl_exec($curlCK);
                                $response = curl_exec($curlCH);
                                $response = curl_exec($curlCB);
                                $response = curl_exec($curlGUESS);
                                $response = curl_exec($curlRAP);
                                $response = curl_exec($curlTAF);
                                $response = curl_exec($curlTH);
                                $response = curl_exec($curlVS);
                                //$response = curl_exec($curlTafQA);
                                //$response = curl_exec($curlPromodaQA);

                                $request->session()->flash('alert-warning', 'El empleado ya se encuentra registrado en algunas tiendas, los datos de estas fueron actualzados.' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                /*
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }*/
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en todas las tiendas!' . $response);
                            }

                            curl_close($curlBBW);
                            curl_close($curlBB);
                            curl_close($curlCK);
                            curl_close($curlCH);
                            curl_close($curlCB);
                            curl_close($curlGUESS);
                            curl_close($curlRAP);
                            curl_close($curlTAF);
                            curl_close($curlTH);
                            curl_close($curlVS);
                            //curl_close($curlTafQA);
                            //curl_close($curlPromodaQA);
                            break;
                        case 2: // Bath & Body Works
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                        'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Bath & Body Works, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Bath & Body Works!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 3: // Brooks Brothers
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                        'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Brooks Brothers, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Brooks Brothers!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 4: // Calvin Klein
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                        'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Calvin Klein, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Calvin Klein!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 5: // Coach
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                        'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Coach, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Coach!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 6: // Crate & Barrel
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                        'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Crate & Barrel, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Crate & Barrel!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 7: // Guess
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                        'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Guess, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Guess!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 8: // Rapsodia
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                        'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Rapsodia, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Rapsodia!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 9: // Taf
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                        'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 10: // Tommy Hilfiger
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                        'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Tommy Hilfiger, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Tommy Hilfiger!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 11: // Victoria’s Secret
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                        'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 12: // Taf QA
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                        'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 13: // Promoda QA
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                        'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf QA, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf QA!' . $response);
                            }
                            curl_close($curl);
                            break;

                        // Alta Speedo
                        case 14: 
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://speedomx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-speedomx-UTABOO',
                                    'X-VTEX-API-AppToken: IJJBVNKFRFHWLSAYOJLKEZCNRZFLOPVGJZVNCVYSKQFXNKKSBDFBXRJZWVFZVHGKVUAZNAXPUMSRUHNZSTLDKVLKMPQSJUGNMDWRVCMPCLENPEBUAXKEDSSABSLVMQBS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://speedomx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-speedomx-UTABOO',
                                        'X-VTEX-API-AppToken: IJJBVNKFRFHWLSAYOJLKEZCNRZFLOPVGJZVNCVYSKQFXNKKSBDFBXRJZWVFZVHGKVUAZNAXPUMSRUHNZSTLDKVLKMPQSJUGNMDWRVCMPCLENPEBUAXKEDSSABSLVMQBS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en Speedo, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en Speedo!' . $response);
                            }
                            curl_close($curl);
                            break;
                    } //fin de switch
                    //return redirect()->route("empleados"); 
                    return back();
                } else { // fin de if 
                    $request->session()->flash('alert-danger', 'El correo no pertenece a Grupo AXO!');
                    return back();
                }
                break;
            case 2: // Empleado Privalia
                $clusterId = '1';
                //"privalia@.com"
                $email_formulario = substr($email, strlen($email) - 13);
                $arrayAlta = array(
                    "email" => $email,
                    "firstName" => $nombre,
                    "lastName" => $apellidos,
                    "clusterId" => $clusterId,
                );
                if ($email_formulario == "@privalia.com") {
                    //Verificar dependiendo de la tienda seleccionada se inserta en masterdata
                    switch ($value) {
                        case 1: // Todas
                            $curlBBW = curl_init();
                            curl_setopt_array($curlBBW, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlBB = curl_init();
                            curl_setopt_array($curlBB, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCK = curl_init();
                            curl_setopt_array($curlCK, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCH = curl_init();
                            curl_setopt_array($curlCH, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCB = curl_init();
                            curl_setopt_array($curlCB, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlGUESS = curl_init();
                            curl_setopt_array($curlGUESS, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlRAP = curl_init();
                            curl_setopt_array($curlRAP, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTAF = curl_init();
                            curl_setopt_array($curlTAF, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTH = curl_init();
                            curl_setopt_array($curlTH, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlVS = curl_init();
                            curl_setopt_array($curlVS, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTafQA = curl_init();
                            curl_setopt_array($curlTafQA, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlPromodaQA = curl_init();
                            curl_setopt_array($curlPromodaQA, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));

                            $response = curl_exec($curlBBW);
                            $response = curl_exec($curlBB);
                            $response = curl_exec($curlCK);
                            $response = curl_exec($curlCH);
                            $response = curl_exec($curlCB);
                            $response = curl_exec($curlGUESS);
                            $response = curl_exec($curlRAP);
                            $response = curl_exec($curlTAF);
                            $response = curl_exec($curlTH);
                            $response = curl_exec($curlVS);
                            $response = curl_exec($curlTafQA);
                            $response = curl_exec($curlPromodaQA);

                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {

                                $curlBBW = curl_init();
                                curl_setopt_array($curlBBW, array(
                                    CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                        'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlBB = curl_init();
                                curl_setopt_array($curlBB, array(
                                    CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                        'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCK = curl_init();
                                curl_setopt_array($curlCK, array(
                                    CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                        'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCH = curl_init();
                                curl_setopt_array($curlCH, array(
                                    CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                        'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlCB = curl_init();
                                curl_setopt_array($curlCB, array(
                                    CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                        'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlGUESS = curl_init();
                                curl_setopt_array($curlGUESS, array(
                                    CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                        'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlRAP = curl_init();
                                curl_setopt_array($curlRAP, array(
                                    CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                        'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTAF = curl_init();
                                curl_setopt_array($curlTAF, array(
                                    CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                        'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTH = curl_init();
                                curl_setopt_array($curlTH, array(
                                    CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                        'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlVS = curl_init();
                                curl_setopt_array($curlVS, array(
                                    CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                        'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlTafQA = curl_init();
                                curl_setopt_array($curlTafQA, array(
                                    CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                        'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                $curlPromodaQA = curl_init();
                                curl_setopt_array($curlPromodaQA, array(
                                    CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                        'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }

                                $response = curl_exec($curlBBW);
                                $response = curl_exec($curlBB);
                                $response = curl_exec($curlCK);
                                $response = curl_exec($curlCH);
                                $response = curl_exec($curlCB);
                                $response = curl_exec($curlGUESS);
                                $response = curl_exec($curlRAP);
                                $response = curl_exec($curlTAF);
                                $response = curl_exec($curlTH);
                                $response = curl_exec($curlVS);
                                $response = curl_exec($curlTafQA);
                                $response = curl_exec($curlPromodaQA);
                                $request->session()->flash('alert-warning', 'El empleado ya se encuentra registrado en algunas tiendas, los datos de estas fueron actualzados.' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en todas las tiendas!' . $response);
                            }

                            curl_close($curlBBW);
                            curl_close($curlBB);
                            curl_close($curlCK);
                            curl_close($curlCH);
                            curl_close($curlCB);
                            curl_close($curlGUESS);
                            curl_close($curlRAP);
                            curl_close($curlTAF);
                            curl_close($curlTH);
                            curl_close($curlVS);
                            curl_close($curlTafQA);
                            curl_close($curlPromodaQA);
                            break;
                        case 2: // Bath & Body Works
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                        'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Bath & Body Works, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Bath & Body Works!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 3: // Brooks Brothers
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                        'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Brooks Brothers, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Brooks Brothers!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 4: // Calvin Klein
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                        'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Calvin Klein, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Calvin Klein!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 5: // Coach
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                        'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Coach, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Coach!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 6: // Crate & Barrel
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                        'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Crate & Barrel, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Crate & Barrel!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 7: // Guess
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                        'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Guess, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Guess!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 8: // Rapsodia
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                        'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Rapsodia, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Rapsodia!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 9: // Taf
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                        'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 10: // Tommy Hilfiger
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                        'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Tommy Hilfiger, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Tommy Hilfiger!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 11: // Victoria’s Secret
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                        'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 12: // Taf QA
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                        'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                            }
                            curl_close($curl);
                            break;

                        case 13: // Promoda QA
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $response = curl_exec($curl);
                            //Verificar si se inserto en masterdata
                            $cadena_buscada   = 'Id';
                            $posicion_coincidencia = strpos($response, $cadena_buscada);
                            if ($posicion_coincidencia === false) {
                                $curl = curl_init();
                                curl_setopt_array($curl, array(
                                    CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_ENCODING => '',
                                    CURLOPT_MAXREDIRS => 10,
                                    CURLOPT_TIMEOUT => 0,
                                    CURLOPT_FOLLOWLOCATION => true,
                                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                    CURLOPT_CUSTOMREQUEST => 'PUT',
                                    CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                    CURLOPT_HTTPHEADER => array(
                                        'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                        'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                        'Content-Type: application/json',
                                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                    ),
                                ));
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    Empleado::where('email', $email)->update([
                                        'operacion' => "Cambio",
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $response = curl_exec($curl);
                                $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf QA, favor de verificar el correo!' . $response);
                            } else {
                                //verificar si existe ya en la base de datos
                                $existencia = DB::table('empleados')
                                    ->select('email')
                                    ->where('email', '=', $email)
                                    ->get();
                                if (count($existencia) >= 1) {
                                    echo 'existe';
                                } else {
                                    Empleado::create([
                                        'operacion' => $operacion,
                                        'email' => $email,
                                        'nombre' => $nombre,
                                        'apellidos' => $apellidos,
                                        'estado' => $estado,
                                    ]);
                                }
                                $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf QA!' . $response);
                            }
                            curl_close($curl);
                            break;
                    } //fin de switch
                    //return redirect()->route("empleados"); 
                    return back();
                } else { // fin de if 
                    $request->session()->flash('alert-danger', 'El correo no pertenece a Privalia!');
                    return back();
                }
                break;
            case 3: // Cliente VIP Black
                $clusterId = 'VIPB';
                $arrayAlta = array(
                    "email" => $email,
                    "firstName" => $nombre,
                    "lastName" => $apellidos,
                    "clusterId" => $clusterId,
                );

                switch ($value) {
                    case 1: // Todas
                        $curlBBW = curl_init();
                        curl_setopt_array($curlBBW, array(
                            CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlBB = curl_init();
                        curl_setopt_array($curlBB, array(
                            CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlCK = curl_init();
                        curl_setopt_array($curlCK, array(
                            CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlCH = curl_init();
                        curl_setopt_array($curlCH, array(
                            CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlCB = curl_init();
                        curl_setopt_array($curlCB, array(
                            CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlGUESS = curl_init();
                        curl_setopt_array($curlGUESS, array(
                            CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlRAP = curl_init();
                        curl_setopt_array($curlRAP, array(
                            CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlTAF = curl_init();
                        curl_setopt_array($curlTAF, array(
                            CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmx-AGOBTI',
                                'X-VTEX-API-AppToken: MMFFRSDPYWAOUMNGVPGHNOEYFQLOYOUICESDXQEPWOOYOZHTKZRMCQQYHHAAHOQKBRMPUJIEKRLZZGJFIREYWHGMOUVQQDIIYEWWNSZARMCLFRYBXUSPKRNULABAORNG',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlTH = curl_init();
                        curl_setopt_array($curlTH, array(
                            CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlVS = curl_init();
                        curl_setopt_array($curlVS, array(
                            CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlTafQA = curl_init();
                        curl_setopt_array($curlTafQA, array(
                            CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlPromodaQA = curl_init();
                        curl_setopt_array($curlPromodaQA, array(
                            CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));

                        $response = curl_exec($curlBBW);
                        $response = curl_exec($curlBB);
                        $response = curl_exec($curlCK);
                        $response = curl_exec($curlCH);
                        $response = curl_exec($curlCB);
                        $response = curl_exec($curlGUESS);
                        $response = curl_exec($curlRAP);
                        $response = curl_exec($curlTAF);
                        $response = curl_exec($curlTH);
                        $response = curl_exec($curlVS);
                        $response = curl_exec($curlTafQA);
                        $response = curl_exec($curlPromodaQA);

                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {

                            $curlBBW = curl_init();
                            curl_setopt_array($curlBBW, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlBB = curl_init();
                            curl_setopt_array($curlBB, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCK = curl_init();
                            curl_setopt_array($curlCK, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCH = curl_init();
                            curl_setopt_array($curlCH, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCB = curl_init();
                            curl_setopt_array($curlCB, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlGUESS = curl_init();
                            curl_setopt_array($curlGUESS, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlRAP = curl_init();
                            curl_setopt_array($curlRAP, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTAF = curl_init();
                            curl_setopt_array($curlTAF, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-AGOBTI',
                                    'X-VTEX-API-AppToken: MMFFRSDPYWAOUMNGVPGHNOEYFQLOYOUICESDXQEPWOOYOZHTKZRMCQQYHHAAHOQKBRMPUJIEKRLZZGJFIREYWHGMOUVQQDIIYEWWNSZARMCLFRYBXUSPKRNULABAORNG',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTH = curl_init();
                            curl_setopt_array($curlTH, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlVS = curl_init();
                            curl_setopt_array($curlVS, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTafQA = curl_init();
                            curl_setopt_array($curlTafQA, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlPromodaQA = curl_init();
                            curl_setopt_array($curlPromodaQA, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }

                            $response = curl_exec($curlBBW);
                            $response = curl_exec($curlBB);
                            $response = curl_exec($curlCK);
                            $response = curl_exec($curlCH);
                            $response = curl_exec($curlCB);
                            $response = curl_exec($curlGUESS);
                            $response = curl_exec($curlRAP);
                            $response = curl_exec($curlTAF);
                            $response = curl_exec($curlTH);
                            $response = curl_exec($curlVS);
                            $response = curl_exec($curlTafQA);
                            $response = curl_exec($curlPromodaQA);
                            $request->session()->flash('alert-warning', 'El empleado ya se encuentra registrado en algunas tiendas, los datos de estas fueron actualzados.' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en todas las tiendas!' . $response);
                        }

                        curl_close($curlBBW);
                        curl_close($curlBB);
                        curl_close($curlCK);
                        curl_close($curlCH);
                        curl_close($curlCB);
                        curl_close($curlGUESS);
                        curl_close($curlRAP);
                        curl_close($curlTAF);
                        curl_close($curlTH);
                        curl_close($curlVS);
                        curl_close($curlTafQA);
                        curl_close($curlPromodaQA);
                        break;
                    case 2: // Bath & Body Works
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Bath & Body Works, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Bath & Body Works!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 3: // Brooks Brothers
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Brooks Brothers, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Brooks Brothers!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 4: // Calvin Klein
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Calvin Klein, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Calvin Klein!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 5: // Coach
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Coach, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Coach!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 6: // Crate & Barrel
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Crate & Barrel, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Crate & Barrel!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 7: // Guess
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Guess, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Guess!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 8: // Rapsodia
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Rapsodia, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Rapsodia!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 9: // Taf
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 10: // Tommy Hilfiger
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Tommy Hilfiger, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Tommy Hilfiger!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 11: // Victoria’s Secret
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 12: // Taf QA
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 13: // Promoda QA
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf QA, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf QA!' . $response);
                        }
                        curl_close($curl);
                        break;
                } //fin de switch
                //return redirect()->route("empleados"); 
                return back();
                break;
            case 4: // Cliente VIP Platino
                $clusterId = 'VIPP';
                $arrayAlta = array(
                    "email" => $email,
                    "firstName" => $nombre,
                    "lastName" => $apellidos,
                    "clusterId" => $clusterId,
                );

                switch ($value) {
                    case 1: // Todas
                        $curlBBW = curl_init();
                        curl_setopt_array($curlBBW, array(
                            CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlBB = curl_init();
                        curl_setopt_array($curlBB, array(
                            CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlCK = curl_init();
                        curl_setopt_array($curlCK, array(
                            CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlCH = curl_init();
                        curl_setopt_array($curlCH, array(
                            CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlCB = curl_init();
                        curl_setopt_array($curlCB, array(
                            CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlGUESS = curl_init();
                        curl_setopt_array($curlGUESS, array(
                            CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlRAP = curl_init();
                        curl_setopt_array($curlRAP, array(
                            CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlTAF = curl_init();
                        curl_setopt_array($curlTAF, array(
                            CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlTH = curl_init();
                        curl_setopt_array($curlTH, array(
                            CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlVS = curl_init();
                        curl_setopt_array($curlVS, array(
                            CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlTafQA = curl_init();
                        curl_setopt_array($curlTafQA, array(
                            CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $curlPromodaQA = curl_init();
                        curl_setopt_array($curlPromodaQA, array(
                            CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));

                        $response = curl_exec($curlBBW);
                        $response = curl_exec($curlBB);
                        $response = curl_exec($curlCK);
                        $response = curl_exec($curlCH);
                        $response = curl_exec($curlCB);
                        $response = curl_exec($curlGUESS);
                        $response = curl_exec($curlRAP);
                        $response = curl_exec($curlTAF);
                        $response = curl_exec($curlTH);
                        $response = curl_exec($curlVS);
                        $response = curl_exec($curlTafQA);
                        $response = curl_exec($curlPromodaQA);

                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {

                            $curlBBW = curl_init();
                            curl_setopt_array($curlBBW, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlBB = curl_init();
                            curl_setopt_array($curlBB, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCK = curl_init();
                            curl_setopt_array($curlCK, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCH = curl_init();
                            curl_setopt_array($curlCH, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlCB = curl_init();
                            curl_setopt_array($curlCB, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlGUESS = curl_init();
                            curl_setopt_array($curlGUESS, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlRAP = curl_init();
                            curl_setopt_array($curlRAP, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTAF = curl_init();
                            curl_setopt_array($curlTAF, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTH = curl_init();
                            curl_setopt_array($curlTH, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlVS = curl_init();
                            curl_setopt_array($curlVS, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlTafQA = curl_init();
                            curl_setopt_array($curlTafQA, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            $curlPromodaQA = curl_init();
                            curl_setopt_array($curlPromodaQA, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }

                            $response = curl_exec($curlBBW);
                            $response = curl_exec($curlBB);
                            $response = curl_exec($curlCK);
                            $response = curl_exec($curlCH);
                            $response = curl_exec($curlCB);
                            $response = curl_exec($curlGUESS);
                            $response = curl_exec($curlRAP);
                            $response = curl_exec($curlTAF);
                            $response = curl_exec($curlTH);
                            $response = curl_exec($curlVS);
                            $response = curl_exec($curlTafQA);
                            $response = curl_exec($curlPromodaQA);
                            $request->session()->flash('alert-warning', 'El empleado ya se encuentra registrado en algunas tiendas, los datos de estas fueron actualzados.' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en todas las tiendas!' . $response);
                        }

                        curl_close($curlBBW);
                        curl_close($curlBB);
                        curl_close($curlCK);
                        curl_close($curlCH);
                        curl_close($curlCB);
                        curl_close($curlGUESS);
                        curl_close($curlRAP);
                        curl_close($curlTAF);
                        curl_close($curlTH);
                        curl_close($curlVS);
                        curl_close($curlTafQA);
                        curl_close($curlPromodaQA);
                        break;
                    case 2: // Bath & Body Works
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Bath & Body Works, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Bath & Body Works!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 3: // Brooks Brothers
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Brooks Brothers, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Brooks Brothers!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 4: // Calvin Klein
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Calvin Klein, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Calvin Klein!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 5: // Coach
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Coach, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Coach!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 6: // Crate & Barrel
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Crate & Barrel, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Crate & Barrel!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 7: // Guess
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Guess, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Guess!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 8: // Rapsodia
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Rapsodia, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Rapsodia!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 9: // Taf
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 10: // Tommy Hilfiger
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Tommy Hilfiger, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Tommy Hilfiger!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 11: // Victoria’s Secret
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 12: // Taf QA
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Victoria’s Secret, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Victoria’s Secret!' . $response);
                        }
                        curl_close($curl);
                        break;

                    case 13: // Promoda QA
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        //Verificar si se inserto en masterdata
                        $cadena_buscada   = 'Id';
                        $posicion_coincidencia = strpos($response, $cadena_buscada);
                        if ($posicion_coincidencia === false) {
                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents',
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($arrayAlta),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                Empleado::where('email', $email)->update([
                                    'operacion' => "Cambio",
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $response = curl_exec($curl);
                            $request->session()->flash('alert-warning', 'El empleado ya existe en la tienda Taf QA, favor de verificar el correo!' . $response);
                        } else {
                            //verificar si existe ya en la base de datos
                            $existencia = DB::table('empleados')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleado::create([
                                    'operacion' => $operacion,
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'estado' => $estado,
                                ]);
                            }
                            $request->session()->flash('alert-success', 'Empleado creado correctamente en la tienda Taf QA!' . $response);
                        }
                        curl_close($curl);
                        break;
                } //fin de switch
                //return redirect()->route("empleados"); 
                return back();
                break;
        }
    } //fin de metodo



    /***
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
        Funcion importar archivo, carga un archivo CSV con los empleados a crear en la tienda seleccionada, de igual forma valida que 
        pertenezcan a Grupo Axo. en caso contrario los omitira en el ALTA, en caso de que algún correo ya exista en alguna de las tiendas 
        este actualiza los demás campos a excepción del correo electrónico y finalmente inserta el registro en la BD para tener un respaldo
        la insersión a la BD no esta con la validación de correo, por lo que se guardará todo lo que contenga el archivo.
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
     ***/

    //importar los archivos de Excel
    public function importExcel(Request $request)
    {

        ini_set("memory_limit", "-1");
        set_time_limit(0);

        $value = $_POST["make"];
        $curl = curl_init();
        $file = $request->file('file');
        $csv = array_map('str_getcsv', file($file));
        $responses = [];

        //Obtener el numero de elementos
        $longitud = count($csv);

        //Recorro todos los elementos
        for ($i = 1; $i < $longitud; $i++) {
            $procesaCorreos = true;


            switch ($csv[$i][0]) {
                case "Alta":
                    $tipoOperacion = 'PUT';
                    $params = '';
                    $temptemp = [];
                    $temptemp += ["email" => $csv[$i][1]];
                    $temptemp += ["firstName" => $csv[$i][2]];
                    $temptemp += ["lastName" => $csv[$i][3]];
                    $temptemp += ["clusterId" => "1"];
                    //Valida que el correo pertenezca a grupo axo
                    $email_archivo = substr($csv[$i][1], strlen($csv[$i][1]) - 13);
                    if ($email_archivo != "@grupoaxo.com") {
                        $procesaCorreos = false;
                        $response = 'El registro con el correo ' . $csv[$i][1] . 'no fue guardado debido a que no pertenece a Grupo AXO';
                        $responses[] = $csv[$i][4] . ' response: ' . $response;
                    } else {
                        $procesaCorreos = true;
                    }
                    break;
                case "Cambio":
                    $temptemp = [];
                    $temptemp += ["email" => $csv[$i][1]];
                    $temptemp += ["firstName" => $csv[$i][2]];
                    $temptemp += ["lastName" => $csv[$i][3]];
                    $temptemp += ["clusterId" => "1"];
                    $tipoOperacion = 'PUT';
                    $params = '';
                    break;
                case "Baja":
                    $temptemp = [];
                    $temptemp += ["email" => $csv[$i][1]];
                    $temptemp += ["firstName" => $csv[$i][2]];
                    $temptemp += ["lastName" => $csv[$i][3]];
                    $temptemp += ["clusterId" => ""];
                    $tipoOperacion = 'PUT';
                    $params = '?email=' . $csv[$i][1];
                    break;
            }

            if ($procesaCorreos) {
                switch ($value) {
                    case 2: // Bath & Body Works
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                                    'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 3: // Brooks Brothers
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                                    'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 4: // Calvin Klein
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                                    'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 5: // Coach
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                                    'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 6: // Crate & Barrel
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                                    'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 7: // Guess
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                                    'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 8: // Rapsodia
                        //cod de empleados anterior
                        
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        
/*
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                                    'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        */
                        break;

                    case 9: // Taf
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                                    'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 10: // Tommy Hilfiger
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                                    'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);

                        break;

                    case 11: // Victoria’s Secret
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                        */
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();

                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1500&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                                    'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;

                    case 12: // Taf QA
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
*/
                        
                        //vaciamos las tablas
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();


                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                                    'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;
                    case 13: // Promoda QA
                        //cod de empleados anterior
                        /*
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => $tipoOperacion,
                            CURLOPT_POSTFIELDS => json_encode($temptemp),
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                'Content-Type: application/json',
                                'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                            ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
*/
                        //vaciamos las tablas
                        DB::table('empleados_archivo')->truncate();
                        DB::table('empleados_masterdata')->truncate();


                        //codigo para obtner los reg del masterdata e insertarlos en empleados_masterdata
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_ENCODING => '',
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_TIMEOUT => 0,
                            CURLOPT_FOLLOWLOCATION => true,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => 'GET',
                            CURLOPT_HTTPHEADER => array(
                                'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                'Cookie: janus_sid=c4577b7f-cd54-4155-8901-338e3fd94ea5'
                            ),
                        ));
                        $response = curl_exec($curl);
                        $empleadosMaster = json_decode($response, true);

                        foreach ($empleadosMaster as $value) {
                            $email =  $value['email'];
                            $nombre = $value['firstName'];
                            $apellidos = $value['lastName'];
                            $clusterId = $value['clusterId'];
                            $accountName =  $value['accountName'];
        
                            $existencia = DB::table('empleados_masterdata')
                                ->select('email')
                                ->where('email', '=', $email)
                                ->get();
                            if (count($existencia) >= 1) {
                                echo 'existe';
                            } else {
                                Empleados_masterdata::create([
                                    'email' => $email,
                                    'nombre' => $nombre,
                                    'apellidos' => $apellidos,
                                    'clusterId' => $clusterId,
                                    'tienda' => $accountName,
                                ]);
                            }
                        }
        
                        curl_close($curl);



                        //codigo para obtner los reg del archivo e insertarlos en empleados_archivo
                        if ($procesaCorreos === false) {
                        } else {

                            $existencia = DB::table('empleados_archivo')
                                ->select('email')
                                ->where('email', '=', $csv[$i][1])
                                ->get();
                            if (count($existencia) >= 1) {
                                $cadena_buscada   = 'Id';
                                $posicion_coincidencia = strpos($response, $cadena_buscada);
                                if ($posicion_coincidencia === false) {
                                    Excel::import(new EmpleadosArchivo, $file);
                                }
                            } else {
                                Excel::import(new EmpleadosArchivo, $file);
                            }
                        }


                        //obtenemos los registros de las vistas ya filtradas
                        $sql_Empleados_Bajas = 'SELECT * FROM vista_empleados_bajas';
                        $sql_Empleados_Altas = 'SELECT * FROM vista_empleados_altas';
                        $bajas = DB::select($sql_Empleados_Bajas);
                        $altas = DB::select($sql_Empleados_Altas);
                        $total_bajas = json_decode(json_encode($bajas),true);
                        $total_altas = json_decode(json_encode($altas),true);

                        //seteamos las bajas para mandar el PUT con clusterId = ""
                        foreach ($total_bajas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => ""];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'PUT',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }

                        //seteamos las bajas para mandar el POST con clusterId = "1"
                        foreach ($total_altas as $value) {
                            $temptemp2 = [];
                            $temptemp2 += ["email" => $value['email']];
                            $temptemp2 += ["firstName" => $value['nombre']];
                            $temptemp2 += ["lastName" => $value['apellidos']];
                            $temptemp2 += ["clusterId" => "1"];

                            $curl = curl_init();
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/documents' . $params,
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => '',
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 0,
                                CURLOPT_FOLLOWLOCATION => true,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => 'POST',
                                CURLOPT_POSTFIELDS => json_encode($temptemp2),
                                CURLOPT_HTTPHEADER => array(
                                    'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                                    'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                                    'Content-Type: application/json',
                                    'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                                ),
                            ));
                            
                            $response = curl_exec($curl);
                            curl_close($curl);
                        }
                       //Regresamos a la vista los registros modificados
                        return view('empleadosCargaMasiva', ['empleadosBaja' => $total_bajas, 'empleadosAlta' => $total_altas]);
                        break;
                } //fin de switch
                //return redirect()->route("empleados"); 

                //return back();
            } else { // fin de if 
                $request->session()->flash('alert-danger', 'El archivo contiene correos no pertenecientes a Grupo AXO!');
                return back();
            }
            if ($procesaCorreos === false) {
                $request->session()->flash('alert-danger', 'Error al cargar el archivo, por favor verifique el archivo que desea cargar y la extensión.');
            } else {
                //verificar si existe ya en la base de datos
                $existencia = DB::table('empleados')
                    ->select('email')
                    ->where('email', '=', $csv[$i][1])
                    ->get();
                if (count($existencia) >= 1) {
                    $cadena_buscada   = 'Id';
                    $posicion_coincidencia = strpos($response, $cadena_buscada);
                    if ($posicion_coincidencia === false) {
                        $request->session()->flash('alert-warning', 'Revise el archivo!' . $response);
                        Excel::import(new EmpleadosImport, $file);
                        $request->session()->flash('alert-warning', 'Se actualizaron los registros, Favor de verificarlo!' . $response);
                    } /*else {
                       
                    }*/
                    //echo 'existe';
                    $request->session()->flash('alert-success', 'Empleado creado correctamente!' . $response);
                } else {
                    Excel::import(new EmpleadosImport, $file);
                    $request->session()->flash('alert-success', 'Empleados creados correctamente!' . $response);
                }
            }
        } //fin de for
        //return back();
    } //fin de metodo














































































    

    /***
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
        Funcion dataTable, dependiendo de la tienda seleccionada, este consultara el Masterdata y mediante un Json cargado a una DataTable
        se mostraran los refistros existentes con los campos indicados en a URL.
        
        Nota: El MasterData cuenta con un blindaje, el cual solo permite hacer 10 consultas masivas, una vez llegado a este punto se debe 
        esperar en promedio 1 hora para volver a ejecutar las consultas masivas del "SCROLL y SIZE".
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
     ***/

    //funcion para mostrar los registros del masterdata en el datatable
    public function dataTableCarga(Request $request)
    {
        $value = $_POST["make"];
        //echo '<pre>'; var_dump( $value);
        switch ($value) {
            case 2: // Bath & Body Works
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://bathbodymx.vtexcommercestable.com.br/api/dataentities/CL/scroll?_where=(email%20like%20*@grupoaxo.com%20AND%20clusterId%20like%201)&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-bathbodymx-HHXUYJ',
                        'X-VTEX-API-AppToken: XHYTEFECLTQIEYKBEDDYRLRONAZWSAUZASRDAKTPPLABJJRWTLBCMCELQJGEFHJKYRHLGHBTJNJGKPEEIDDHZSNXOFNQEPKHBQCSBFPMKISYTYBAFCVBECLFDKXBTLOU',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 3: // Brooks Brothers
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://brooksbrothers.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-brooksbrothers-AWWBSL',
                        'X-VTEX-API-AppToken: QNABFEDDVJBMRWLKLDJJMRSXUTPWWCPYUBSJPIRSLBLHPFPEUEBBCEMZUCGMPHGSUDRQEBVCMRYKFLHPDLCRBNWQOSOMCEDEVTMMNZZTJYOKGBTJURIDFORGGABLMIAH',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 4: // Calvin Klein
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://calvinkleinmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-calvinkleinmx-GDONHM',
                        'X-VTEX-API-AppToken: NVWOCHQCAFUTRBLUTORYYDGINIGKXXEDHNKPJFUARBAWJGOIHSNXNFCKPOBTBFEDAQMERVKNURHWDJYGUYDFKGQCLAAVEBZLXXWSTKQLHZDWXFHFPUZCCYSTAKSRVPIS',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 5: // Coach
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://coachmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-coachmx-YDCIKC',
                        'X-VTEX-API-AppToken: TWZPGXUUDRNSNMDHMNKWVJFPRAQWJDEYWPRJQLJNFFPQWOHAJVGISCOJQKXFGYLZNOVYVTQAEWQQTOSDSPNNXVFTAHSGNDHHTPDHTJFPEFEWMYPBRUMRKXCRIBYNAJMA',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 6: // Crate & Barrel
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://crateandbarrelmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-crateandbarrelmx-CQTRDW',
                        'X-VTEX-API-AppToken: ZPPFOBUURMQEINBLPILTVIEWEYWSNZCWLPBMSCQBOPWVDEBNGEKJWQZRKTBQFCGSKUSSMOSNSKFGLISZWJMJOSZVQJCZBZWLJELJMIBRLXQMLSFBABTWQWDSUXBCMTMS',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 7: // Guess
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://guessmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-guessmx-JRRKFE',
                        'X-VTEX-API-AppToken: CXJXAPQKLQKUITENGRMMLCOCMLEUGGOFUDBFOBLWNFEGMMAZWQBZQZAZJGKPKVEFBFZERYYFFQYGYIPZKEYPEOOVCBWIRWLSAYEHNVHXRWTZAUAAQKEFXOAMQECQBQOJ',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 8: // Rapsodia
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://rapsodiamx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-rapsodiamx-SUZOQC',
                        'X-VTEX-API-AppToken: GTLDFTTNKKVEMVDUNJAXCJRFJIYSCVLBBDGHBXDMZLYWXLSCWDGNQKZXBFUWUBKPZTDJPVSQFNYRKVIYQWWYPXLQDIFVCGRYAJXDHIMAKPHCMHMGXWGXELABINFHQXNZ',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 9: // Taf
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://tafmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-tafmx-NRFRTJ',
                        'X-VTEX-API-AppToken: IEOGMDUTDDANTMGNZMTWQNPDLESMJNIZOQOCGSOSAZJLJYGOBZMUELUVPKVHKIKQUBZDYDHGYAVQDDUMYEKJANUCVSNVXGISPTQIYCQXSFWDPERLQIJGXBPGGXIFPLIS',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 10: // Tommy Hilfiger
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://tommymx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-tommymx-GNNQSP',
                        'X-VTEX-API-AppToken: UHCYKPUZHEFAEBFCLWLVYJBKWAPUXBFVZKPMMYDALOTDXLSOCFEMMZRLFSCKZZCFYKAUMSPNSKJKQYMKIASSXTIZTDGUVTBLLNENKYBJPRTCPGUGFRCYHKHFBAAILVRZ',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 11: // Victoria’s Secret
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://victoriassecretmx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-victoriassecretmx-DKVYYD',
                        'X-VTEX-API-AppToken: VLJHTCEHXNEQBIGSGGDEQWSGELLBMINXBWEDDURBHPTHYEELVJVTXOBYSCCHQCUOZHOEDCOLOBWBCKHAGAGDMUZNVGLARKKFUFIRQAHSUKFWSZVHUCBQVRBFHBJXROTD',
                        'Content-Type: application/json',
                        'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 12: // Taf QA
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://tafmxqa.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-tafmxqa-QEXITH',
                        'X-VTEX-API-AppToken: OUZRMUDFBCEQTWWTAGCBTFZALPRABIBAHZJSMIPZCOWYXCLMNFFIOMQIVZFXCDDSBDJTNEGSQDZEJADJDFMWDSMVIAWNCSWYKDWTTRZJYNRKNLZUVWTXRHPJRNLMHSQY',
                        'Cookie: janus_sid=c4577b7f-cd54-4155-8901-338e3fd94ea5'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

            case 13: // Promoda QA
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    //CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/search?_fields=email,firstName,lastName,clusterId,accountName&email=mortegab@grupoaxo.com',
                    CURLOPT_URL => 'https://promodamx.vtexcommercestable.com.br/api/dataentities/CL/scroll?email=*@grupoaxo.com*&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'X-VTEX-API-AppKey: vtexappkey-promodamx-QWFIJG',
                        'X-VTEX-API-AppToken: LNGZASTGACEJLQYIRKWNNBDMZRDAFGWRTFYCGXJSDYKBWJANZMHPUWNJJUAJOTBTFMPGRVCUBDJPQBPQQQASZHXWROSLXZDJXRWJTUVDKNNQMYSIEJSYSIUYPTPCDQXC',
                        'Cookie: janus_sid=c4577b7f-cd54-4155-8901-338e3fd94ea5'
                    ),
                ));
                $response = curl_exec($curl);
                DB::table('empleados_masterdata')->truncate();
                $empleadosMaster = json_decode($response, true);

                foreach ($empleadosMaster as $value) {
                    $email =  $value['email'];
                    $nombre = $value['firstName'];
                    $apellidos = $value['lastName'];
                    $clusterId = $value['clusterId'];
                    $accountName =  $value['accountName'];

                    $existencia = DB::table('empleados_masterdata')
                        ->select('email')
                        ->where('email', '=', $email)
                        ->get();
                    if (count($existencia) >= 1) {
                        echo 'existe';
                    } else {
                        Empleados_masterdata::create([
                            'email' => $email,
                            'nombre' => $nombre,
                            'apellidos' => $apellidos,
                            'clusterId' => $clusterId,
                            'tienda' => $accountName,
                        ]);
                    }
                }

                curl_close($curl);
                return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                break;

                case 14: // Speedo
                    $curl = curl_init();
                    curl_setopt_array($curl, array(    
                        CURLOPT_URL => 'https://speedomx.vtexcommercestable.com.br/api/dataentities/CL/scroll?_where=(email%20like%20*@grupoaxo.com%20AND%20clusterId%20like%201)&_size=1000&_sort=email%20ASC&_fields=email,firstName,lastName,clusterId,accountName',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'GET',
                        CURLOPT_HTTPHEADER => array(
                            'X-VTEX-API-AppKey: vtexappkey-speedomx-UTABOO',
                            'X-VTEX-API-AppToken: IJJBVNKFRFHWLSAYOJLKEZCNRZFLOPVGJZVNCVYSKQFXNKKSBDFBXRJZWVFZVHGKVUAZNAXPUMSRUHNZSTLDKVLKMPQSJUGNMDWRVCMPCLENPEBUAXKEDSSABSLVMQBS',
                            'Content-Type: application/json',
                            'Cookie: janus_sid=b4e77790-4d6f-48eb-a605-00528009e602'
                        ),
                    ));
                    $response = curl_exec($curl);
                    DB::table('empleados_masterdata')->truncate();
                    $empleadosMaster = json_decode($response, true);
    
                    foreach ($empleadosMaster as $value) {
                        $email =  $value['email'];
                        $nombre = $value['firstName'];
                        $apellidos = $value['lastName'];
                        $clusterId = $value['clusterId'];
                        $accountName =  $value['accountName'];
    
                        $existencia = DB::table('empleados_masterdata')
                            ->select('email')
                            ->where('email', '=', $email)
                            ->get();
                        if (count($existencia) >= 1) {
                            echo 'existe';
                        } else {
                            Empleados_masterdata::create([
                                'email' => $email,
                                'nombre' => $nombre,
                                'apellidos' => $apellidos,
                                'clusterId' => $clusterId,
                                'tienda' => $accountName,
                            ]);
                        }
                    }
    
                    curl_close($curl);
                    return view('empleadosDataTienda', ['empleados' => $empleadosMaster]);
                    break;
        }
        //echo '<pre>'; var_dump($resultado); die();
        //return view('empleadosDataTienda', ['empleados' => $resultado]);
    }
}
