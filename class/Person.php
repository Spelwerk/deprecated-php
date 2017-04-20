<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-10
 * Time: 09:09
 */

require_once('World.php');

class Person {

    var $id, $secret;

    var $popularity, $thumbsup, $thumbsdown;

    var $nickname, $firstname, $surname, $age, $gender, $occupation,
        $description, $personality, $appearance;

    var $isOwner, $isPlayable, $isCalculated, $isCheater, $isSupernatural;

    var $world, $species, $background, $nature, $identity, $manifestation, $focus;

    public function __construct($id, $secret = null) {
        global $curl;

        $data = $curl->get('person/id/'.$id)['data'][0];

        $this->secret = isset($secret)
            ? $secret
            : null;

        $this->isOwner = isset($secret) && $secret == $data['secret']
            ? true
            : false;

        $this->isPlayable = intval($data['playable']);
        $this->isCalculated = intval($data['calculated']);

        $this->popularity = $data['popularity'];
        $this->thumbsup = $data['thumbsup'];
        $this->thumbsdown = $data['thumbsdown'];

        $this->id = $data['id'];
        $this->nickname = $data['nickname'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];
        $this->occupation = $data['occupation'];
        $this->gender = $data['gender'];
        $this->description = $data['description'];

        $this->world = new World($data['world_id']);

        if($this->isPlayable) {
            $this->isCheater = $data['cheated'];
            $this->isSupernatural = $data['supernatural'];

            $this->age = $data['age'];
            $this->personality = $data['personality'];
            $this->appearance = $data['appearance'];

            $this->species = new Species($data['species_id']);

            $this->species->description = isset($data['species_custom'])
                ? $data['species_custom']
                : $this->species->description;

            $this->background = isset($data['background_id'])
                ? new Background($data['background_id'])
                : null;

            if(isset($data['background_id'])) {
                $this->background = new Background($data['background_id']);

                $this->background->description = isset($data['background_custom'])
                    ? $data['background_custom']
                    : $this->background->description;
            }

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

        if(!$this->isCalculated) {
            $creation = $curl->get('person-creation/id/'.$this->id)['data'][0];

            $this->pointSupernatural = intval($creation['point_supernatural']);
            $this->pointPower= intval($creation['point_power']);
            $this->pointMoney = intval($creation['point_money']);
            $this->pointSkill = intval($creation['point_skill']);
            $this->pointExpertise = intval($creation['point_expertise']);
            $this->pointMilestone = intval($creation['point_milestone']);
            $this->pointGift = intval($creation['point_gift']);
            $this->pointImperfection = intval($creation['point_imperfection']);
            $this->pointRelationship = intval($creation['point_relationship']);
        }

        $this->siteLink = $this->isOwner
            ? '/play/person/id/'.$this->id.'/'.$this->secret
            : '/play/person/id/'.$this->id;
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

    public function getBionic($bodypart = null, $id = null) {
        global $curl;

        $arrayList = null;

        $get = 'person-bionic/id/'.$this->id;

        $get = isset($bodypart)
            ? 'person-bionic/id/'.$this->id.'/bodypart/'.$bodypart
            : $get;

        $get = isset($id)
            ? 'person-bionic/id/'.$this->id.'/bionic/'.$id
            : $get;

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
        /* todo build this
         * bionic
         * characteristic
         * expertise
         * milestone
         * protection
         * weapon
         */
    }

    function buildRemoval($tableName, $tableId, $title, $icon, $returnId = null) {
        global $component, $form;

        $quick = $this->isOwner
            ?   $form->quick([
                    'do' => 'person--'.$tableName.'--delete',
                    'id' => $this->id,
                    'secret' => $this->secret,
                    'return' => 'play/person/id',
                    'returnid' => $returnId,
                    'context' => $tableId,
                    'icon' => 'delete'
                ])
            :   null;

        $component->listAction($title, $quick, ['icon' => $icon]);
    }

    function buildEquip($tableName, $tableId, $title, $icon, $equipped, $returnId = null) {
        global $component, $form;

        $opacity = $equipped == 1
            ? null
            : ' sw-is-opacity';

        $img = $equipped == 1
            ? 'color/switch-true'
            : 'color/switch-false';

        $flip = $equipped == 1
            ? 0
            : 1;

        $quick = $this->isOwner
            ?   $form->quick([
                    'do' => 'person--'.$tableName.'--equip',
                    'id' => $this->id,
                    'secret' => $this->secret,
                    'return' => 'play/person/id',
                    'returnid' => $returnId,
                    'context' => $tableId,
                    'extra' => $flip,
                    'icon' => $img
                ])
            :   null;

        $component->listAction($title, $quick, [
            'icon' => $icon,
            'class' => $opacity
        ]);
    }

    function buildWound($context, $id, $title, $icon, $heal) {
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
            '<input type="hidden" name="post--context2" value="'.$id.'"/>'.
            '<input type="hidden" name="post--extra" value="'.$flipHeal.'"/>'.
            '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
            '<input type="hidden" name="post--secret" value="'.$this->secret.'"/>'.
            '<input class="sw-u-action" type="image" src="/img/color/'.$context.'-heal.png"/>'.
            '</form>'.
            '</div>'.
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

                $this->buildWound('disease', $item->id, $item->name, $item->icon, $item->heal);
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
            foreach($list as $item) {
                $this->buildEquip('protection', $item->id, $item->name, $item->icon, $item->equipped, 'eq_protection');
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

                $this->buildWound('sanity', $item->id, $item->name, $item->icon, $item->heal);
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
            foreach($list as $item) {
                $this->buildEquip('weapon', $item->id, $item->name, $item->icon, $item->equipped, 'eq_weapon');
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

                $this->buildWound('wound', $item->id, $item->name, $item->icon, $item->heal);
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