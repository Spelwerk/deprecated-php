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
                $this->tableManyRelationDelete($this->context, $this->id, $this->context2);
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
                break;

            case 'post--expertise':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);

                $this->curl->put('person/id/'.$this->id, ['point_expertise' => 0]);
                break;

            case 'post--doctrine':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);

                $this->curl->put('person/id/'.$this->id, ['point_doctrine' => 0]);
                break;

            case 'post--description':
                $this->data['calculated'] = 1;
                $this->curl->put('person/id/'.$this->id, $this->data);
                break;

            // RELATION WITH EXPERIENCE

            case 'relation--value--post':
                $this->tableManyRelationPostWithValue($this->context, $this->id, $this->context2);
                if($this->experience) $this->curl->post('person/id/'.$this->id.'/attribute', ['insert_id' => $this->experience, 'value' => $this->points]);
                break;

            // SPECIFIC

            case 'augmentation':
                $this->personAugmentation($this->id);
                break;

            case 'cheat':
                $this->curl->put('person/id/'.$this->id.'/cheat', $this->data);
                break;

            case 'heal':
                $this->curl->put('person/id/'.$this->id.'/'.$this->context.'/'.$this->context2.'/heal/'.$this->extra, $this->data);
                break;

            case 'equip':
                $this->curl->put('person/id/'.$this->id.'/'.$this->context.'/'.$this->extra.'/equip');
                break;

            case 'unequip':
                $this->curl->put('person/id/'.$this->id.'/'.$this->context.'/'.$this->extra.'/unequip');
                break;

            case 'activate':
                $this->curl->put('person/id/'.$this->id.'/augmentation/'.$this->extra.'/bionic/'.$this->extra2.'/activate');
                break;

            case 'deactivate':
                $this->curl->put('person/id/'.$this->id.'/augmentation/'.$this->extra.'/bionic/'.$this->extra2.'/deactivate');
                break;

        }
    }

    public function switchUser() {
        switch($this->do) {
            default: break;

            case 'post':
                $result = $this->curl->userSet('user', $this->data);
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
                $result = $this->curl->userSet('user/login/password', $this->data);
                break;

            case 'login--email':
                $result = $this->curl->post('user/login/email', $this->data);
                break;

            case 'login--verify':
                $result = $this->curl->userSet('user/login/verify', $this->data);
                break;

            case 'logout':
                $this->curl->userUnset();
                break;

            case 'email':
                $result = $this->curl->post('user/email/email', $this->data);
                break;

            case 'email--verify':
                $result = $this->curl->userSet('user/email/verify', $this->data);
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
}