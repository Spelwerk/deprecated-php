<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-22
 * Time: 10:43
 */
class Curl {

    var $url, $port, $apiKey;

    public function __construct($array) {
        $this->url = $array['url'];
        $this->port = $array['port'];
        $this->apiKey = $array['apiKey'];
    }

    public function get($route, $token = null) {
        return $this->curl('GET', $route, null, $token);
    }

    public function post($route, $data = null, $token = null) {
        return $this->curl('POST', $route, $data, $token);
    }

    public function put($route, $data = null, $token = null) {
        return $this->curl('PUT', $route, $data, $token);
    }

    public function delete($route, $token = null) {
        return $this->curl('DELETE', $route, null, $token);
    }

    public function user($route, $token) {
        $return = [];

        $curl = $this->curl('GET', $route, null, $token);

        if($curl['error']) {
            $return = $curl;
        } else {
            $return['user'] = $curl['user'];
        }

        return $return;
    }

    function curl($method, $route, $data, $token) {
        $request = $this->url . '/' . $route;
        $auth = null;
        $return = null;

        if($data) {
            $data = json_encode($data, JSON_NUMERIC_CHECK);
        }

        $curl = curl_init();

        switch ($method)
        {
            case 'GET':
                break;

            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                if($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;

            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                if($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;

            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;

            default: break;
        }

        if($token) {
            $auth = 'token: '.$token;
        }

        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_PORT, $this->port);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'apikey: '.$this->apiKey,
            $auth
        ]);

        $result = curl_exec($curl);

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $result = json_decode($result, true);

        switch($statusCode)
        {
            case 200:
            case 201:
            case 202:
                $return = $result;
                break;

            default:
                $return = [
                    'error' => true,
                    'code' => $statusCode,
                    'header' => $result['header'],
                    'message' => $result['message']
                ];
                break;
        }

        return $return;
    }
}