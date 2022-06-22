<?php

if (!function_exists('fecha_a_utc')) {
    function fecha_a_utc($fecha)
    {
        if (is_a($fecha, 'DateTime')) {
            return str_replace(' ', 'T', $fecha->format('Y-m-d H:i:s')) . 'Z';
        } else {
            return str_replace(' ', 'T', $fecha) . 'Z';
        }
    }
}

if (!function_exists('utc_a_fecha')) {
    function utc_a_fecha($fecha)
    {
        return substr(str_replace('T', ' ', $fecha), 0, 19);
    }
}

if (!function_exists('valor_array')) {
    function valor_array($arr)
    {
        if ($arr != NULL && is_array($arr) && count($arr) > 0) {
            return $arr[0];
        } else {
            return NULL;
        }
    }
}

