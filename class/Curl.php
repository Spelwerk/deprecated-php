<?php

require_once(dirname(__FILE__).'/../php/config.php');

class Curl {

    var $url, $port, $apiKey, $tokenCookie;

    public function __construct($array = null, $tokenCookie = null) {
        global $config_curl, $cookieArray;

        $this->url = $config_curl['url'];
        $this->port = $config_curl['port'];
        $this->apiKey = $config_curl['apiKey'];

        $this->tokenCookie = $cookieArray['token'];
    }

    public function get($route, $filter = null) {
        return $this->curl('GET',$route,null,$filter);
    }

    public function post($route, $data = null) {
        return $this->curl('POST',$route,$data);
    }

    public function put($route, $data = null) {
        return $this->curl('PUT',$route,$data);
    }

    public function delete($route, $data = null) {
        return $this->curl('DELETE',$route,$data);
    }

    public function user($route) {
        $return = [];

        $curl = $this->curl('GET',$route);

        if($curl['error']) {
            $return = $curl;
        } else {
            $return['user'] = $curl['user'];
        }

        return $return;
    }

    function curl($method, $route, $data = null, $filter = null) {
        $request = $this->url . '/' . $route;
        $auth = null;
        $return = null;
        $token = isset($_COOKIE[$this->tokenCookie]) ? $_COOKIE[$this->tokenCookie] : null;

        if($data) {
            $data = json_encode($data, true);
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
                if($data) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;

            default: break;
        }

        $token = $token
            ? 'token: '.$token
            : null;

        $orderBy = $filter && isset($filter['order-by'])
            ? 'x-order-by: '.$filter['order-by']
            : null;

        $paginationLimit = $filter && isset($filter['limit-from'])
            ? 'x-pagination-limit: '.$filter['limit-from']
            : null;

        $paginationAmount = $filter && isset($filter['limit-to'])
            ? 'x-pagination-amount: '.$filter['limit-to']
            : null;

        curl_setopt($curl, CURLOPT_URL, $request);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_PORT, $this->port);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'apikey: '.$this->apiKey,
            $token,
            $orderBy,
            $paginationLimit,
            $paginationAmount
        ]);

        $result = curl_exec($curl);

        //$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $result = json_decode($result, true);

        return $result;
    }
}