<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-10
 * Time: 09:09
 */

require_once('feature/Attribute.php');
require_once('feature/Augmentation.php');
require_once('feature/Bionic.php');
require_once('feature/Caste.php');
require_once('feature/Characteristic.php');
require_once('feature/Expertise.php');
require_once('feature/Focus.php');
require_once('feature/Identity.php');
require_once('feature/Manifestation.php');
require_once('feature/Milestone.php');
require_once('feature/Nature.php');
require_once('feature/Species.php');
require_once('feature/Weapon.php');

require_once('World.php');

class Person {

    var $id, $hash, $popularity, $nickname, $firstname, $surname, $age, $gender, $occupation,
        $description, $behaviour, $appearance, $features, $personality;

    var $isTemplate, $isCheater, $isSupernatural, $isOwner, $isCalculated;

    var $pointSupernatural, $pointPotential, $pointMoney, $pointSkill, $pointExpertise, $pointUpbringing,
        $pointMilestone, $pointGift, $pointImperfection, $pointRelationship;

    var $world, $species, $caste, $nature, $identity, $manifestation, $focus;

    public function __construct($id = null, $hash = null) {
        global $curl;

        $get = $hash != null
            ? 'person/hash/'.$hash
            : 'person/id/'.$id;

        $data = $curl->get($get)['data'][0];

        $this->isOwner = isset($hash)
            ? true
            : false;

        $this->hash = isset($hash)
            ? $hash
            : null;

        $this->id = $data['id'];
        $this->nickname = $data['nickname'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];
        $this->age = $data['age'];
        $this->gender = $data['gender'];
        $this->occupation = $data['occupation'];
        $this->popularity = $data['popularity'];

        $this->description = $data['description'];
        $this->behaviour = $data['behaviour'];
        $this->appearance = $data['appearance'];
        $this->features = $data['features'];
        $this->personality = $data['personality'];

        $this->isTemplate = $data['template'];
        $this->isCheater = $data['cheated'];
        $this->isSupernatural = $data['supernatural'];
        $this->isCalculated = $data['calculated'];

        $this->pointSupernatural = intval($data['point_supernatural']);
        $this->pointPotential = intval($data['point_potential']);
        $this->pointMoney = intval($data['point_money']);
        $this->pointSkill = intval($data['point_skill']);
        $this->pointExpertise = intval($data['point_expertise']);
        $this->pointUpbringing = intval($data['point_milestone_upbringing']);
        $this->pointMilestone = intval($data['point_milestone_flexible']);
        $this->pointGift = intval($data['point_characteristic_gift']);
        $this->pointImperfection = intval($data['point_characteristic_imperfection']);
        $this->pointRelationship = intval($data['point_relationship']);

        $this->world = isset($data['world_id'])
            ? new World($data['world_id'])
            : null;

        $this->species = isset($data['species_id'])
            ? new Species($data['species_id'])
            : null;

        $this->caste = isset($data['caste_id'])
            ? new Caste($data['caste_id'])
            : null;

        $this->nature = isset($data['nature_id'])
            ? new Nature($data['nature_id'])
            : null;

        $this->identity = isset($data['identity_id'])
            ? new Identity($data['identity_id'])
            : null;

        $this->manifestation = isset($data['manifestation_id'])
            ? new Manifestation($data['manifestation_id'])
            : null;

        $this->focus = isset($data['focus_id'])
            ? new Focus($data['focus_id'])
            : null;
    }


