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
require_once('feature/Species.php');
require_once('feature/Weapon.php');
require_once('feature/Wound.php');

class World {

    public function __construct($id = null, $array = null) {
        global $curl, $user;

        $data = isset($id)
            ? $curl->get('world/id/'.$id,$user->token)['data'][0]
            : $array;

        $this->isOwner = isset($data['owner'])
            ? $data['owner']
            : false;

        $this->isCalculated = $data['calculated'];

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->money = $data['money_attribute_id'];

        $this->popularity = $data['popularity'];
        $this->thumbsup = $data['thumbsup'];
        $this->thumbsdown = $data['thumbsdown'];

        // Hard Coded values for the System // todo add all these to database?
        $this->attributeBody = 1;
        $this->attributeCombat = 2;
        $this->attributeConsumable = 8;
        $this->attributeWound = 3;
        $this->attributeProtection = 4;
        $this->attributeDamage = 5;
        $this->attributeReputation = 6;

        $this->attributeSkill = $data['skill_attributetype_id'];
        $this->expertiseAttribute = $data['attribute_expertisetype_id'];
        $this->expertiseDice = $data['dice_expertisetype_id'];

        $this->existsBionic = $data['bionic'];
        $this->existsAugmentation = $data['augmentation'];
        $this->existsSoftware = $data['software'];
        $this->existsSupernatural = $data['supernatural'];

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

        $this->damage = 4;
        $this->experience = 22;

        $this->tolerance = 1;
        $this->stamina = 2;
        $this->resilience = 3;

        $this->sanity = 7;
        $this->disease = 8;
        $this->trauma = 9;

        $this->siteLink = '/content/world/id/'.$this->id;
    }

    // GET

    public function getAttribute($type = null, $species = null) {
        global $curl;

        $arrayList = null;

        $get = 'world/id/'.$this->id.'/attribute';

        if(isset($type)) {
            $get = isset($species)
                ? 'world/id/'.$this->id.'/attribute/type/'.$type.'/species/'.$species
                : 'world/id/'.$this->id.'/attribute/type/'.$type;
        }

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

        return $system->getAugmentation('bionic/id/'.$bionic.'/augmentation');
    }

    public function getBionic($bodypart = null) {
        global $curl;

        $arrayList = null;

        $get = isset($bodypart)
            ? 'world/id/'.$this->id.'/bionic/bodypart/'.$bodypart
            : 'world/id/'.$this->id.'/bionic';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Bionic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBackground($species = null) {
        global $curl;

        $arrayList = null;

        $get = isset($species)
            ? 'world/id/'.$this->id.'/background/species/'.$species
            : 'world/id/'.$this->id.'/background';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Background(null, $array);
            }
        }

