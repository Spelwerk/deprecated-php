<?php

require_once('Curl.php');

class Post {
    var $curl;

    var $post, $data;

    var $do, $special;

    var $returnBase, $returnStart, $returnLast, $returnID;

    var $id;

    var $context, $context2;

    var $extra, $extra2;

    var $points;

    public function __construct() {
        global $baseUrl;

        $this->curl = new Curl();

        $this->post = [];
        $this->data = [];

        unset($_POST['x']);
        unset($_POST['y']);

        foreach($_POST as $key => $value) {
            $explode = explode('--', $key);

            if($explode[0] == 'post') {
                $this->post[$explode[1]] = $value;
            } else {
                $this->data[$explode[1]] = $value;
            }
        }

        $this->do = isset($this->post['do']) ? $this->post['do'] : null;
        $this->special = isset($this->post['special']) ? $this->post['special'] : null;

        $this->id = isset($this->post['id']) ? $this->post['id'] : null;

        $this->context = isset($this->post['context']) ? $this->post['context'] : null;
        $this->context2 = isset($this->post['context2']) ? $this->post['context2'] : null;

        $this->extra = isset($this->post['extra']) ? $this->post['extra'] : null;
        $this->extra2 = isset($this->post['extra2']) ? $this->post['extra2'] : null;

        $this->points = isset($this->post['points']) ? $this->post['points'] : null;
        $this->experience = isset($this->post['experience']) ? $this->post['experience'] : null;

        $this->returnBase = $baseUrl;
        $this->returnStart = isset($this->post['return']) ? $this->post['return'] : null;
        $this->returnLast = isset($this->post['returnafter']) ? $this->post['returnafter'] : null;
        $this->returnID = isset($this->post['returnid']) ? $this->post['returnid'] : null;
    }

    public function switchTop() {
        switch($this->special) {
            default:
                $this->switchDefault();
                break;

            case 'person':
                $this->switchPerson();
                break;

            case 'user':
                $this->switchUser();
                break;
        }
    }

