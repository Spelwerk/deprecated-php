<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-22
 * Time: 13:09
 */
class User {
    var $isActive, $isVerified, $isAdmin;

    var $id, $email, $displayname, $firstname, $surname, $token;

    public function __construct() {
        global $curl, $cookieArray;

        $this->token = isset($_COOKIE[$cookieArray['token']])
            ? $_COOKIE[$cookieArray['token']]
            : null;

        $result = isset($this->token)
            ? $curl->get('user/validate', $this->token)
            : null;

        $data = isset($result['user'])
            ? $result['user']
            : null;

        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->displayname = $data['displayname'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];

        $this->isActive = isset($this->token)
            ? true
            : false;

        $this->isAdmin = intval($data['admin']);
        $this->isVerified = intval($data['verify']);
    }

    // GET

    public function getAttribute($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/attribute'.$override
            : 'user/id/'.$this->id.'/attribute';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Attribute($id['id']);
            }
        }

        return $arrayList;
    }

    public function getAugmentation($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/augmentation'.$override
            : 'user/id/'.$this->id.'/augmentation';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Augmentation($id['id']);
            }
        }

        return $arrayList;
    }

    public function getBackground($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/background'.$override
            : 'user/id/'.$this->id.'/background';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Background($id['id']);
            }
        }

        return $arrayList;
    }

    public function getBionic($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/bionic'.$override
            : 'user/id/'.$this->id.'/bionic';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Bionic($id['id']);
            }
        }

        return $arrayList;
    }

    public function getDoctrine($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/doctrine'.$override
            : 'user/id/'.$this->id.'/doctrine';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Doctrine($id['id']);
            }
        }

        return $arrayList;
    }

    public function getExpertise($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/expertise'.$override
            : 'user/id/'.$this->id.'/expertise';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Expertise($id['id']);
            }
        }

        return $arrayList;
    }

    public function getFocus($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/focus'.$override
            : 'user/id/'.$this->id.'/focus';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Focus($id['id']);
            }
        }

        return $arrayList;
    }

    public function getGift($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/gift'.$override
            : 'user/id/'.$this->id.'/gift';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Gift($id['id']);
            }
        }

        return $arrayList;
    }

    public function getImperfection($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/imperfection'.$override
            : 'user/id/'.$this->id.'/imperfection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Imperfection($id['id']);
            }
        }

        return $arrayList;
    }

    public function getManifestation($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/manifestation'.$override
            : 'user/id/'.$this->id.'/manifestation';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Manifestation($id['id']);
            }
        }

        return $arrayList;
    }

    public function getMilestone($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/milestone'.$override
            : 'user/id/'.$this->id.'/milestone';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Milestone($id['id']);
            }
        }

        return $arrayList;
    }

    public function getPerson($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/person'.$override
            : 'user/id/'.$this->id.'/person';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $item) {
                $arrayList[] = new Person($item['id'], $item['secret']);
            }
        }

        return $arrayList;
    }

    public function getProtection($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/protection'.$override
            : 'user/id/'.$this->id.'/protection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Protection($id['id']);
            }
        }

        return $arrayList;
    }

    public function getSkill($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/skill'.$override
            : 'user/id/'.$this->id.'/skill';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Skill($id['id']);
            }
        }

        return $arrayList;
    }

    public function getSpecies($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/species'.$override
            : 'user/id/'.$this->id.'/species';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Species($id['id']);
            }
        }

        return $arrayList;
    }

    public function getStory($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/story'.$override
            : 'user/id/'.$this->id.'/story';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $item) {
                $arrayList[] = new Story($item['id'], $item['secret']);
            }
        }

        return $arrayList;
    }

    public function getWeapon($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/weapon'.$override
            : 'user/id/'.$this->id.'/weapon';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new Weapon($id['id']);
            }
        }

        return $arrayList;
    }

    public function getWorld($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/world'.$override
            : 'user/id/'.$this->id.'/world';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $id) {
                $arrayList[] = new World($id['id']);
            }
        }

        return $arrayList;
    }
}

