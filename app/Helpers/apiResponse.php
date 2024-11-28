<?php

function responseSuccess($data = null, $status = 200, $message = null)
{
    $response = [];
    if ($data)
        $response["data"] = $data;
    if ($message)
        $response["message"] = $message;
    return response()->json($response, $status);
}


function responseError($message = null, $status = 500)
{
    $response["message"] = $message;
    return response()->json($response, $status);
}

function calculatePercentage($todaySales, $amount)
{
    return $amount != 0 ? (int)number_format(min(($amount / $todaySales) * 100, 100), 2) : 0;

    // return $amount != 0 ? min(($amount / $todaySales) * 100, 100) : 0;
}


function calculateTotalPercentage($todaySales, $amount)
{
    return $amount != 0 ? (int)number_format(min(($amount / $todaySales) * 100, 100), 2) : 0;

    // return $amount != 0 ? min(($amount / $todaySales) * 100, 100) : 0;
}
