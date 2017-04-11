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
        $this->thumbsup = $data['thumbsup'];
        $this->thumbsdown = $data['thumbsdown'];

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

        $this->siteLink = $this->isOwner
            ? '/play/person/id/'.$this->id.'/'.$this->hash
            : '/play/person/id/'.$this->id;

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

    public function getDisease() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person-disease/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Disease(null, $array);
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

    public function getSanity() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person-sanity/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Sanity(null, $array);
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

    public function getWound() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person-wound/id/'.$this->id);

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

    function buildRemoval($thing, $title, $icon, $context, $returnId = null) {
        global $component, $form;

        $quick = $this->isOwner
            ?   $form->quick('person--delete--has',$this->id,$this->hash,'play/person/id','delete',[
                    'returnid' => $returnId,
                    'context' => $context,
                    'thing' => $thing
                ])
            :   null;

        $component->listAction($title, $quick, ['icon' => $icon]);
    }

    function buildEquip($thing, $title, $icon, $context, $equipped, $returnId = null) {
        global $component, $form;

        $opacity = $equipped == 1
            ? null
            : ' sw-is-opacity';

        $img = $equipped == 1
            ? 'equip-true'
            : 'equip-false';

        $flip = $equipped == 1
            ? 0
            : 1;

        $quick = $this->isOwner
            ?   $form->quick('person--equip',$this->id,$this->hash,'play/person/id',$img,[
                    'returnid' => $returnId,
                    'context' => $context,
                    'thing' => $thing,
                    'extra' => $flip
                ])
            :   null;

        $component->listAction($title, $quick, [
            'icon' => $icon,
            'class' => $opacity
        ]);
    }

    function buildDiseaseSanity($context, $id, $title, $icon, $heal) {
        $labelHealed = $heal == 1
            ? ' (Healed)'
            : null;

        $healed = $heal == 1
            ? ' sw-is-opacity'
            : null;

        $flipHeal = $heal == 1
            ? 0
            : 1;

        echo(
            '<div class="sw-c-list sw-u-even'.$healed.'">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-c-list__icon"><img src="'.$icon.'"/></div>'.
            '<div class="sw-c-list__title">'.$title.$labelHealed.'</div>'.
            '<div class="sw-c-list__action">'.
            '<form action="/post.php" method="post">'.
            '<input type="hidden" name="post--return" value="play/person/id"/>'.
            '<input type="hidden" name="post--returnid" value="'.$context.'"/>'.
            '<input type="hidden" name="post--do" value="person--wound--heal"/>'.
            '<input type="hidden" name="post--context" value="'.$context.'"/>'.
            '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
            '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
            '<input type="hidden" name="item--id" value="'.$id.'"/>'.
            '<input type="hidden" name="item--value" value="'.$flipHeal.'"/>'.
            '<input class="sw-u-action" type="image" src="/img/wound-heal-'.$context.'.png"/>'.
            '</form>'.
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
                '<input type="hidden" name="post--return" value="play/person/id"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="person--wound--aid"/>'.
                '<input type="hidden" name="post--context" value="wound"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="item--id" value="'.$id.'"/>'.
                '<input type="hidden" name="item--value" value="'.$flipAid.'"/>'.
                '<input class="sw-u-action" type="image" src="/img/wound-aid.png"/>'.
                '</form>'.
                '</div>'
            :   null;

        $healButton = $aid == 1
            ?   '<div class="sw-c-list__action">'.
                '<form action="/post.php" method="post">'.
                '<input type="hidden" name="post--return" value="play/person/id"/>'.
                '<input type="hidden" name="post--returnid" value="wound"/>'.
                '<input type="hidden" name="post--do" value="person--wound--heal"/>'.
                '<input type="hidden" name="post--context" value="wound"/>'.
                '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
                '<input type="hidden" name="post--hash" value="'.$this->hash.'"/>'.
                '<input type="hidden" name="item--id" value="'.$id.'"/>'.
                '<input type="hidden" name="item--value" value="'.$flipHeal.'"/>'.
                '<input class="sw-u-action" type="image" src="/img/wound-heal-wound.png"/>'.
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


    public function makeAugmentation() {
        global $component;

        if($this->world->existsAugmentation) {
            $component->h3('Augmentation','eq_augmentation');

            $bionicList = $this->getBionic();

            if($bionicList) {
                foreach($bionicList as $bionic) {
                    $augmentationList = $this->getAugmentation($bionic->id);

                    if($augmentationList) {
                        $component->h4($bionic->name);

                        foreach($augmentationList as $item) {
                            $component->listItem($item->name, $item->description, $item->icon);
                        }
                    }
                }
            }

            if($this->isOwner) {
                $component->link($this->siteLink.'/edit/augmentation','Edit Augmentation');
            }
        }
    }

    public function makeCard($list) {
        global $component;

        echo('<div class="sw-u-center">');

        foreach($list as $object) {
            $component->attribute($object->name, $object->value);
        }

        echo('</div>');
    }

    public function makeList($list) {
        global $component;

        if($list) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }
    }

    public function makeButton($list, $type) {
        global $component;

        $component->wrapStart(true);

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
                    break;

            }

            $component->roll($item->name, $item->description, $item->icon, $value, $data);
        }

        $component->wrapEnd();
    }

    public function makeDisease() {
        global $component;

        $itemCount = 0;
        $itemList = $this->getDisease();
        $itemAttribute = $this->getAttribute(null,$this->world->disease)[0];

        $stamina = $this->getAttribute(null,$this->world->stamina);
        $this->makeCard($stamina);

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if($item->heal == 0) {
                    $itemCount = $itemCount + $item->value;
                }

                $this->buildDiseaseSanity('disease', $item->id, $item->name, $item->icon, $item->heal);
            }
        }

        if($itemCount != 0) {
            echo('<div class="sw-u-center">');

            $color = $itemCount >= $itemAttribute->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($itemAttribute->name, $itemCount.'/'.$itemAttribute->value,$color);

            echo('</div>');
        }
    }

    public function makeExpertise() {
        global $component;

        $list = $this->getExpertise($this->world->expertiseDice);

        if($list) {
            $component->h2('Expertise');
            $component->wrapStart(true);

            foreach($list as $item) {
                $rollD12 = 2 + intval($item->dice);
                $rollBonus = $item->skillValue;

                $value = $rollD12.'d12+'.$rollBonus;

                $data = 'data-roll-type="default" data-roll-d12="'.$rollD12.'" data-roll-bonus="'.$rollBonus.'"';

                $component->roll($item->name, $item->description, $item->icon, $value, $data);
            }

            $component->wrapEnd();
        }
    }

    public function makeExpertiseList() {
        global $component;

        $list = $this->getExpertise($this->world->expertiseAttribute);

        if($list) {
            echo(
                '<h3>Expertise</h3>'.
                '<div class="sw-l-padding">'
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
        $tolerance = $this->getAttribute(null,$this->world->tolerance)[0];

        foreach($attributeList as $attribute) {
            $attribute->value = intval($attribute->value) + intval($tolerance->value);

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
        $list = $this->getProtection();

        if(isset($list)) {
            foreach($list as $protection) {
                $this->buildEquip($protection->id, $protection->name, $protection->icon, 'protection', $protection->equipped, 'eq_protection');
            }
        }
    }

    public function makeSanity() {
        global $component;

        $itemCount = 0;
        $itemList = $this->getSanity();
        $itemAttribute = $this->getAttribute(null,$this->world->sanity)[0];

        $resilience = $this->getAttribute(null,$this->world->resilience);
        $this->makeCard($resilience);

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if($item->heal == 0) {
                    $itemCount = $itemCount + $item->value;
                }

                $this->buildDiseaseSanity('sanity', $item->id, $item->name, $item->icon, $item->heal);
            }
        }

        if($itemCount != 0) {
            echo('<div class="sw-u-center">');

            $color = $itemCount >= $itemAttribute->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($itemAttribute->name, $itemCount.'/'.$itemAttribute->value,$color);

            echo('</div>');
        }
    }

    public function makeSupernatural() {
        if($this->isSupernatural) {
            global $component;

            $component->h2($this->manifestation->name);
            $component->wrapStart(true);

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

            $component->wrapEnd();
        }
    }

    public function makeWeaponEquip() {
        $list = $this->getWeapon();

        if(isset($list)) {
            foreach($list as $weapon) {
                $this->buildEquip($weapon->id, $weapon->name, $weapon->icon, 'weapon', $weapon->equipped, 'eq_weapon');
            }
        }
    }

    public function makeWound() {
        global $component;

        $itemCount = 0;
        $itemList = $this->getWound();
        $itemAttribute = $this->getAttribute(null,$this->world->trauma)[0];

        $this->makeProtection();

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if($item->heal == 0) {
                    $itemCount = $itemCount + $item->value;
                }

                $this->buildWound($item->id, $item->name, $item->icon, $item->heal, $item->aid);
            }
        }

        if($itemCount != 0) {
            echo('<div class="sw-u-center">');

            $color = $itemCount >= $itemAttribute->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($itemAttribute->name, $itemCount.'/'.$itemAttribute->value,$color);

            echo('</div>');
        }
    }
}