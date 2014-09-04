<?php
namespace SugarClient;

class Request
{
    public static function callMethod($method, $parameters)
    {
        ob_start();
        $request = curl_init();

        curl_setopt($request, CURLOPT_URL, Session::$url);
        curl_setopt($request, CURLOPT_POST, 1);
        curl_setopt($request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($request, CURLOPT_HEADER, 1);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_FOLLOWLOCATION, 0);

        $post = array(
            "method" => $method,
            "input_type" => "JSON",
            "response_type" => "JSON",
            "rest_data" => json_encode($parameters)
        );

        curl_setopt($request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($request);
        curl_close($request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }
}