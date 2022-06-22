<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConvertidorController extends Controller
{
    //Retornar vista convertidor
    public function convertidor()
    {
        return view('convertidor');
    }

    //Retornar vista empleadosCargaMasiva
    public function convertidorJson()
    {
        return view('convertidorJson');
    }

    //Retornar vista empleadosDataTienda
    public function convertidorDataTienda()
    {
        return view('convertidorDataTienda');
    }

    /***
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
        Convertidor desde una URL ingresada
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
     ***/

    function convertidorURL(Request $request)
    {
        //https://www.taf.com.mx/api/dataentities/SO/search?_fields=direccion,city,horario,latitude,longitude,name,colonia,phone,postalCode,state,storeSellerId&_sort=name
        $URL = request('url');
        //Arreglo original
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'REST-Range: resources=0-200',
                'Cookie: janus_sid=76df3e4d-77a1-4ff8-9153-f9fdcc7f067a'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        //Fin de arreglo original

        //Arreglo de estados
        $arrayEstados = [
            "Aguascalientes",
            "Baja California",
            "Baja California Sur",
            "Campeche",
            "Chiapas",
            "Chihuahua",
            "Ciudad de México",
            "Coahuila",
            "Colima",
            "Durango",
            "Edo. de México",
            "Guanajuato",
            "Guerrero",
            "Hidalgo",
            "Jalisco",
            "Michoacán",
            "Morelos",
            "Nayarit",
            "Nuevo León",
            "Oaxaca",
            "Puebla",
            "Queretaro",
            "Quinatana Roo",
            "San Luis Potosí",
            "Sinaloa",
            "Sonora",
            "Tabasco",
            "Tamaulipas",
            "Tlaxcala",
            "Veracruz",
            "Yucatán",
            "Zacatecas",
        ];
        $arrayEstadosTiendas = array();
        $arregloEstado = [];


        foreach ($arrayEstados as $estado) {
            $states = json_decode($response, true);

            $expected = array_filter($states, function ($var) use ($estado) {
                return ($var['state'] == $estado);
            });

            foreach ($expected as $state) {
                array_push($arregloEstado, $state["storeSellerId"]);
            }

            if (sizeof($arregloEstado) != 0) {
                $arrayEstadosTiendas[] = [
                    "name" => $estado,
                    "stores" => array_map('intval', $arregloEstado)
                ];
            }
            $arregloEstado = [];
        }
        $newStates = array("states: " => $arrayEstadosTiendas);

        $response2 = json_encode($newStates, JSON_UNESCAPED_UNICODE);
        //Fin de arreglo states

        //Arreglo store default
        //96043
        $storeDefaut = json_decode($response, true);
        foreach ($storeDefaut as $store_def) {
            $storeSellerId = "96043";
        }
        $new_store_d = array("storeDefault: " => $storeSellerId);
        //echo json_encode($new_store_d, JSON_UNESCAPED_UNICODE);
        $response3 = json_encode(["storeDefault: " => $storeSellerId], JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);
        //Fin de arrreglo store default

        //Arreglo estates
        $stores = json_decode($response, true);
        //$ouput = "<ul>";
        foreach ($stores as $store) {
            $ecommerce = "";
            $id = "";
            $name = "";
            $SC = "";
            $postalCode = "";
            $state = "";
            $city = "";
            $direccion = "";
            $phone = "";
            $horario = "";
            $opening = "";
            $latitude = "";
            $longitude = "";
            $services = [];
            $ZIPList = [];
            $nearby = [];
            $areas = [];
            $storeSellerId = "";

            foreach ($store as $key => $value) {

                switch ($key) {
                    case 'ecommerce':
                        $ecommerce = $value;
                        break;
                    case 'id':
                        $id = $value;
                        break;
                    case 'name':
                        $name = $value;
                        break;
                    case 'SC':
                        $SC = $value;
                        break;
                    case 'postalCode':
                        $postalCode = $value;
                        break;
                    case 'state':
                        $state = $value;
                        break;
                    case 'city':
                        $city = $value;
                        break;
                    case 'direccion':
                        $direccion = $value;
                        break;
                    case 'phone':
                        $phone = $value;
                        break;
                    case 'horario':
                        $horario = $value;
                        break;
                    case 'opening':
                        $opening = $value;
                        break;
                    case 'latitude':
                        $latitude = $value;
                        break;
                    case 'longitude':
                        $longitude = $value;
                        break;
                    case 'services':
                        $services = $value;
                        break;
                    case 'ZIPList':
                        $ZIPList = $value;
                        break;
                    case 'nearby':
                        $nearby = $value;
                        break;
                    case 'areas':
                        $areas = $value;
                        break;
                    case 'storeSellerId':
                        $storeSellerId = $value;
                        break;
                }
            }
            $itemsStores[] = array(
                "ecommerce: " => $ecommerce, "id: " => $storeSellerId, "name: " => $name, "SC: " => $storeSellerId,
                "ZIP: " => $postalCode, "state: " => $state, "city: " => $city, "address: " => $direccion,
                "phone: " => $phone, "timetable: " => $horario, "opening: " => $opening, "latitude: " => doubleval(str_replace(",", ".", $latitude)), "longitude: " => doubleval(str_replace(",", ".", $longitude)),
                "services: " => $services, "ZIPList: " => $ZIPList, "nearby: " => $nearby, "areas: " => $areas,
            );
        }
        $newStores = array("stores: " => $itemsStores);
        $response4 = json_encode($newStores, JSON_UNESCAPED_UNICODE);

        //Mandar resultados
        return view('convertidor')->with([
            'response' => $response,
            'response2' => $response2,
            'response3' => $response3,
            'response4' => $response4
        ]);
    }


    /***
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
        Convertidor desde un JSON
     ********************************************************************************************************************************************
     ********************************************************************************************************************************************
     ***/

    function archivoJson(Request $request)
    {
        ini_set("memory_limit", "-1");
        set_time_limit(0);
        //Arreglo original, se carga el archivo
        $file = $request->file('file');
        $data = file_get_contents($file);
        //Fin de arreglo original

        //Arreglo de estados
        $arrayEstados = [
            "Aguascalientes",
            "Baja California",
            "Baja California Sur",
            "Campeche",
            "Chiapas",
            "Chihuahua",
            "Ciudad de México",
            "Coahuila",
            "Colima",
            "Durango",
            "Edo. de México",
            "Guanajuato",
            "Guerrero",
            "Hidalgo",
            "Jalisco",
            "Michoacán",
            "Morelos",
            "Nayarit",
            "Nuevo León",
            "Oaxaca",
            "Puebla",
            "Queretaro",
            "Quinatana Roo",
            "San Luis Potosí",
            "Sinaloa",
            "Sonora",
            "Tabasco",
            "Tamaulipas",
            "Tlaxcala",
            "Veracruz",
            "Yucatán",
            "Zacatecas",
        ];
        $arrayEstadosTiendas = array();
        $arregloEstado = [];


        foreach ($arrayEstados as $estado) {
            $states = json_decode($data, true);

            $expected = array_filter($states, function ($var) use ($estado) {
                return ($var['state'] == $estado);
            });

            foreach ($expected as $state) {
                array_push($arregloEstado, $state["storeSellerId"]);
            }

            if (sizeof($arregloEstado) != 0) {
                $arrayEstadosTiendas[] = [
                    "name" => $estado,
                    "stores" => array_map('intval', $arregloEstado)
                ];
            }
            $arregloEstado = [];
        }
        $newStates = array("states: " => $arrayEstadosTiendas);

        $response2 = json_encode($newStates, JSON_UNESCAPED_UNICODE);
        //Fin de arreglo states
        
        //Arreglo store default
        //96043
        $storeDefaut = json_decode($data, true);
        foreach ($storeDefaut as $store_def) {
            $storeSellerId = "96043";
        }
        $new_store_d = array("storeDefault: " => $storeSellerId);
        //echo json_encode($new_store_d, JSON_UNESCAPED_UNICODE);
        $response3 = json_encode(["storeDefault: " => $storeSellerId], JSON_UNESCAPED_UNICODE, JSON_NUMERIC_CHECK);
        //Fin de arrreglo store default

        //Arreglo estates
        $stores = json_decode($data, true);
        //$ouput = "<ul>";
        foreach ($stores as $store) {
            $ecommerce = "";
            $id = "";
            $name = "";
            $SC = "";
            $postalCode = "";
            $state = "";
            $city = "";
            $direccion = "";
            $phone = "";
            $horario = "";
            $opening = "";
            $latitude = "";
            $longitude = "";
            $services = [];
            $ZIPList = [];
            $nearby = [];
            $areas = [];
            $storeSellerId = "";

            foreach ($store as $key => $value) {

                switch ($key) {
                    case 'ecommerce':
                        $ecommerce = $value;
                        break;
                    case 'id':
                        $id = $value;
                        break;
                    case 'name':
                        $name = $value;
                        break;
                    case 'SC':
                        $SC = $value;
                        break;
                    case 'postalCode':
                        $postalCode = $value;
                        break;
                    case 'state':
                        $state = $value;
                        break;
                    case 'city':
                        $city = $value;
                        break;
                    case 'direccion':
                        $direccion = $value;
                        break;
                    case 'phone':
                        $phone = $value;
                        break;
                    case 'horario':
                        $horario = $value;
                        break;
                    case 'opening':
                        $opening = $value;
                        break;
                    case 'latitude':
                        $latitude = $value;
                        break;
                    case 'longitude':
                        $longitude = $value;
                        break;
                    case 'services':
                        $services = $value;
                        break;
                    case 'ZIPList':
                        $ZIPList = $value;
                        break;
                    case 'nearby':
                        $nearby = $value;
                        break;
                    case 'areas':
                        $areas = $value;
                        break;
                    case 'storeSellerId':
                        $storeSellerId = $value;
                        break;
                }
            }
            $itemsStores[] = array(
                "ecommerce: " => $ecommerce, "id: " => $storeSellerId, "name: " => $name, "SC: " => $storeSellerId,
                "ZIP: " => $postalCode, "state: " => $state, "city: " => $city, "address: " => $direccion,
                "phone: " => $phone, "timetable: " => $horario, "opening: " => $opening, "latitude: " => doubleval(str_replace(",", ".", $latitude)), "longitude: " => doubleval(str_replace(",", ".", $longitude)),
                "services: " => $services, "ZIPList: " => $ZIPList, "nearby: " => $nearby, "areas: " => $areas,
            );
        }
        $newStores = array("stores: " => $itemsStores);
        $response4 = json_encode($newStores, JSON_UNESCAPED_UNICODE);

        return view('convertidorJson')->with([
            'response' => $data,
            'response2' => $response2,
            'response3' => $response3,
            'response4' => $response4
        ]);
    }
}// fin de clase Convertidor
