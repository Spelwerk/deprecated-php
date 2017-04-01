<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-10
 * Time: 09:09
 */

require_once('World.php');

class Person {

    var $id, $hash, $popularity, $nickname, $firstname, $surname, $age, $gender, $occupation,
        $description, $personality;

    var $isTemplate, $isCheater, $isSupernatural, $isOwner, $isCalculated;

    var $pointSupernatural, $pointPotential, $pointMoney, $pointSkill, $pointExpertise, $pointMilestone,
        $pointGift, $pointImperfection, $pointRelationship;

    var $world, $species, $background, $nature, $identity, $manifestation, $focus;

    public function __construct($id = null, $hash = null) {
        global $curl;

        $data = $curl->get('person/id/'.$id)['data'][0];

        $this->hash = isset($hash)
            ? $hash
            : null;

        $this->isOwner = isset($hash) && $hash == $data['hash']
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
        $this->pointMilestone = intval($data['point_milestone']);
        $this->pointGift = intval($data['point_characteristic_gift']);
        $this->pointImperfection = intval($data['point_characteristic_imperfection']);
        $this->pointRelationship = intval($data['point_relationship']);

        $this->world = isset($data['world_id'])
            ? new World($data['world_id'])
            : null;

        $this->species = isset($data['species_id'])
            ? new Species($data['species_id'])
            : null;

        $this->background = isset($data['background_id'])
            ? new Background($data['background_id'])
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


    public function getAttribute($type = null, $id = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'person-attribute/id/'.$this->id.'/type/'.$type
            : 'person-attribute/id/'.$this->id.'/attribute/'.$id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAugmentation($bionic = null) {
        global $curl;

        $arrayList = null;

        $get = isset($bionic)
            ? 'person-augmentation/id/'.$this->id.'/bionic/'.$bionic
            : 'person-augmentation/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Augmentation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBionic($bodypart = null) {
        global $curl;

        $arrayList = null;

        $get = isset($bodypart)
            ? 'person-bionic/id/'.$this->id.'/bodypart/'.$bodypart
            : 'person-bionic/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Bionic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getCharacteristic($gift = null) {
        global $curl;

        $arrayList = null;

        $get = isset($gift)
            ? 'person-characteristic/id/'.$this->id.'/gift/'.$gift
            : 'person-characteristic/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Characteristic(null, $array);
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

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Expertise(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMilestone() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person-milestone/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Milestone(null, $array);
            }
        }

        return $arrayList;
    }

    public function getProtection($equipped = null) {
        global $curl;

        $arrayList = null;

        $get = isset($equipped)
            ? 'person-protection/id/'.$this->id.'/equipped/'.$equipped
            : 'person-protection/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Protection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWeapon($equipped = null) {
        global $curl;

        $arrayList = null;

        $get = isset($equipped)
            ? 'person-weapon/id/'.$this->id.'/equipped/'.$equipped
            : 'person-weapon/id/'.$this->id;

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
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

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Wound(null, $array);
            }
        }

