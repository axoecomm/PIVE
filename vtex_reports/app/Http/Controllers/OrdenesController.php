<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class OrdenesController extends Controller
{
    public function ordenes () {

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

        $ordenes = array();

        while ($page <= $totalPages) {
            $resultado = $this->GetVtexInfo($targetURL, $appKey, $appToken, $page, $initialDate, $finalDate);
                $page = $resultado['paging']['currentPage'];
                $totalPages = $resultado['paging']['pages'];
                $totalRegs = $resultado['paging']['total'];
                $ordenes = array_merge($ordenes, $resultado['list']);
                $page++;
        }

        //echo '<pre>'; var_dump($ordenes); die();

        return view('ordenes', ['ordenes' => $ordenes]);
    }

    private function GetVtexInfo ($targetURL, $appKey, $appToken, $page, $initialDate, $finalDate) {
        $response = Http::withHeaders([
            'X-VTEX-API-AppKey' => $appKey,
            'X-VTEX-API-AppToken' => $appToken
        ])->get($targetURL, [
            'f_creationDate' => 'creationDate:['.$initialDate.' TO '.$finalDate.']',
            'orderBy' => 'creationDate,asc',
            'page' => $page,
            'per_page' => 100
        ]);
        return $response->json();
        //echo '<pre>'; var_dump($response); die();
    }

    
}
