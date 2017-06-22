<?php class User {
    var $isActive, $isVerified, $isAdmin;

    var $id, $email, $displayname, $firstname, $surname, $token;

    var $popularity;

    public function __construct() {
        global $curl;

        $this->token = isset($_COOKIE[$curl->cookieName]) ? $_COOKIE[$curl->cookieName] : null;

        $result = isset($this->token)
            ? $curl->get('user/validate')
            : null;

        $data = isset($result['user']) ? $result['user'] : null;

        if($this->token && !$data) $curl->userUnset();

        $this->isActive = isset($this->token) ? true : false;

        $this->id = intval($data['id']);
        $this->isAdmin = intval($data['admin']);
        $this->isVerified = intval($data['verify']);
    }

    // GET

    public function getAsset($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/asset'.$override
            : 'user/id/'.$this->id.'/asset';

        return $system->getAsset($get);
    }

    public function getAssetGroup($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/assetgroup'.$override
            : 'user/id/'.$this->id.'/assetgroup';

        return $system->getAssetGroup($get);
    }

    public function getAssetType($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/assettype'.$override
            : 'user/id/'.$this->id.'/assettype';

        return $system->getAssetType($get);
    }

    public function getAttribute($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/attribute'.$override
            : 'user/id/'.$this->id.'/attribute';

        return $system->getAttribute($get);
    }

    public function getAugmentation($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/augmentation'.$override
            : 'user/id/'.$this->id.'/augmentation';

        return $system->getAugmentation($get);
    }

    public function getBackground($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/background'.$override
            : 'user/id/'.$this->id.'/background';

        return $system->getBackground($get);
    }

    public function getBionic($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/bionic'.$override
            : 'user/id/'.$this->id.'/bionic';

        return $system->getBionic($get);
    }

    public function getDoctrine($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/doctrine'.$override
            : 'user/id/'.$this->id.'/doctrine';

        return $system->getDoctrine($get);
    }

    public function getExpertise($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/expertise'.$override
            : 'user/id/'.$this->id.'/expertise';

        return $system->getExpertise($get);
    }

    public function getFocus($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/focus'.$override
            : 'user/id/'.$this->id.'/focus';

        return $system->getFocus($get);
    }

    public function getGift($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/gift'.$override
            : 'user/id/'.$this->id.'/gift';

        return $system->getGift($get);
    }

    public function getImperfection($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/imperfection'.$override
            : 'user/id/'.$this->id.'/imperfection';

        return $system->getImperfection($get);
    }

    public function getLocation($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/location'.$override
            : 'user/id/'.$this->id.'/location';

        return $system->getLocation($get);
    }

    public function getManifestation($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/manifestation'.$override
            : 'user/id/'.$this->id.'/manifestation';

        return $system->getManifestation($get);
    }

    public function getMilestone($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/milestone'.$override
            : 'user/id/'.$this->id.'/milestone';

        return $system->getMilestone($get);
    }

    public function getPerson($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/person'.$override
            : 'user/id/'.$this->id.'/person';

        return $system->getPerson($get);
    }

    public function getProtection($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/protection'.$override
            : 'user/id/'.$this->id.'/protection';

        return $system->getProtection($get);
    }

    public function getSkill($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/skill'.$override
            : 'user/id/'.$this->id.'/skill';

        return $system->getSkill($get);
    }

    public function getSoftware($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/software'.$override
            : 'user/id/'.$this->id.'/software';

        return $system->getSoftware($get);
    }

    public function getSpecies($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/species'.$override
            : 'user/id/'.$this->id.'/species';

        return $system->getSpecies($get);
    }

    public function getStory($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/story'.$override
            : 'user/id/'.$this->id.'/story';

        return $system->getStory($get);
    }

    public function getWeapon($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/weapon'.$override
            : 'user/id/'.$this->id.'/weapon';

        return $system->getWeapon($get);
    }

    public function getWeaponGroup($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/weapongroup'.$override
            : 'user/id/'.$this->id.'/weapongroup';

        return $system->getWeaponGroup($get);
    }

    public function getWeaponType($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/weapontype'.$override
            : 'user/id/'.$this->id.'/weapontype';

        return $system->getWeaponType($get);
    }

    public function getWorld($override = null) {
        global $system;

        $get = isset($override)
            ? 'user/id/'.$this->id.'/world'.$override
            : 'user/id/'.$this->id.'/world';

        return $system->getWorld($get);
    }
}