    public function switchDefault() {
        switch($this->do) {
            default: break;

            case 'post':
                $result = $this->curl->post($this->context, $this->data);
                $this->id = $result['id'];
                break;

            case 'put':
                $this->curl->put($this->context.'/id/'.$this->id, $this->data);
                break;

            case 'delete':
                $this->curl->delete($this->context.'/id/'.$this->id);
                break;

            // CONTEXT

            case 'context--post':
                $this->curl->post($this->context.'/id/'.$this->id.'/'.$this->context2, $this->data);
                break;

            case 'context--put':
                $this->curl->put($this->context.'/id/'.$this->id.'/'.$this->context2, $this->data);
                break;

            case 'context--delete':
                $this->curl->delete($this->context.'/id/'.$this->id.'/'.$this->context2.'/'.$this->extra);
                break;

            // MANY RELATION

            case 'relation--post':
                $this->tableManyRelationPost($this->context, $this->id, $this->context2);
                break;

            case 'relation--put':
                break;

            case 'relation--delete':
                break;

            // MANY RELATION WITH VALUE

            case 'relation--value--post':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);
                break;

            case 'relation--value--put':
                break;

            case 'relation--value--delete':
                $this->tableManyRelationDelete($this->context, $this->id, $this->context2);
        }
    }

    public function switchPerson() {
        switch($this->do) {
            default: break;

            // CREATING THE PERSON

            case 'post--power':
                $this->tableManyRelationPutWithValue('person', $this->id, 'attribute');

                $this->curl->put('person/id/'.$this->id, ['point_power' => 0]);
                break;

            case 'post--money':
                $this->tableManyRelationPutWithValue('person', $this->id, 'attribute');

                $this->curl->put('person/id/'.$this->id, ['point_money' => 0]);
                break;

            case 'post--gift':
                $calc = intval($this->points) - 1;

                $this->curl->post('person/id/'.$this->id.'/gift', $this->data);

                $this->curl->put('person/id/'.$this->id, ['point_gift' => $calc]);
                break;

            case 'post--imperfection':
                $calc = intval($this->points) - 1;

                $this->curl->post('person/id/'.$this->id.'/imperfection', $this->data);

                $this->curl->put('person/id/'.$this->id, ['point_imperfection' => $calc]);
                break;

            case 'post--milestone':
                $calc = intval($this->points) - 1;

                $this->curl->post('person/id/'.$this->id.'/milestone', $this->data);

                $this->curl->put('person/id/'.$this->id, ['point_milestone' => $calc]);
                break;

            case 'post--skill':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);

                $this->curl->put('person/id/'.$this->id, ['point_skill' => 0]);

                if($this->experience) $this->curl->put('person/id/'.$this->id.'/attribute', ['insert_id' => $this->experience, 'value' => $this->points]);
                break;

            case 'post--expertise':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);

                $this->curl->put('person/id/'.$this->id, ['point_expertise' => 0]);

                if($this->experience) $this->curl->put('person/id/'.$this->id.'/attribute', ['insert_id' => $this->experience, 'value' => $this->points]);
                break;

            case 'post--doctrine':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);

                $this->curl->put('person/id/'.$this->id, ['point_doctrine' => 0]);

                if($this->experience) $this->curl->put('person/id/'.$this->id.'/attribute', ['insert_id' => $this->experience, 'value' => $this->points]);
                break;

            case 'post--description':
                $this->data['calculated'] = 1;
                $this->curl->put('person/id/'.$this->id, $this->data);
                break;

            // RELATION WITH EXPERIENCE

            case 'relation--value--post':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);
                if($this->experience) $this->curl->put('person/id/'.$this->id.'/attribute', ['insert_id' => $this->experience, 'value' => $this->points]);
                break;

            // SPECIFIC

            case 'augmentation':
                $this->personAugmentation($this->id);
                break;

            case 'cheat':
                $this->curl->put('person/id/'.$this->id.'/cheat', $this->data);
                break;

            case 'equip':
                $this->curl->put('person/id/'.$this->id.'/'.$this->context.'/'.$this->context2.'/equip/'.$this->extra);
                break;

            case 'heal':
                $this->curl->put('person/id/'.$this->id.'/'.$this->context.'/'.$this->context2.'/heal/'.$this->extra, $this->data);
                break;
        }
    }

    public function switchUser() {
        switch($this->do) {
            default: break;

            case 'post':
                $this->userSet('user');
                break;

            case 'post--timeout':
                $result = $this->curl->post('user/verify/email', $this->data);
                break;

            case 'post--verify':
                $result = $this->curl->post('user/verify/verify', $this->data);
                break;

            case 'put':
                $result = $this->curl->put('user/id/'.$this->id, $this->data);
                break;

            case 'login--password':
                $this->userSet('user/login/password');
                break;

            case 'login--email':
                $result = $this->curl->post('user/login/email', $this->data);
                break;

            case 'login--verify':
                $this->userSet('user/login/verify');
                break;

            case 'logout':
                $this->userUnset();
                break;

            case 'email':
                $result = $this->curl->post('user/email/email', $this->data);
                break;

            case 'email--verify':
                $this->userSet('user/email/verify');
                break;

            case 'password':
                $result = $this->curl->post('user/password/email', $this->data);
                break;

            case 'password--verify':
                $result = $this->curl->post('user/password/verify', $this->data);
                break;

            case 'save':
                $result = $this->curl->post('user/id/'.$this->id.'/'.$this->context, ['insert_id' => $this->context2]);
                break;

            case 'admin':
                $result = $this->curl->put('user/id/'.$this->id.'/admin', $this->data);
                break;

            case 'delete':
                $result = $this->curl->delete('user/id/'.$this->id);
        }
    }

    // REDIRECT

    public function redirect($url) {
        ob_start();
        header('Location: '.$url, true, 303);
        ob_end_flush();
        exit;
    }

    public function getReturn() {
        $rBase = $this->returnBase;
        $rStart = isset($this->returnStart) ? '/'.$this->returnStart : null;
        $postID = isset($this->id) ? '/'.$this->id : null;
        $rLast = isset($this->returnLast) ? '/'.$this->returnLast : null;
        $rID = isset($this->returnID) ? '#'.$this->returnID : null;

        return $rBase.$rStart.$postID.$rLast.$rID;
    }

    // USER

    public function userSet($route) {
        global $config_token;

        $this->data += [
            'os' => $this->getUserOS(),
            'browser' => $this->getUserBrowser(),
            'ip' => $this->getUserIP()
        ];

        $result = $this->curl->post($route, $this->data);

        $token = isset($result['token'])
            ? $result['token']
            : null;

        $userId = isset($result['id'])
            ? $result['id']
            : null;

        $this->userUnset();

        setcookie($config_token, $token, time() + (86400 * 30), "/");

        return $userId;
    }

    public function userUnset() {
        global $config_token;

        unset($_COOKIE[$config_token]);

        setcookie($config_token, '', time() - 3600, '/');

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

    // TABLE

    private function tableManyRelationPost($ownerTableName, $ownerTableId, $relationTableName) {
        foreach($this->data as $key => $value) {
            $this->curl->post($ownerTableName.'/id/'.$ownerTableId.'/'.$relationTableName, ['insert_id' => $value]);
        }
    }

    private function tableManyRelationDelete($ownerTableName, $ownerTableId, $relationTableName) {
        foreach($this->data as $key => $value) {
            $this->curl->delete($ownerTableName.'/id/'.$ownerTableId.'/'.$relationTableName.'/'.$value);
        }
    }

    private function tableManyRelationPostWithValue($ownerTableName, $ownerTableId, $relationTableName) {
        foreach($this->data as $key => $value) {
            $explode = explode('__', $key);

            if(isset($explode[1])) {
                $this->curl->post($ownerTableName.'/id/'.$ownerTableId.'/'.$relationTableName, ['insert_id' => $explode[1], 'value' => $value]);
            }
        }
    }

    private function tableManyRelationPutWithValue($ownerTableName, $ownerTableId, $relationTableName) {
        foreach($this->data as $key => $value) {
            $explode = explode('__', $key);

            if(isset($explode[1])) {
                $this->curl->put($ownerTableName.'/id/'.$ownerTableId.'/'.$relationTableName, ['insert_id' => $explode[1], 'value' => $value]);
            }
        }
    }

    // PERSON

    private function personAugmentation($personId) {
        $bionicId = $this->data['bionic_id'];

        foreach($this->data as $key => $value) {
            if($key == $value) {
                $this->curl->post('person/id/'.$personId.'/augmentation', ['insert_id' => $value, 'bionic_id' => $bionicId]);
            }
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