    public function getCharacteristic($gift) {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-characteristic/id/'.$this->id.'/gift/'.$gift);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Characteristic(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getMilestone($upbringing) {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-milestone/id/'.$this->id.'/upbringing/'.$upbringing);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Milestone(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getAttribute($type) {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-attribute/id/'.$this->id.'/type/'.$type);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Attribute(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getExpertise($type = null) {
        global $curl;

        $arrayList = [];

        $get = isset($type)
            ? 'person-expertise/id/'.$this->id.'/type/'.$type
            : 'person-expertise/id/'.$this->id;

        $return = $curl->get($get);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $expertise) {
                $arrayList[] = new Expertise(null, $expertise);
            }

            return $arrayList;
        } else {
            return null;
        }
    }

    public function getWeapon() {
        global $curl;

        $arrayList = [];

        $return = $curl->get('person-weapon/id/'.$this->id);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Weapon(null, $array);
            }

            return $arrayList;
        } else {
            return null;
        }
    }


    function countAttribute($type) {
        $list = $this->getAttribute($type);

        $total = 0;

        if(isset($list)) {
            foreach($list as $attribute) {
                $total += $attribute->value;
            }
        }

        return $total;
    }

    function countExpertise() {
        $list = $this->getExpertise();

        $total = 0;

        if(isset($list)) {
            foreach($list as $expertise) {
                $math = 0;

                for($i = 1; $i <= $expertise->level; $i++) {
                    $math += $i;
                }

                $total += $math;
            }
        }

        return $total;
    }


    public function canWeapon() {
        $currentWeapon = count($this->getWeapon());

        return $currentWeapon;
    }


    public function buildButton($title, $description, $value, $data, $icon = null) {
        echo(
            '<button type="button" class="sw-c-button__item sw-js-roll-button" '.$data.'>'.
            '<div class="sw-c-button__content">'.
            '<div class="sw-c-button__icon"><img src="/img/missing_icon.png"/></div>'.
            '<div class="sw-c-button__title sw-js-button-title">'.$title.'</div>'.
            '<div class="sw-c-button__value">'.$value.'</div></div>'.
            '<div class="sw-js-button-information sw-is-hidden">'.$description.'</div></button>'
        );
    }

    public function buildList($title, $description, $icon = null) {
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        echo(
            '<div class="sw-c-list__item sw-js-list-item">'.
            '<div class="sw-c-list__header sw-js-list-header">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '<div class="sw-c-list__chevron">'.
            '<img class="sw-js-chevron-down" src="/img/chevron-down.png"/>'.
            '<img class="sw-js-chevron-up sw-is-hidden" src="/img/chevron-up.png"/>'.
            '</div>'.
            '</div>'.
            '<div class="sw-c-list__information sw-js-list-information sw-is-hidden">'.
            '<div class="sw-c-list__description">'.$description.'</div>'.
            '<div class="sw-c-list__settings">'.
            '<button type="button" class="sw-c-list__settings__button sw-js-edit">'.
            '<img src="/img/edit.png"/></button></div>'.
            '</div></div>'
        );
    }

    public function buildCard($list, $modifier = null) {
        echo('<div class="sw-c-card">');

        foreach($list as $object) {
            echo(
                '<div class="sw-c-card__item'.$modifier.'">'.
                '<div class="sw-c-card__title">'.$object->name.'</div>'.
                '<div class="sw-c-card__value">'.$object->value.'</div></div>'
            );
        }

        echo('</div>');
    }


    public function makeConsumable($list) {
        echo('<div class="sw-c-button">');

        foreach($list as $consumable) {
            $value = $consumable->value.'d12';

            $data = 'data-roll-type="consumable" data-roll-d12="'.$value.'"';

            $this->buildButton($consumable->name, $consumable->description, $value, $data);
        }

        echo('</div>');
    }

    public function makeSkill($list) {
        echo('<div class="sw-c-button">');

        foreach($list as $skill) {
            $value = $skill->value > 0
                ? '2d12+'.$skill->value
                : '2d12';

            $data = 'data-roll-type="default" data-roll-d12="2" data-roll-bonus="'.$skill->value.'"';

            $this->buildButton($skill->name, $skill->description, $value, $data);
        }

        echo('</div>');
    }

    public function makeExpertise() {
        echo('<div class="sw-c-button">');

        foreach($this->getExpertise($this->world->expertiseDice) as $expertise) {
            $rollD12 = 2 + intval($expertise->dice);
            $rollBonus = $expertise->skillValue;

            $value = $rollD12.'d12+'.$rollBonus;

            $data = 'data-roll-type="default" data-roll-d12="'.$rollD12.'" data-roll-bonus="'.$rollBonus.'"';

            $this->buildButton($expertise->name, $expertise->description, $value, $data);
        }

        echo('</div>');
    }

    public function makeSupernatural() {
        echo('<div class="sw-c-button">');

        foreach($this->getAttribute($this->manifestation->attributeType) as $supernatural) {
            $rollD12 = 2;
            $rollBonus = 0;

            foreach($this->getExpertise($this->manifestation->expertiseType) as $expertise) {
                if($expertise->attribute['id'] == $supernatural->id) {
                    $rollD12 += intval($expertise->dice);
                    $rollBonus += intval($expertise->skillValue);
                }
            }

            $value = $supernatural->value.'d12';

            $data = 'data-roll-type="supernatural" data-roll-d12="'.$rollD12.'" data-roll-bonus="'.$rollBonus.'" data-strike-d12="'.$supernatural->value.'"';

            $this->buildButton($supernatural->name, $supernatural->description, $value, $data);
        }

        echo('</div>');
    }

    public function makeWeapon() {
        echo('<div class="sw-c-button">');

        foreach($this->getWeapon() as $weapon) {
            $hitD12 = 2 + intval($weapon->expertiseLevel);
            $hitBonus = intval($weapon->damageBonus) + intval($weapon->hit);

            $value = isset($weapon->damageBonus)
                ? $weapon->damageD12.'d12+'.$weapon->damageBonus
                : $weapon->damageD12.'d12';

            $data = 'data-roll-type="weapon" data-roll-d12="'.$hitD12.'" data-roll-bonus="'.$hitBonus.'" data-strike-d12="'.$weapon->damageD12.'" data-strike-bonus="'.$weapon->damageBonus.'" data-strike-critical="'.$weapon->criticalD12.'"';

            $this->buildButton($weapon->name, $weapon->description, $value, $data);
        }

        echo('</div>');
    }

    public function makeCharacteristic() {
        echo('<div class="sw-c-list">');

        foreach($this->getCharacteristic(1) as $gift) {
            $this->buildList($gift->name, $gift->description);
        }

        foreach($this->getCharacteristic(0) as $imperfection) {
            $this->buildList($imperfection->name, $imperfection->description);
        }

        echo('</div>');
    }

    public function makeMilestone() {
        echo('<div class="sw-c-list">');

        foreach($this->getMilestone(1) as $upbringing) {
            $this->buildList($upbringing->name, $upbringing->description);
        }

        foreach($this->getMilestone(0) as $flexible) {
            $this->buildList($flexible->name, $flexible->description);
        }

        echo('</div>');
    }

    public function makeFeatures() {
        echo('<div class="sw-c-list">');

        $this->buildList($this->species->name, $this->species->description);

        $this->buildList($this->caste->name, $this->caste->description);

        $this->buildList($this->nature->name, $this->nature->description);

        $this->buildList($this->identity->name, $this->identity->description);

        echo('</div>');
    }

    public function makeSupernaturalInformation() {
        echo('<div class="sw-c-list">');

        $this->buildList($this->manifestation->name, $this->manifestation->description);

        $this->buildList($this->focus->name, $this->focus->description);

        echo('</div>');
    }
}