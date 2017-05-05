<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */

require_once('feature/Attribute.php');
require_once('feature/Augmentation.php');
require_once('feature/Bionic.php');
require_once('feature/Background.php');
require_once('feature/Disease.php');
require_once('feature/Doctrine.php');
require_once('feature/Expertise.php');
require_once('feature/Focus.php');
require_once('feature/Gift.php');
require_once('feature/Imperfection.php');
require_once('feature/Identity.php');
require_once('feature/Manifestation.php');
require_once('feature/Milestone.php');
require_once('feature/Nature.php');
require_once('feature/Protection.php');
require_once('feature/Sanity.php');
require_once('feature/Skill.php');
require_once('feature/Species.php');
require_once('feature/Weapon.php');
require_once('feature/Wound.php');

class World {

    var $id, $canon, $name, $description;

    var $isOwner, $isCalculated;

    var $popularity, $thumbsup, $thumbsdown;

    var $bodyAttributeType, $combatAttributeType, $consumableAttributeType, $damageAttributeType,
        $protectionAttributeType, $reputationAttributeType, $skillAttributeType, $woundAttributeType;

    var $attributeExpertiseType, $diceExpertiseType;

    var $augmentationExists, $bionicExists, $softwareExists, $supernaturalExists;

    var $splitSupernatural, $splitSkill, $splitExpertise, $splitMilestone, $splitRelationship;

    var $maxGift, $maxImperfection, $maxSupernatural, $maxSkill, $maxExpertise, $maxMilestone, $maxRelationship;

    var $supernaturalName;

    var $damageAttribute, $diseaseAttribute, $experienceAttribute, $moneyAttribute, $resilienceAttribute,
        $sanityAttribute, $staminaAttribute, $toleranceAttribute, $traumaAttribute;

    var $siteLink;


    public function __construct($id = null, $array = null) {
        global $curl, $user;

        $data = isset($id)
            ? $curl->get('world/id/'.$id, $user->token)['data'][0]
            : $array;

        $defaults = $curl->get('system/attribute');

        $this->isOwner = isset($data['owner'])
            ? $data['owner']
            : false;

        $this->isCalculated = $data['calculated'];

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];

        $this->bodyAttributeType = $defaults['type']['body'];
        $this->combatAttributeType = $defaults['type']['combat'];
        $this->consumableAttributeType = $defaults['type']['consumable'];
        $this->damageAttributeType = $defaults['type']['damage'];
        $this->energyAttributeType = $defaults['type']['energy'];
        $this->experienceAttributeType = $defaults['type']['experience'];
        $this->protectionAttributeType = $defaults['type']['protection'];
        $this->powerAttributeType = $defaults['type']['power'];
        $this->reputationAttributeType = $defaults['type']['reputation'];
        $this->woundAttributeType = $defaults['type']['wound'];

        $this->damageAttribute = $defaults['id']['damage'];
        $this->diseaseAttribute = $defaults['id']['disease'];
        $this->experienceAttribute = $defaults['id']['experience'];
        $this->moneyAttribute = $defaults['id']['money'];
        $this->resilienceAttribute = $defaults['id']['resilience'];
        $this->sanityAttribute = $defaults['id']['sanity'];
        $this->staminaAttribute = $defaults['id']['stamina'];
        $this->toleranceAttribute = $defaults['id']['tolerance'];
        $this->traumaAttribute = $defaults['id']['trauma'];

        $this->augmentationExists = $data['augmentation'];
        $this->bionicExists = $data['bionic'];
        $this->softwareExists = $data['software'];
        $this->supernaturalExists = $data['supernatural'];

        $this->splitSupernatural = intval($data['split_supernatural']);
        $this->splitSkill = intval($data['split_skill']);
        $this->splitExpertise = intval($data['split_expertise']);
        $this->splitMilestone = intval($data['split_milestone']);
        $this->splitRelationship = intval($data['split_relationship']);

