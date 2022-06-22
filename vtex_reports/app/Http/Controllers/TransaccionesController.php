<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaccionesController extends Controller
{
    public function transaccionesReport(Request $request)
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        
        $value = $_POST["make"];
        $fechaI = request('fechaI');
        $fechaF = request('fechaF');

        /*
        $URL = ('https://brooksbrothers.myvtex.com/api/payments/pvt/admin/transactions?salesChannel=1&startDate=[' . $fechaI . 'T00:00:00.000Z%20TO%20' . $fechaF . 'T23:59:59.999Z]&_sort=startDate');

        echo("La tienda es:" . $value);
        echo '<br>';
        echo("La fecha de corte es:" . $fechaI);
        echo '<br>';
        echo("La fecha limite es:" . $fechaF);
        echo '<br>';
        echo("URL es:" . $URL);
        
*/
        switch ($value) {
            case 2: // Bath & Body Works
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://bathbodymx.myvtex.com/api/payments/pvt/admin/transactions?salesChannel=1&startDate=[' . $fechaI . 'T00:00:00.000Z%20TO%20' . $fechaF . 'T23:59:59.999Z]&_sort=startDate',
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
                        'Cookie: janus_sid=a515f498-f4a7-4824-8cb5-08a58d982211'
                    ),
                ));
                $response = curl_exec($curl);

                $response = curl_exec($curl);
                $transacciones = json_decode($response, true);
                curl_close($curl);
                echo $response;
                return view('transacciones', ['transacciones' => $transacciones]);
                break;

            case 3: // Brooks Brothers
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://brooksbrothers.myvtex.com/api/payments/pvt/admin/transactions?salesChannel=1&startDate=[' . $fechaI . 'T00:00:00.000Z%20TO%20' . $fechaF . 'T23:59:59.999Z]&_sort=startDate',
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
                        'Cookie: janus_sid=a515f498-f4a7-4824-8cb5-08a58d982211'
                    ),
                ));
                $response = curl_exec($curl);

                $response = curl_exec($curl);
                $transacciones = json_decode($response, true);
                curl_close($curl);
                echo $response;
                return view('transacciones', ['transacciones' => $transacciones]);
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

            case 12: // Taf QA

                break;

            case 13: // Promoda QA

                break;
        }//fin de switch

    }

    
    public function transacciones()
    {

        $account = env('TAF_ACCOUNT');
        $appKey = env('TAF_APP_KEY');
        $appToken = env('TAF_APP_TOKEN');

        $targetURL = env('VTEX_ORDERS');

        $initialDate = "2020-10-26T00:00:00.000Z";
        $finalDate = "2020-10-26T23:59:59.999Z";
        $page = 1;
        $totalPages = 1;

        $targetURL = str_replace('ACCOUNT', $account, $targetURL);
        $targetURL = str_replace('INITIAL', $initialDate, $targetURL);
        $targetURL = str_replace('FINAL', $finalDate, $targetURL);
        $targetURL = str_replace('PAGE', $page, $targetURL);

        $targetURL = 'https://tafmx.vtexcommercestable.com.br/api/oms/pvt/orders';

        $transacciones = array();

        while ($page <= $totalPages) {
            $resultado = $this->GetVtexInfo($targetURL, $appKey, $appToken, $page, $initialDate, $finalDate);
            $page = $resultado['paging']['currentPage'];
            $totalPages = $resultado['paging']['pages'];
            $totalRegs = $resultado['paging']['total'];
            $transacciones = array_merge($transacciones, $resultado['list']);
            $page++;
        }

        //echo '<pre>'; var_dump($transacciones); die();

        return view('transacciones', ['transacciones' => $transacciones]);
    }

    private function GetVtexInfo($targetURL, $appKey, $appToken, $page, $initialDate, $finalDate)
    {
        $response = Http::withHeaders([
            'X-VTEX-API-AppKey' => $appKey,
            'X-VTEX-API-AppToken' => $appToken
        ])->get($targetURL, [
            'f_creationDate' => 'creationDate:[' . $initialDate . ' TO ' . $finalDate . ']',
            'orderBy' => 'creationDate,asc',
            'page' => $page,
            'per_page' => 100
        ]);
        return $response->json();
    }
}
