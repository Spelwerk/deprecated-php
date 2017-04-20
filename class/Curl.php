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

    public function get($route, $token = null, $filter = null) {
        return $this->curl('GET',$route,null,$token,$filter);
    }

    public function post($route, $data = null, $token = null) {
        return $this->curl('POST',$route,$data,$token);
    }

    public function put($route, $data = null, $token = null) {
        return $this->curl('PUT',$route,$data,$token);
    }

    public function delete($route, $data = null, $token = null) {
        return $this->curl('DELETE',$route,$data,$token);
    }

    public function user($route, $token) {
        $return = [];

        $curl = $this->curl('GET',$route,null,$token);

        if($curl['error']) {
            $return = $curl;
        } else {
            $return['user'] = $curl['user'];
        }

        return $return;
    }

    function curl($method, $route, $data = null, $token = null, $filter = null) {
        $request = $this->url . '/' . $route;
        $auth = null;
        $return = null;

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