        $this->maxGift = intval($data['max_gift']);
        $this->maxImperfection = intval($data['max_imperfection']);
        $this->maxSupernatural = intval($data['max_supernatural']);
        $this->maxSkill = intval($data['max_skill']);
        $this->maxExpertise = intval($data['max_expertise']);
        $this->maxMilestone = intval($data['max_milestone']);
        $this->maxRelationship = intval($data['max_relationship']);

        $this->supernaturalName = isset($data['supernatural_name'])
            ? $data['supernatural_name']
            : null;

        $this->siteLink = '/content/world/id/'.$this->id;
    }

    // GET

    public function getAttribute($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/attribute'.$override
            : 'world/id/'.$this->id.'/attribute';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAugmentation($bionic) {
        global $system;

        return $system->getBionic('/id/'.$bionic.'/augmentation');
    }

    public function getBionic($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/bionic'.$override
            : 'world/id/'.$this->id.'/bionic';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Bionic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBackground($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/background'.$override
            : 'world/id/'.$this->id.'/background';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Background(null, $array);
            }
        }

        return $arrayList;
    }

    public function getDoctrine($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/doctrine'.$override
            : 'world/id/'.$this->id.'/doctrine';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Doctrine(null, $array);
            }
        }

        return $arrayList;
    }

    public function getExpertise($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/expertise'.$override
            : 'world/id/'.$this->id.'/expertise';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Expertise(null, $array);
            }
        }

        return $arrayList;
    }

    public function getFocus($manifestation) {
        global $system;

        return $system->getFocus('/manifestation/'.$manifestation);
    }

    public function getGift($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/gift'.$override
            : 'world/id/'.$this->id.'/gift';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Gift(null, $array);
            }
        }

        return $arrayList;
    }

    public function getImperfection($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/imperfection'.$override
            : 'world/id/'.$this->id.'/imperfection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Imperfection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getIdentity() {
        global $system;

        return $system->getIdentity();
    }

    public function getManifestation() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world/id/'.$this->id.'/manifestation');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Manifestation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMilestone($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/milestone'.$override
            : 'world/id/'.$this->id.'/milestone';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Milestone(null, $array);
            }
        }

        return $arrayList;
    }

    public function getNature() {
        global $system;

        return $system->getNature();
    }

    public function getProtection($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/protection'.$override
            : 'world/id/'.$this->id.'/protection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Protection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSkill($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/skill'.$override
            : 'world/id/'.$this->id.'/skill';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Skill(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSpecies() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('world/id/'.$this->id.'/species');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Species(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWeapon($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/weapon'.$override
            : 'world/id/'.$this->id.'/weapon';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Weapon(null, $array);
            }
        }

        return $arrayList;
    }

    // POST

    public function postAttribute() {
        global $component, $form, $curl;

        $component->h1('Attribute Defaults');
        $form->formStart([
            'do' => 'world--attribute',
            'id' => $this->id,
            'return' => 'content/world/id',
            'returnafter' => 'attribute'
        ]);

        $id1 = $curl->get('world/id/'.$this->id.'/attribute/value/1')['data'][0]['default_value'];
        $id2 = $curl->get('world/id/'.$this->id.'/attribute/value/2')['data'][0]['default_value'];
        $id3 = $curl->get('world/id/'.$this->id.'/attribute/value/3')['data'][0]['default_value'];
        $id9 = $curl->get('world/id/'.$this->id.'/attribute/value/9')['data'][0]['default_value'];
        $id8 = $curl->get('world/id/'.$this->id.'/attribute/value/8')['data'][0]['default_value'];
        $id7 = $curl->get('world/id/'.$this->id.'/attribute/value/7')['data'][0]['default_value'];
        $id4 = $curl->get('world/id/'.$this->id.'/attribute/value/4')['data'][0]['default_value'];
        $id5 = $curl->get('world/id/'.$this->id.'/attribute/value/5')['data'][0]['default_value'];
        $id6 = $curl->get('world/id/'.$this->id.'/attribute/value/6')['data'][0]['default_value'];
        $id16 = $curl->get('world/id/'.$this->id.'/attribute/value/16')['data'][0]['default_value'];
        $id17 = $curl->get('world/id/'.$this->id.'/attribute/value/17')['data'][0]['default_value'];
        $id19 = $curl->get('world/id/'.$this->id.'/attribute/value/19')['data'][0]['default_value'];
        $id20 = $curl->get('world/id/'.$this->id.'/attribute/value/20')['data'][0]['default_value'];
        $id21 = $curl->get('world/id/'.$this->id.'/attribute/value/21')['data'][0]['default_value'];

        $component->h2('Wounds');
        $component->subtitle('This section contains the different kinds of wounds a person can take.');
        $component->wrapStart();
        $form->number(true,'attribute','Tolerance','Designates the default value for a person\'s resistance against Trauma attacks.',1,0,96,$id1);
        $form->number(true,'attribute','Stamina','Designates the default value for a person\'s resistance against Diseases and Poison.',2,0,96,$id2);
        $form->number(true,'attribute','Resilience','Designates the default value for a person\'s resistance against falling into madness and losing sanity.',3,0,96,$id3);

        $form->number(true,'attribute','Trauma','Designates the default amount of Trauma wounds a person can handle before being incapacitated.',9,0,96,$id9);
        $form->number(true,'attribute','Disease','Designates the default amount of Diseases a person can handle before being incapacitated.',8,0,96,$id8);
        $form->number(true,'attribute','Sanity','Designates the default amount of Sanity hits a person can handle before being incapacitated.',7,0,96,$id7);
        $component->wrapEnd();

        $component->h2('Combat');
        $component->subtitle('This section contains the three base attributes for combat.');
        $component->wrapStart();
        $form->number(true,'attribute','Damage','Default damage bonus you will get to your attacks.',4,0,96,$id4);
        $form->number(true,'attribute','Initiative','Default value for initiative, which handles a person\'s order of fighting.',5,0,96,$id5);
        $form->number(true,'attribute','Speed','Default value for speed which, which handles a person\'s ability to chase down, or avoid chasers.',6,0,96,$id6);
        $component->wrapEnd();

        $component->h2('Reputation');
        $component->subtitle('This section contains reputation attributes.');
        $component->wrapStart();
        $form->number(true,'attribute','Honor','A person\'s positive reputation.',16,0,96,$id16);
        $form->number(true,'attribute','Infamy','A person\'s negative reputation.',17,0,96,$id17);
        $component->wrapEnd();

        $component->h2('Consumable & Money');
        $component->subtitle('This section contains consumable and financial attributes.');
        $component->wrapStart();
        $form->number(true,'attribute','Money','Default financial situation.',19,0,96,$id19);
        $form->number(true,'attribute','Ammunition','Default ammunition.',20,0,96,$id20);
        $form->number(true,'attribute','Rations','Default daily rations.',21,0,96,$id21);
        $component->wrapEnd();

        $form->formEnd(false);
    }

    public function postBackground() {
        global $system, $form;

        $idList = $system->idList($this->getBackground());

        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'background',
            'id' => $this->id,
            'context' => 'background'
        ]);

        $system->checkboxList($system->getBackground(), $idList);

        foreach($speciesArray as $species) {
            $list = $system->getBackground('/species/'.$species->id, $idList);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($manifestationArray as $manifestation) {
            $list = $system->getBackground('/manifestation/'.$manifestation->id, $idList);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postBionic() {
        global $system;
        $this->checkList('bionic', $system->getBionic(), $system->idList($this->getBionic()));
    }

    public function postExpertise() {
        global $system, $form, $component;

        $idList = $system->idList($this->getExpertise());

        $skillArray = $this->getSkill();
        $manifestationArray = $this->getManifestation();

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'expertise',
            'id' => $this->id,
            'context' => 'expertise'
        ]);

        foreach($skillArray as $skill) {
            $list = $system->getExpertise('/skill/'.$skill->id);

            if(!$list) continue;

            $component->h2($skill->name);
            $system->checkboxList($list, $idList);
        }

        foreach($manifestationArray as $manifestation) {
            $list = $system->getExpertise('/manifestation/'.$manifestation->id);

            if(!$list) continue;

            $component->h2($manifestation->name);
            $system->checkboxList($list, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postGift() {
        global $system, $form, $component;

        $idList = $system->idList($this->getGift());

        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();
        $skillArray = $this->getSkill();

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'gift',
            'id' => $this->id,
            'context' => 'gift'
        ]);

        $system->checkboxList($system->getGift(), $idList);

        foreach($skillArray as $skill) {
            $list = $system->getGift('/skill/'.$skill->id);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($speciesArray as $species) {
            $list = $system->getGift('/species/'.$species->id, $idList);

            if(!$list) continue;

            $component->h2($species->name);
            $system->checkboxList($list, $idList);
        }

        foreach($manifestationArray as $manifestation) {
            $list = $system->getGift('/manifestation/'.$manifestation->id, $idList);

            if(!$list) continue;

            $component->h2($manifestation->name);
            $system->checkboxList($list, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postImperfection() {
        global $system, $form, $component;

        $idList = $system->idList($this->getImperfection());

        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'imperfection',
            'id' => $this->id,
            'context' => 'imperfection'
        ]);

        $system->checkboxList($system->getImperfection(), $idList);

        foreach($speciesArray as $species) {
            $list = $system->getImperfection('/species/'.$species->id, $idList);

            if(!$list) continue;

            $component->h2($species->name);
            $system->checkboxList($list, $idList);
        }

        foreach($manifestationArray as $manifestation) {
            $list = $system->getImperfection('/manifestation/'.$manifestation->id, $idList);

            if(!$list) continue;

            $component->h2($manifestation->name);
            $system->checkboxList($list, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postManifestation() {
        global $system;
        $this->checkList('manifestation', $system->getManifestation(), $system->idList($this->getManifestation()));
    }

    public function postMilestone() {
        global $system, $form, $component;

        $idList = $system->idList($this->getGift());

        $backgroundArray = $this->getBackground();
        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();
        $skillArray = $this->getSkill();

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'milestone',
            'id' => $this->id,
            'context' => 'milestone'
        ]);

        $system->checkboxList($system->getMilestone(), $idList);

        foreach($backgroundArray as $background) {
            $list = $system->getMilestone('/background/'.$background->id);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($skillArray as $skill) {
            $list = $system->getMilestone('/skill/'.$skill->id);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($speciesArray as $species) {
            $list = $system->getMilestone('/species/'.$species->id, $idList);

            if(!$list) continue;

            $component->h2($species->name);
            $system->checkboxList($list, $idList);
        }

        foreach($manifestationArray as $manifestation) {
            $list = $system->getMilestone('/manifestation/'.$manifestation->id, $idList);

            if(!$list) continue;

            $component->h2($manifestation->name);
            $system->checkboxList($list, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postProtection() {
        global $system;
        $this->checkList('protection', $system->getProtection(), $system->idList($this->getProtection()));
    }

    public function postSkill() {
        global $system;

        $this->checkList('skill', $system->getSkill(), $system->idList($this->getSkill()));
    }

    public function postSpecies() {
        global $system;

        $override = '/playable';

        $this->checkList('species', $system->getSpecies($override), $system->idList($this->getSpecies()));
    }

    public function postWeapon() {
        global $system;

        $this->checkList('weapon', $system->getWeapon(), $system->idList($this->getWeapon()));
    }

    // DELETE

    public function deleteBionic() {
        $this->checkList('bionic', $this->getBionic(), null, 'delete');
    }

    public function deleteBackground() {
        $this->checkList('background', $this->getBackground(), null, 'delete');
    }

    public function deleteExpertise() {
        $this->checkList('expertise', $this->getExpertise('/special'), null, 'delete');
    }

    public function deleteGift() {
        $this->checkList('gift', $this->getGift('/special'), null, 'delete');
    }

    public function deleteImperfection() {
        $this->checkList('imperfection', $this->getImperfection('/special'), null, 'delete');
    }

    public function deleteManifestation() {
        $this->checkList('manifestation', $this->getManifestation(), null, 'delete');
    }

    public function deleteMilestone() {
        $this->checkList('milestone', $this->getMilestone(), null, 'milestone');
    }

    public function deleteProtection() {
        $this->checkList('protection', $this->getProtection(), null, 'delete');
    }

    public function deleteSkill() {
        global $form, $system;

        $form->formStart([
            'do' => 'world--has--delete',
            'return' => 'content/world/id',
            'returnafter' => 'skill',
            'id' => $this->id,
            'context' => 'attribute'
        ]);

        $system->checkboxList($this->getAttribute('/type/'.$this->skillAttributeType.'/special'));
        $system->checkboxAll();

        $form->formEnd();
    }

    public function deleteSpecies() {
        $this->checkList('species', $this->getSpecies(), null, 'delete');
    }

    public function deleteWeapon() {
        $this->checkList('weapon', $this->getWeapon(), null, 'delete');
    }

    // VERIFY

    public function create() {
        global $curl, $component, $form;

        if(!$this->isCalculated) {
            $component->h1('Creating '.$this->name);

            $readyToCalculate = true;

            $defaultRoutes = [
                'background' => 'background',
                'expertise' => 'expertise',
                'gift' => 'gift',
                'imperfection' => 'imperfection',
                'milestone' => 'milestone',
                //'protection' => 'protection',
                'weapon' => 'weapon',
            ];

            $sResult = $this->getSpecies();
            $mResult = $this->getManifestation();
            $kResult = $this->getSkill();

            if(!$sResult) {
                $component->linkButton($this->siteLink.'/species/add','Add species',true);
                $readyToCalculate = false;
            } else if($this->supernaturalExists && !$mResult) {
                $component->linkButton($this->siteLink.'/manifestation/add','Add manifestations',true);
                $readyToCalculate = false;
            } else if(!$kResult) {
                $component->linkButton($this->siteLink.'/skill/add','Add skills',true);
                $readyToCalculate = false;
            } else {
                foreach($defaultRoutes as $key => $route) {
                    $result = $curl->get('world/id/'.$this->id.'/'.$route);

                    $empty = false;

                    if(!$result['data']) {
                        $readyToCalculate = false;
                        $empty = true;
                    } else {
                        if(count($result) == 0) {
                            $readyToCalculate = false;
                            $empty = true;
                        }
                    }

                    if($empty) {
                        $component->linkButton($this->siteLink.'/'.$key.'/add','Add '.$key.'s');
                    }
                }

                if($this->bionicExists) {
                    $bResult = $this->getBionic();

                    if(!$bResult) {
                        $component->linkButton($this->siteLink.'/bionic/add','Add bionics');
                        $readyToCalculate = false;
                    }
                }
            }

            if($readyToCalculate) {
                $form->formStart([
                    'do' => 'world--calculated',
                    'id' => $this->id,
                    'return' => 'content/world/id'
                ]);
                $form->formEnd(false,'This world is ready to play. Press here!');
            }
        }
    }

    // PRIVATE

    private function checkList($hasTableName, $list, $idList = null, $do = null) {
        global $form, $system;

        $do = isset($do)
            ? $do
            : 'add';

        $form->formStart([
            'do' => 'world--has--'.$do,
            'return' => 'content/world/id',
            'returnafter' => $hasTableName,
            'id' => $this->id,
            'context' => $hasTableName
        ]);

        $system->checkboxList($list, $idList);
        $system->checkboxAll();

        $form->formEnd();
    }
}