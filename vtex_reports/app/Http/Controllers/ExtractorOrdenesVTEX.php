<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Orden;
use App\Models\Bitacora;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Console\Input\Input;

class ExtractorOrdenesVTEX extends Controller
{
    public function extraer(Request $request)
    {

        $token = $request->query('token');
        if (empty($token) || $token != env('URL_EXTRACTOR_TOKEN')) {
            echo 'Error';
            return;
        }

        $fechaInicioProceso = new DateTime();

        $account = env('TAF_ACCOUNT');
        $appKey = env('TAF_APP_KEY');
        $appToken = env('TAF_APP_TOKEN');

        $targetURL = env('VTEX_ORDERS');

        $fechaFinalAnterior = null;

        $ultimaBitacora = Bitacora::select('fechaFinal')
            ->where('exito', 1)
            ->orderBy('fechaFinProceso', 'desc')
            ->first();

        if ($ultimaBitacora === NULL) {
            $fechaFinalAnterior = '2020-10-20 00:00:00';
        } else {
            $fechaFinalAnterior = $ultimaBitacora->fechaFinal;
        }

        $initialDate = $fechaFinalAnterior;

        $finalDate = DateTime::createFromFormat('Y-m-d H:i:s', $initialDate);
        $finalDate = $finalDate->add(new DateInterval('P1D'));            // intervalos de 1 dia 

        $inicioDeHoy = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d') . ' 00:00:00');

        if ($finalDate >= $inicioDeHoy) {
            echo 'Ya está actualizado';
            return;
        }

        $initialDate = fecha_a_utc($initialDate);
        $finalDate = fecha_a_utc($finalDate);

        $page = 1;
        $totalPages = 1;
        $totalRegs = 0;

        $targetURL = str_replace('ACCOUNT', $account, $targetURL);

        $ordenes = array();
        $ordenesObtenidas = -1;
        $ordenesGuardadas = 0;

        while ($page <= $totalPages) {
            $resultado = $this->GetVtexInfo($targetURL, $appKey, $appToken, $page, $initialDate, $finalDate);
            if ($resultado !== false) {
                $page = $resultado['paging']['currentPage'];
                $totalPages = $resultado['paging']['pages'];
                $totalRegs = $resultado['paging']['total'];
                $ordenes = array_merge($ordenes, $resultado['list']);
                $page++;
            } else {
                break;
            }
        }
        $ordenesObtenidas = count($ordenes);

        // echo '<pre>'; var_dump($ordenes); die();

        foreach ($ordenes as $orderItem) {
            $ordenDB = new Orden();
            $ordenDB->orderId = $orderItem['orderId'];
            $ordenDB->creationDate = $orderItem['creationDate'];
            $ordenDB->clientName = $orderItem['clientName'];
            $ordenDB->items = $orderItem['items'];
            $ordenDB->totalValue = $orderItem['totalValue'];
            $ordenDB->paymentNames = $orderItem['paymentNames'];
            $ordenDB->status = $orderItem['status'];
            $ordenDB->statusDescription = $orderItem['statusDescription'];
            $ordenDB->marketPlaceOrderId = $orderItem['marketPlaceOrderId'];
            $ordenDB->sequence = $orderItem['sequence'];
            $ordenDB->salesChannel = $orderItem['salesChannel'];
            $ordenDB->affiliateId = $orderItem['affiliateId'];
            $ordenDB->origin = $orderItem['origin'];
            $ordenDB->workflowInErrorState = $orderItem['workflowInErrorState'];
            $ordenDB->workflowInRetry = $orderItem['workflowInRetry'];
            $ordenDB->lastMessageUnread = $orderItem['lastMessageUnread'];
            $ordenDB->ShippingEstimatedDate = $orderItem['ShippingEstimatedDate'];
            $ordenDB->ShippingEstimatedDateMax = $orderItem['ShippingEstimatedDateMax'];
            $ordenDB->ShippingEstimatedDateMin = $orderItem['ShippingEstimatedDateMin'];
            $ordenDB->orderIsComplete = $orderItem['orderIsComplete'];
            $ordenDB->listId = $orderItem['listId'];
            $ordenDB->listType = $orderItem['listType'];
            $ordenDB->authorizedDate = $orderItem['authorizedDate'];
            $ordenDB->callCenterOperatorName = $orderItem['callCenterOperatorName'];
            $ordenDB->totalItems = $orderItem['totalItems'];
            $ordenDB->currencyCode = $orderItem['currencyCode'];
            $ordenDB->hostname = $orderItem['hostname'];
            $ordenDB->invoiceOutput = valor_array($orderItem['invoiceOutput']);
            $ordenDB->invoiceInput = valor_array($orderItem['invoiceInput']);

            // Transformaciones:
            $ordenDB->creationDate = utc_a_fecha($ordenDB->creationDate);
            $ordenDB->totalValue = ($ordenDB->totalValue / 100);
            $ordenDB->ShippingEstimatedDate = utc_a_fecha($ordenDB->ShippingEstimatedDate);
            $ordenDB->ShippingEstimatedDateMax = utc_a_fecha($ordenDB->ShippingEstimatedDateMax);
            $ordenDB->ShippingEstimatedDateMin = utc_a_fecha($ordenDB->ShippingEstimatedDateMin);
            $ordenDB->authorizedDate = utc_a_fecha($ordenDB->authorizedDate);

            if ($ordenDB->ShippingEstimatedDate == '') $ordenDB->ShippingEstimatedDate = NULL;
            if ($ordenDB->ShippingEstimatedDateMax == '') $ordenDB->ShippingEstimatedDateMax = NULL;
            if ($ordenDB->ShippingEstimatedDateMin == '') $ordenDB->ShippingEstimatedDateMin = NULL;
            if ($ordenDB->authorizedDate == '') $ordenDB->authorizedDate = NULL;

            $ordenDB->save();
            $ordenesGuardadas++;
        }

        $bitacora = new Bitacora();
        $bitacora->tienda = $account;
        $bitacora->fechaInicial = utc_a_fecha($initialDate);
        $bitacora->fechaFinal = utc_a_fecha($finalDate);
        $bitacora->registrosObtenidos = $ordenesObtenidas;
        $bitacora->registrosGuardados = $ordenesGuardadas;
        $bitacora->exito = 1;
        $bitacora->fechaInicioProceso = $fechaInicioProceso;
        $bitacora->fechaFinProceso = new DateTime();
        $bitacora->mensaje = 'OK';
        $bitacora->save();

        echo ' inicio=' . utc_a_fecha($initialDate) . ' final=' . utc_a_fecha($finalDate); 
        echo '<br> ordenesObtenidas=' . $ordenesObtenidas . ' ordenesGuardadas=' . $ordenesGuardadas;
    }


    private function GetVtexInfo($targetURL, $appKey, $appToken, $page, $initialDate, $finalDate)
    {
        try {
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
        } catch (Exception $ex) {
            return false;
        }
    }
}