        return $arrayList;
    }


    function buildButton($title, $description, $value, $data, $icon = null) {
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

    function buildList($title, $description, $icon = null) {
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

    function buildEditDescription($id, $name, $description, $icon, $thing) {

        //todo not finished yet
        echo(
            '<div class="sw-c-list__item">'.
            '<div class="sw-c-list__header">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$name.'</div>'.
            '</div>'.
            '<form action="/post.php" method="post">'.
            '<input type="hidden" name="post--return" value="play"/>'.
            '<input type="hidden" name="post--do" value="person--edit--description"/>'.
            '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
            '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
            '<input type="hidden" name="thing--table" value="'.$thing.'"/>'.
            '<input type="hidden" name="thing--id" value="'.$id.'"/>'.
            '<div class="sw-c-list__description">'.
            '<textarea class="sw-c-input__item sw-js-validation" name="item--description" id="item--description" rows="3">'.$description.'</textarea>'.
            '<input class="sw-c-list__submit" type="submit" value="Edit" />'.
            '</div>'.
            '</form>'.
            '</div>'
        );
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

    function buildEquip($id, $name, $icon, $thing, $equipped, $returnId = null) {
        $e = $equipped == 1
            ? ''
            : ' sw-is-opacity';

        $i = $equipped == 1
            ? '/img/equip-true.png'
            : '/img/equip-false.png';

        $flip = $equipped == 1
            ? 0
            : 1;

        $change = $this->isOwner
            ?   '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="'.$returnId.'"/>'.
                '<input type="hidden" name="post--do" value="person--equip"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="thing--table" value="'.$thing.'"/>'.
                '<input type="hidden" name="thing--id" value="'.$id.'"/>'.
                '<input type="hidden" name="thing--value" value="'.$flip.'"/>'.
                '<input class="sw-c-list__submit" type="image" src="'.$i.'" alt="Submit" />'.
                '</form>'
            :   null;

        echo(
            '<div class="sw-c-list__item'.$e.'">'.
            '<div class="sw-c-list__header">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$name.'</div>'.
            '<div class="sw-c-list__icon">'.
            $change.
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

        $flipAid = $aid == 1
            ? 0
            : 1;

        $flipHeal = $heal == 1
            ? 0
            : 1;

        $aidButton = $heal == 0
            ?   '<div class="sw-c-list__icon">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="person--wound--aid"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="wound--id" value="'.$woundId.'"/>'.
                '<input type="hidden" name="wound--value" value="'.$flipAid.'"/>'.
                '<input class="sw-c-list__submit'.$a.'" type="image" src="/img/wound-aid.png" alt="Submit" />'.
                '</form>'.
                '</div>'
            :   null;

        $healButton = $aid == 1
            ?   '<div class="sw-c-list__icon">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="person--wound--heal"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="wound--id" value="'.$woundId.'"/>'.
                '<input type="hidden" name="wound--value" value="'.$flipHeal.'"/>'.
                '<input class="sw-c-list__submit'.$h.'" type="image" src="/img/wound-heal.png"/>'.
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


    public function makeCard($list, $modifier = null) {
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

    public function makeList($list) {
        echo('<div class="sw-c-list">');

        if($list) {
            foreach($list as $item) {
                $this->buildList($item->name, $item->description, $item->icon);
            }
        }

        echo('</div>');
    }

    public function makeButton($list, $type) {
        echo('<div class="sw-c-button">');

        foreach($list as $item) {

            $value = null;
            $data = null;

            switch($type)
            {
                case 'consumable':
                    $value = $item->value.'d12';
                    $data = 'data-roll-type="consumable" 
                             data-roll-d12="'.$item->value.'"';
                    break;

                case 'skill':
                    $value = $item->value > 0
                        ? '2d12+'.$item->value
                        : '2d12';
                    $data = 'data-roll-type="default" 
                             data-roll-d12="2" 
                             data-roll-bonus="'.$item->value.'"';
                    break;

                case 'weapon':
                    $hitD12 = 2 + intval($item->expertiseLevel);
                    $hitBonus = intval($item->damageBonus) + intval($item->hit);
                    $value = isset($item->damageBonus)
                        ? $item->damageD12.'d12+'.$item->damageBonus
                        : $item->damageD12.'d12';
                    $data = 'data-roll-type="weapon" 
                             data-roll-d12="'.$hitD12.'" 
                             data-roll-bonus="'.$hitBonus.'" 
                             data-strike-d12="'.$item->damageD12.'" 
                             data-strike-bonus="'.$item->damageBonus.'" 
                             data-strike-critical="'.$item->criticalD12.'"';

            }

            $this->buildButton($item->name, $item->description, $value, $data, $item->icon);
        }

        echo('</div>');
    }

    public function makeExpertise() {
        $list = $this->getExpertise($this->world->expertiseDice);

        if($list) {
            echo(
                '<h2>Expertise</h2>'.
                '<div class="sw-c-button">'
            );

            foreach($list as $expertise) {
                $rollD12 = 2 + intval($expertise->dice);
                $rollBonus = $expertise->skillValue;

                $value = $rollD12.'d12+'.$rollBonus;

                $data = 'data-roll-type="default" data-roll-d12="'.$rollD12.'" data-roll-bonus="'.$rollBonus.'"';

                $this->buildButton($expertise->name, $expertise->description, $value, $data, $expertise->icon);
            }

            echo('</div>');
        }
    }

    public function makeExpertiseList() {
        $list = $this->getExpertise($this->world->expertiseAttribute);

        if($list) {
            echo(
                '<h3>Expertise</h3>'.
                '<div class="sw-c-list">'
            );

            foreach($list as $expertise) {
                $info = $expertise->description;

                $lvl = null;

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

            echo('</div>');
        }
    }

    public function makeFeatures() {
        echo('<div class="sw-c-list">');

        $characteristicList = $this->getCharacteristic();
        $milestoneList = $this->getMilestone();

        $this->buildList($this->species->name, $this->species->description, $this->species->icon);

        $this->buildList($this->background->name, $this->background->description, $this->background->icon);

        $this->buildList($this->nature->name, $this->nature->description, $this->nature->icon);

        $this->buildList($this->identity->name, $this->identity->description, $this->identity->icon);

        if($characteristicList) {
            foreach($characteristicList as $item) {
                $this->buildList($item->name, $item->description, $item->icon);
            }
        }

        if($milestoneList) {
            foreach($milestoneList as $item) {
                $this->buildList($item->name, $item->description, $item->icon);
            }
        }

        if($this->isSupernatural) {
            $this->buildList($this->manifestation->name, $this->manifestation->description);

            $this->buildList($this->focus->name, $this->focus->description, $this->focus->icon);
        }

        echo('</div>');
    }

    public function makeProtection() {
        $equippedList = $this->getProtection(1);
        $attributeList = $this->getAttribute($this->world->attributeProtection);
        $toleranceList = $this->getAttribute($this->world->attributeBody);

        $tolerance = 0;

        foreach($toleranceList as $attr) {
            if($attr->id == $this->world->tolerance) {
                $tolerance = $attr->value;
            }
        }

        foreach($attributeList as $attribute) {
            $attribute->value = intval($attribute->value) + intval($tolerance);

            if($equippedList) {
                foreach($equippedList as $protection) {
                    if($protection->attributeId == $attribute->id) {
                        $attribute->value = intval($attribute->value) + intval($protection->attributeValue);
                    }
                }
            }
        }

        $this->makeCard($attributeList, '--small');
    }

    public function makeProtectionEquip() {
        echo('<div class="sw-c-list">');

        $list = $this->getProtection();

        if(isset($list)) {
            foreach($list as $protection) {
                $this->buildEquip($protection->id, $protection->name, $protection->icon, 'protection', $protection->equipped, 'protection');
            }
        }

        echo('</div>');
    }

    public function makeSupernatural() {
        if($this->isSupernatural) {
            echo(
                '<h2>'.$this->manifestation->name.'</h2>'.
                '<div class="sw-c-button">'
            );

            foreach($this->getAttribute($this->manifestation->disciplineAttributeType) as $supernatural) {
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
    }

    public function makeWeaponEquip() {
        echo('<div class="sw-c-list">');

        $list = $this->getWeapon();

        if(isset($list)) {
            foreach($list as $weapon) {
                $this->buildEquip($weapon->id, $weapon->name, $weapon->icon, 'weapon', $weapon->equipped, 'weapon');
            }
        }

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