        return $arrayList;
    }

    public function getExpertise($type = null, $skill = null, $species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world/id/'.$this->id.'/expertise';

        if(isset($type) && isset($skill) && isset($species) && isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/expertise/type/'.$type.'/skill/'.$skill.'/species/'.$species.'/manifestation/'.$manifestation;
        }

        if(isset($type) && isset($skill) && isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/expertise/type/'.$type.'/skill/'.$skill.'/species/'.$species;
        }

        if(isset($type) && isset($skill) && !isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/expertise/type/'.$type.'/skill/'.$skill;
        }

        if(isset($type) && !isset($skill) && !isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/expertise/type/'.$type;
        }

        if(!isset($type) && isset($skill) && !isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/expertise/special/skill/'.$type;
        }

        if(!isset($type) && isset($skill) && isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/expertise/special/skill/'.$type.'/species/'.$species;
        }

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

        $override = 'focus/manifestation/'.$manifestation;

        return $system->getFocus($override);
    }

    public function getGift($species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world/id/'.$this->id.'/gift';

        if(isset($species) && isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/gift/species/'.$species.'/manifestation'.$manifestation;
        }

        if(isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/gift/species/'.$species;
        }

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Gift(null, $array);
            }
        }

        return $arrayList;
    }

    public function getImperfection($species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world/id/'.$this->id.'/imperfection';

        if(isset($species) && isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/imperfection/species/'.$species.'/manifestation'.$manifestation;
        }

        if(isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/imperfection/species/'.$species;
        }

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

    public function getMilestone($background = null, $species = null, $manifestation = null) {
        global $curl;

        $arrayList = null;

        $get = 'world/id/'.$this->id.'/milestone';

        if(isset($background) && isset($species) && isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/milestone/background/'.$background.'/species/'.$species.'/manifestation'.$manifestation;
        }

        if(isset($background) && isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/milestone/background/'.$background.'/species/'.$species;
        }

        if(isset($background) && !isset($species) && !isset($manifestation)) {
            $get = 'world/id/'.$this->id.'/milestone/background/'.$background;
        }

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

    public function getProtection($type = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'world/id/'.$this->id.'/protection/type/'.$type
            : 'world/id/'.$this->id.'/protection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Protection(null, $array);
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

    public function getWeapon($group = null) {
        global $curl;

        $arrayList = null;

        $get = isset($group)
            ? 'world/id/'.$this->id.'/weapon/group/'.$group
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
        global $system;
        $this->checkList('background', $system->getBackground(), $system->idList($this->getBackground()));
    }

    public function postBionic() {
        global $system;
        $this->checkList('bionic', $system->getBionic(), $system->idList($this->getBionic()));
    }

    public function postExpertise() {
        global $system, $form, $component;

        $component->h2('Normal Expertises');

        $skillArray = $this->getAttribute($this->attributeSkill);
        $idList = $system->idList($this->getExpertise());

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'expertise',
            'id' => $this->id,
            'context' => 'expertise'
        ]);

        foreach($skillArray as $skill) {
            $override = '/skill/'.$skill->id.'/special';

            $list = $system->getExpertise($override);

            $system->checkboxList($list,$idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postGift() {
        global $system, $form;

        $override = '/special';

        $list = $system->getGift($override);
        $idList = $system->idList($this->getGift());

        $skillArray = $this->getAttribute($this->attributeSkill);

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'gift',
            'id' => $this->id,
            'context' => 'gift'
        ]);

        $system->checkboxList($list, $idList);

        foreach($skillArray as $skill) {
            $override = '/special/skill/'.$skill->id;

            $list = $system->getGift($override);

            $system->checkboxList($list, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postImperfection() {
        global $system;

        $override = '/special';

        $this->checkList('imperfection', $system->getImperfection($override), $system->idList($this->getImperfection()));
    }

    public function postManifestation() {
        global $system;
        $this->checkList('manifestation', $system->getManifestation(), $system->idList($this->getManifestation()));
    }

    public function postMilestone() {
        global $system, $form;

        $override = '/special';

        $list = $system->getMilestone($override);
        $idList = $system->idList($this->getMilestone());

        $backgroundArray = $this->getBackground();

        $form->formStart([
            'do' => 'world--has--add',
            'return' => 'content/world/id',
            'returnafter' => 'milestone',
            'id' => $this->id,
            'context' => 'milestone'
        ]);

        $system->checkboxList($list, $idList);

        if($backgroundArray[0]) {
            foreach($backgroundArray as $background) {
                $override = '/special/background/'.$background->id;

                $list = $system->getMilestone($override);

                $system->checkboxList($list, $idList);
            }
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postProtection() {
        global $system;
        $this->checkList('protection', $system->getProtection(), $system->idList($this->getProtection()));
    }

    public function postSkill() {
        global $system, $form;

        $override = '/type/'.$this->attributeSkill.'/special';

        $list = $system->getAttribute($override);
        $idList = $system->idList($this->getAttribute($this->attributeSkill));

        $form->formStart([
            'do' => 'world--skill',
            'return' => 'content/world/id',
            'returnafter' => 'skill',
            'id' => $this->id,
        ]);

        $system->checkboxList($list, $idList);
        $system->checkboxAll();
        $form->formEnd();
    }

    public function postSpecies() {
        global $system;

        $override = '/playable/1';

        $this->checkList('species', $system->getSpecies($override), $system->idList($this->getSpecies()));
    }

    public function postWeapon() {
        global $system;

        $override = '/special/0';

        $this->checkList('weapon', $system->getWeapon($override), $system->idList($this->getWeapon()));
    }

    // DELETE

    public function deleteBionic() {
        $this->checkList('bionic', $this->getBionic(), null, 'delete');
    }

    public function deleteBackground() {
        $this->checkList('background', $this->getBackground(), null, 'delete');
    }

    public function deleteExpertise() {
        $this->checkList('expertise', $this->getExpertise(), null, 'delete');
    }

    public function deleteGift() {
        $this->checkList('gift', $this->getGift(), null, 'delete');
    }

    public function deleteImperfection() {
        $this->checkList('imperfection', $this->getImperfection(), null, 'delete');
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

        $system->checkboxList($this->getAttribute($this->attributeSkill));
        $system->checkboxAll();

        $form->formEnd();
    }

    public function deleteSpecies() {
        $this->checkList('species', $this->getSpecies(), null, 'delete');
    }

    public function deleteWeapon() {
        $this->checkList('weapon', $this->getWeapon(), null, 'delete');
    }

    // CREATE

    public function create() {

    }

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