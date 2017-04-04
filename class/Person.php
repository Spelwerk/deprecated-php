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


    function buildEditDescription($id, $title, $description, $icon) {
        //todo build this
    }

    function buildRemoval($id, $title, $icon, $thing, $returnId = null) {
        $change = $this->isOwner
            ?   '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="'.$returnId.'"/>'.
                '<input type="hidden" name="post--do" value="person--remove"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="thing--table" value="'.$thing.'"/>'.
                '<input type="hidden" name="thing--id" value="'.$id.'"/>'.
                '<input class="sw-u-action" type="image" src="/img/remove.png" alt="Submit" />'.
                '</form>'
            :   null;

        echo(
            '<div class="sw-c-list sw-u-even">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '<div class="sw-c-list__action">'.
            $change.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    function buildEquip($id, $title, $icon, $thing, $equipped, $returnId = null) {
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
                '<input class="sw-u-action" type="image" src="'.$i.'" alt="Submit" />'.
                '</form>'
            :   null;

        echo(
            '<div class="sw-c-list sw-u-even'.$e.'">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.'</div>'.
            '<div class="sw-c-list__action">'.
            $change.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    function buildWound($id, $title, $icon, $heal, $aid) {
        $labelAided = $aid == 1
            ? ' (Aided)'
            : null;

        $labelHealed = $heal == 1
            ? ' (Healed)'
            : null;

        $aidedAndHealed = $aid == 1 && $heal == 1
            ? ' sw-is-opacity'
            : null;

        $flipAid = $aid == 1
            ? 0
            : 1;

        $flipHeal = $heal == 1
            ? 0
            : 1;

        $aidButton = $heal == 0
            ?   '<div class="sw-c-list__action">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="person--wound--aid"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="wound--id" value="'.$id.'"/>'.
                '<input type="hidden" name="wound--value" value="'.$flipAid.'"/>'.
                '<input class="sw-u-action" type="image" src="/img/wound-aid.png" alt="Submit" />'.
                '</form>'.
                '</div>'
            :   null;

        $healButton = $aid == 1
            ?   '<div class="sw-c-list__action">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="person--wound--heal"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="wound--id" value="'.$id.'"/>'.
                '<input type="hidden" name="wound--value" value="'.$flipHeal.'"/>'.
                '<input class="sw-u-action" type="image" src="/img/wound-heal.png"/>'.
                '</form>'.
                '</div>'
            :   null;

        echo(
            '<div class="sw-c-list sw-u-even'.$aidedAndHealed.'">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.$labelAided.$labelHealed.'</div>'.
            $aidButton.
            $healButton.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }


    public function makeCard($list) {
        global $component;

        echo('<div class="sw-l-attribute">');

        foreach($list as $object) {
            $component->attribute($object->name, $object->value);
        }

        echo('</div>');
    }

    public function makeList($list) {
        global $component;

        echo('<div class="sw-c-content">');

        if($list) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }
    }

    public function makeButton($list, $type) {
        global $component;

        echo('<div class="sw-l-roll">');

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

            $component->roll($item->name, $item->description, $item->icon, $value, $data);
        }

        echo('</div>');
    }

    public function makeExpertise() {
        global $component;

        $list = $this->getExpertise($this->world->expertiseDice);

        if($list) {
            $component->h2('Expertise');

            echo('<div class="sw-l-roll">');

            foreach($list as $item) {
                $rollD12 = 2 + intval($item->dice);
                $rollBonus = $item->skillValue;

                $value = $rollD12.'d12+'.$rollBonus;

                $data = 'data-roll-type="default" data-roll-d12="'.$rollD12.'" data-roll-bonus="'.$rollBonus.'"';

                $component->roll($item->name, $item->description, $item->icon, $value, $data);
            }

            echo('</div>');
        }
    }

    public function makeExpertiseList() {
        global $component;

        $list = $this->getExpertise($this->world->expertiseAttribute);

        if($list) {
            echo(
                '<h3>Expertise</h3>'.
                '<div class="sw-l-content">'
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

                $component->listItem($title, $info, $expertise->icon);
            }

            echo('</div>');
        }
    }

    public function makeFeatures() {
        global $component;

        echo('<div class="sw-c-content">');

        $characteristicList = $this->getCharacteristic();
        $milestoneList = $this->getMilestone();

        $component->listItem($this->species->name, $this->species->description, $this->species->icon);
        $component->listItem($this->background->name, $this->background->description, $this->background->icon);
        $component->listItem($this->nature->name, $this->nature->description, $this->nature->icon);
        $component->listItem($this->identity->name, $this->identity->description, $this->identity->icon);

        if($characteristicList) {
            foreach($characteristicList as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        if($milestoneList) {
            foreach($milestoneList as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        if($this->isSupernatural) {
            $component->listItem($this->manifestation->name, $this->manifestation->description, $this->manifestation->icon);
            $component->listItem($this->focus->name, $this->focus->description, $this->focus->icon);
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

        $this->makeCard($attributeList);
    }

    public function makeProtectionEquip() {
        echo('<div class="sw-l-content">');

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
            global $component;

            $component->h2($this->manifestation->name);

            echo('<div class="sw-l-roll">');

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

                $component->roll($supernatural->name, $supernatural->description, $supernatural->icon, $value, $data);
            }

            echo('</div>');
        }
    }

    public function makeWeaponEquip() {
        echo('<div class="sw-l-content">');

        $list = $this->getWeapon();

        if(isset($list)) {
            foreach($list as $weapon) {
                $this->buildEquip($weapon->id, $weapon->name, $weapon->icon, 'weapon', $weapon->equipped, 'weapon');
            }
        }

        echo('</div>');
    }

    public function makeWound() {
        global $component;

        echo('<div class="sw-c-list">');

        $countLethal = 0;
        $countSerious = 0;

        $lethal = $this->getWound(1);
        $serious = $this->getWound(0);
        $all = $this->getWound();

        $attributes = $this->getAttribute($this->world->attributeWound);

        if($lethal) {
            foreach($lethal as $item) {
                if($item->heal == 0) {
                    $countLethal++;
                }
            }
        }

        if($serious) {
            foreach($serious as $item) {
                if($item->heal == 0) {
                    $countSerious++;
                }
            }
        }

        if($all) {
            $component->wrapEnd();

            foreach($all as $item) {
                $this->buildWound($item->id, $item->name, $item->icon, $item->heal, $item->aid);
            }

            $component->wrapStart();
        }

        foreach($attributes as $key => $item) {

        }

        echo('<div class="sw-l-attribute">');

        foreach($attributes as $item) {

            $count = 0;

            if($item->id == $this->world->woundSerious) {
                $count = $countSerious;
            } else if($item->id == $this->world->woundLethal) {
                $count = $countLethal;
            }

            $color = $count >= $item->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($item->name, $count.'/'.$item->value);
        }

        echo('</div>');

        echo('</div>');
    }
}