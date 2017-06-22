<?php

require_once(dirname(__FILE__).'/../php/config.php');

class Curl {
    var $url, $port, $apiKey, $cookieName;

    public function __construct() {
        global $config_curl, $config_token;

        $this->url = $config_curl['url'];
        $this->port = $config_curl['port'];
        $this->apiKey = $config_curl['apiKey'];

        $this->cookieName = $config_token;
    }

    function curl($method, $route, $data = null, $order = null, $filter = null) {
        $request = $this->url . '/' . $route;
        $auth = null;
        $return = null;
        $token = isset($_COOKIE[$this->cookieName]) ? $_COOKIE[$this->cookieName] : null;

        if($data) $data = json_encode($data, true);

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

        $token = $token
            ? 'token: '.$token
            : null;

        $orderBy = isset($order)
            ? 'x-order-by: '.$order
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

        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        $result = json_decode($result, true);

        return $result;
    }

    // DEFAULT

    public function get($route, $order = null, $filter = null) {
        return $this->curl('GET', $route, null, $order, $filter);
    }

    public function post($route, $data = null) {
        return $this->curl('POST', $route, $data);
    }

    public function put($route, $data = null) {
        return $this->curl('PUT', $route, $data);
    }

    public function delete($route) {
        return $this->curl('DELETE', $route);
    }

    // USER

    public function userSet($route, $data) {
        $data += [
            'os' => $this->getUserOS(),
            'browser' => $this->getUserBrowser(),
            'ip' => $this->getUserIP()
        ];

        $result = $this->post($route, $data);

        $token = isset($result['token'])
            ? $result['token']
            : null;

        $userId = isset($result['id'])
            ? $result['id']
            : null;

        $this->userUnset();

        setcookie($this->cookieName, $token, time() + (86400 * 30), "/");

        return $userId;
    }

    public function userUnset() {
        unset($_COOKIE[$this->cookieName]);

        setcookie($this->cookieName, '', time() - 3600, '/');

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

    // USER AGENT

    private function getUserOS() {
        $os_platform = "Unknown OS Platform";

        $os_array = [
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        ];

        foreach($os_array as $regex => $value) {
            if(preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    private function getUserBrowser() {
        $browser = "Unknown Browser";

        $browser_array = [
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        ];

        foreach($browser_array as $regex => $value) {
            if(preg_match($regex, $_SERVER['HTTP_USER_AGENT'])) {
                $browser = $value;
            }
        }

        return $browser;
    }

    private function getUserIP() {
        return $_SERVER['REMOTE_ADDR'];
    }
}