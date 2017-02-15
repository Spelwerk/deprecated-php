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
require_once('feature/Wound.php');

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

        $data = $curl->get('person/id/'.$id)['data'][0];

        $this->hash = isset($hash)
            ? $hash
            : null;

        $this->isOwner = isset($this->hash)
            ? true
            : false;

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
        $this->pointPower= intval($data['point_power']);
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


    public function getCharacteristic($gift = null) {
        global $curl;

        $arrayList = null;

        $get = isset($gift)
            ? 'person-characteristic/id/'.$this->id.'/gift/'.$gift
            : 'person-characteristic/id/'.$this->id;

        $return = $curl->get($get);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Characteristic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMilestone($upbringing = null) {
        global $curl;

        $arrayList = null;

        $get = isset($upbringing)
            ? 'person-milestone/id/'.$this->id.'/upbringing/'.$upbringing
            : 'person-milestone/id/'.$this->id;

        $return = $curl->get($get);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Milestone(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAttribute($type = null, $id = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'person-attribute/id/'.$this->id.'/type/'.$type
            : 'person-attribute/id/'.$this->id.'/attribute/'.$id;

        $return = $curl->get($get);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }

    public function getExpertise($type = null) {
        global $curl;

        $arrayList = null;

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
        }

        return $arrayList;
    }

    public function getWeapon() {
        global $curl;

        $arrayList = null;

        $return = $curl->get('person-weapon/id/'.$this->id);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Weapon(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWound($lethal = null) {
        global $curl;

        $arrayList = null;

        $get = isset($lethal)
            ? 'person-wound/id/'.$this->id.'/lethal/'.$lethal
            : 'person-wound/id/'.$this->id;

        $return = $curl->get($get);

        $data = isset($return['data'])
            ? $return['data']
            : null;

        if($data) {
            foreach ($data as $array) {
                $arrayList[] = new Wound(null, $array);
            }
        }

        return $arrayList;
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
        $icon = isset($icon)
            ? $icon
            : '/img/missing_icon.png';

        echo(
            '<button type="button" class="sw-c-button__item sw-js-roll-button" '.$data.'>'.
            '<div class="sw-c-button__content">'.
            '<div class="sw-c-button__icon"><img src="'.$icon.'"/></div>'.
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
            '</div>'.
            '</div>'
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

    function buildRemoval($id, $name, $icon, $thing) {
        echo(
            '<div class="sw-c-list__item">'.
            '<div class="sw-c-list__header">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$name.'</div>'.
            '<div class="sw-c-list__icon">'.
            '<form action="/post.php" method="post">'.
            '<input type="hidden" name="post--return" value="play"/>'.
            '<input type="hidden" name="post--do" value="person--remove--thing"/>'.
            '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
            '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
            '<input type="hidden" name="thing--table" value="'.$thing.'"/>'.
            '<input type="hidden" name="thing--id" value="'.$id.'"/>'.
            '<input class="sw-c-list__submit" type="image" src="/img/remove.png" alt="Submit" />'.
            '</form>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    function buildWound($title, $woundId, $icon, $heal, $aid) {
        $t = $heal == 1 && $aid == 1
            ? ' sw-is-opacity'
            : null;

        $h = $heal == 1
            ? ' sw-is-opacity'
            : null;

        $a = $aid == 1
            ? ' sw-is-opacity'
            : null;

        $healButton = $aid == 1
            ?   '<div class="sw-c-list__icon">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="wound--heal"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="wound--id" value="'.$woundId.'"/>'.
                '<input type="hidden" name="wound--heal" value="'.$heal.'"/>'.
                '<input class="sw-c-list__submit'.$h.'" type="image" src="/img/wound-heal.png"/>'.
                '</form>'.
                '</div>'
            :   null;

        $aidButton = $heal == 0
            ?   '<div class="sw-c-list__icon">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="wound--aid"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="wound--id" value="'.$woundId.'"/>'.
                '<input type="hidden" name="wound--aid" value="'.$aid.'"/>'.
                '<input class="sw-c-list__submit'.$a.'" type="image" src="/img/wound-aid.png" alt="Submit" />'.
                '</form>'.
                '</div>'
            :   null;

        echo(
            '<div class="sw-c-list__item">'.
                '<div class="sw-c-list__header">'.
                    '<div class="sw-c-list__icon'.$t.'"><img src="'.$icon.'"/></div>'.
                    '<div class="sw-c-list__title'.$t.'">'.$title.'</div>'.
                    $healButton.
                    $aidButton.
                '</div>'.
            '</div>'
        );
    }


    public function makeList($list) {
        echo('<div class="sw-c-list">');

        if($list) {
            foreach($list as $item) {
                $this->buildList($item->name, $item->description, $item->icon);
            }
        }

        echo('</div>');
    }

    public function makeConsumable($list) {
        echo('<div class="sw-c-button">');

        foreach($list as $consumable) {
            $value = $consumable->value.'d12';

            $data = 'data-roll-type="consumable" data-roll-d12="'.$value.'"';

            $this->buildButton($consumable->name, $consumable->description, $value, $data, $consumable->icon);
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

            $this->buildButton($skill->name, $skill->description, $value, $data, $skill->icon);
        }

        echo('</div>');
    }

    public function makeExpertise() {
        echo('<div class="sw-c-button">');

        $diceList = $this->getExpertise($this->world->expertiseDice);
        $listList = $this->getExpertise($this->world->expertiseAttribute);

        if($diceList) {
            foreach($diceList as $expertise) {
                $rollD12 = 2 + intval($expertise->dice);
                $rollBonus = $expertise->skillValue;

                $value = $rollD12.'d12+'.$rollBonus;

                $data = 'data-roll-type="default" data-roll-d12="'.$rollD12.'" data-roll-bonus="'.$rollBonus.'"';

                $this->buildButton($expertise->name, $expertise->description, $value, $data, $expertise->icon);
            }
        }

        if($listList) {
            foreach($listList as $expertise) {
                $info = $expertise->description;

                if($expertise->level == 1) {
                    $lvl = ' I';
                } else if ($expertise->level == 2) {
                    $lvl = ' II';
                } else if ($expertise->level == 3) {
                    $lvl = ' III';
                } else if ($expertise->level == 4) {
                    $lvl = ' IV';
                }

                $title = $expertise->name . $lvl;

                $this->buildList($title, $info, $expertise->icon);
            }
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

            $this->buildButton($supernatural->name, $supernatural->description, $value, $data, $supernatural->icon);
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

            $this->buildButton($weapon->name, $weapon->description, $value, $data, $weapon->icon);
        }

        echo('</div>');
    }

    public function makeFeatures() {
        echo('<div class="sw-c-list">');

        $this->buildList($this->species->name, $this->species->description, $this->species->icon);

        $this->buildList($this->caste->name, $this->caste->description, $this->caste->icon);

        $this->buildList($this->nature->name, $this->nature->description, $this->nature->icon);

        $this->buildList($this->identity->name, $this->identity->description, $this->identity->icon);

        echo('</div>');
    }

    public function makeSupernaturalInformation() {
        echo('<div class="sw-c-list">');

        $this->buildList($this->manifestation->name, $this->manifestation->description);

        $this->buildList($this->focus->name, $this->focus->description, $this->focus->icon);

        echo('</div>');
    }

    public function makeWound() {
        echo('<div class="sw-c-list">');

        $countLethal = 0;
        $countSerious = 0;

        $lethal = $this->getWound(1);
        $serious = $this->getWound(0);
        $all = $this->getWound();

        $attributes = $this->getAttribute($this->world->attributeWound);

        $this->buildCard($this->getAttribute($this->world->attributeBody));

        if($lethal) {
            foreach($lethal as $object) {
                if($object->heal == 0) {
                    $countLethal++;
                }
            }
        }

        if($serious) {
            foreach($serious as $object) {
                if($object->heal == 0) {
                    $countSerious++;
                }
            }
        }

        if($all) {
            foreach($all as $object) {
                $this->buildWound($object->name, $object->id, $object->icon, $object->heal, $object->aid);
            }
        }

        foreach($attributes as $key => $item) {

        }

        echo('<div class="sw-c-card">');

        foreach($attributes as $object) {

            $count = 0;

            if($object->id == $this->world->woundSerious) {
                $count = $countSerious;
            } else if($object->id == $this->world->woundLethal) {
                $count = $countLethal;
            }

            $color = $count >= $object->value
                ? ' sw-is-invalid'
                : null;

            echo(
                '<div class="sw-c-card__item">'.
                '<div class="sw-c-card__title">'.$object->name.'</div>'.
                '<div class="sw-c-card__value'.$color.'">'.$count.'/'.$object->value.'</div>'.
                '</div>'
            );
        }

        echo('</div>');

        echo('</div>');
    }
}