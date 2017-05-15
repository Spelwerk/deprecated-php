<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */

require_once('World.php');

class Person {

    var $id, $secret, $nickname, $description,
        $firstname, $surname, $occupation, $gender, $age, $personality, $appearance,
        $drive, $pride, $problem;

    var $isOwner, $isPlayable, $isCalculated, $isCheater, $isSupernatural;

    var $popularity, $thumbsup, $thumbsdown;

    var $background, $focus, $identity, $manifestation, $nature, $species, $world;

    var $pointExpertise, $pointGift, $pointImperfection, $pointMilestone, $pointMoney, $pointPowe, $pointRelationship,
        $pointSkill, $pointSupernatural;

    var $siteLink;


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
        $this->description = $data['description'];
        $this->firstname = $data['firstname'];
        $this->surname = $data['surname'];
        $this->occupation = $data['occupation'];
        $this->gender = $data['gender'];
        $this->drive = $data['drive'];
        $this->pride = $data['pride'];
        $this->problem = $data['problem'];

        $this->world = new World($data['world_id']);

        if($this->isPlayable) {
            $this->isCheater = $data['cheated'];
            $this->isSupernatural = $data['supernatural'];

            $this->age = $data['age'];
            $this->personality = $data['personality'];
            $this->appearance = $data['appearance'];

            $this->background = isset($data['background_id'])
                ? new Background($data['background_id'])
                : null;

            $this->focus = isset($data['focus_id'])
                ? new Focus($data['focus_id'])
                : null;

            $this->identity = isset($data['identity_id'])
                ? new Identity($data['identity_id'])
                : null;

            $this->manifestation = isset($data['manifestation_id'])
                ? new Manifestation($data['manifestation_id'])
                : null;

            $this->nature = isset($data['nature_id'])
                ? new Nature($data['nature_id'])
                : null;

            $this->species = isset($data['species_id'])
                ? new Species($data['species_id'])
                : null;

            $this->pointExpertise = intval($data['point_expertise']);
            $this->pointGift = intval($data['point_gift']);
            $this->pointImperfection = intval($data['point_imperfection']);
            $this->pointMilestone = intval($data['point_milestone']);
            $this->pointMoney = intval($data['point_money']);
            $this->pointPower= intval($data['point_power']);
            $this->pointRelationship = intval($data['point_relationship']);
            $this->pointSkill = intval($data['point_skill']);
            $this->pointSupernatural = intval($data['point_supernatural']);
        }

        $this->siteLink = $this->isOwner
            ? '/play/person/id/'.$this->id.'/'.$this->secret
            : '/play/person/id/'.$this->id;
    }

    // GET

    public function getAttribute($type = null, $id = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'person/id/'.$this->id.'/attribute/type/'.$type
            : 'person/id/'.$this->id.'/attribute/id/'.$id;

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
            ? 'person/id/'.$this->id.'/augmentation/bionic/'.$bionic
            : 'person/id/'.$this->id.'/augmentation';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Augmentation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBionic($id = null) {
        global $curl;

        $arrayList = null;

        $get = isset($id)
            ? 'person/id/'.$this->id.'/bionic/id/'.$id
            : 'person/id/'.$this->id.'/bionic';

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

        $result = $curl->get('person/id/'.$this->id.'/disease');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Disease(null, $array);
            }
        }

        return $arrayList;
    }

    public function getExpertise($type = null) {
        global $curl;

        $arrayList = null;

        $get = isset($type)
            ? 'person/id/'.$this->id.'/expertise/type/'.$type
            : 'person/id/'.$this->id.'/expertise';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Expertise(null, $array);
            }
        }

        return $arrayList;
    }

    public function getGift() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person/id/'.$this->id.'/gift');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Gift(null, $array);
            }
        }

        return $arrayList;
    }

    public function getImperfection() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person/id/'.$this->id.'/imperfection');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Imperfection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMilestone() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person/id/'.$this->id.'/milestone');

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
            ? 'person/id/'.$this->id.'/protection/equipped/'.$equipped
            : 'person/id/'.$this->id.'/protection';

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

        $result = $curl->get('person/id/'.$this->id.'/sanity');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Sanity(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSoftware() {} // todo

    public function getWeapon($equipped = null) {
        global $curl;

        $arrayList = null;

        $get = isset($equipped)
            ? 'person/id/'.$this->id.'/weapon/equipped/'.$equipped
            : 'person/id/'.$this->id.'/weapon';

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

        $result = $curl->get('person/id/'.$this->id.'/wound');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Wound(null, $array);
            }
        }

        return $arrayList;
    }

    // POST

    public function postAttribute($attributeId) {

    }

    public function postAugmentation($bionicId) {
        global $system, $form, $component;

        $bionic = $this->getBionic($bionicId)[0];
        $augmentationList = $this->world->getAugmentation($bionicId);
        $idList = $system->idList($this->getAugmentation());

        $component->h2($bionic->name);

        $form->formStart([
            'do' => 'person--augmentation',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id',
            'context' => $bionicId
        ]);

        $system->checkboxList($augmentationList, $idList);
        $system->checkboxAll();
        $form->formEnd();
    }

    public function postBackground() {
        global $component;

        $component->linkAction('#','Bookmark this Person','The framework for your character has been created in our database. Time to bookmark so you can return whenever you want!','/img/link-bookmark-w.png',true,'sw-js-bookmark');

        $component->h1('Background');
        $component->subtitle('You will select <span>1</span> background from which you will gain a few attribute and skill changes.');

        $this->radioList('background_id', $this->world->getBackground('/species/'.$this->species->id), [
            'do' => 'background',
            'roll' => 'Background'
        ]);
    }

    public function postBionic() {
        global $system, $form;

        $bionicList = $this->world->getBionic();
        $idList = $system->idList($this->getBionic());

        $form->formStart([
            'do' => 'person--bionic',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        $system->checkboxList($bionicList, $idList);

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postDescription() {
        global $form, $component;

        $component->h1('Name & Details');

        $component->wrapStart();
        $form->formStart([
            'do' => 'person--describe',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);
        $form->varchar(true, 'firstname', 'First Name');
        $form->varchar(true, 'surname', 'Surname');
        $form->varchar(true, 'drive', 'Drive', 'What drives your character forward?');
        $form->varchar(true, 'pride', 'Pride', 'What is the thing your character is most proud of?');
        $form->varchar(true, 'problem', 'Problem', 'What kind of problem does your character fight with?');
        $form->varchar(true, 'gender', 'Gender');
        $form->text(false, 'description', 'Description', 'Describe your character.');
        $form->text(false, 'personality', 'Personality', 'Describe your character\'s personality. Behaviour, Mannerisms, etc.');
        $form->text(false, 'appearance', 'Appearance', 'Describe your character\'s appearance.');
        $form->formEnd();
        $component->wrapEnd();
    }

    public function postDoctrine($cheat = false) {
        global $component, $curl, $form;

        $component->h1($this->manifestation->name);

        $exp = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $pts = $this->pointSupernatural;

        $points = intval($exp->value + $pts);

        $override = '/type/'.$this->manifestation->disciplineAttributeType.'/species/'.$this->species->id;

        $supernaturalList = $this->world->getAttribute($override);
        $expertiseList = $this->getExpertise();
        $currentList = $this->getAttribute($this->manifestation->disciplineAttributeType);
        $idList = [];
        $expList = [];

        $personPower = $curl->get('person/id/'.$this->id.'/attribute/id/'.$this->manifestation->powerAttribute)['data'][0]['value'];

        $form->formStart([
            'do' => 'person--manifestation--doctrine',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($points);
            $form->hidden('experience', $this->world->experienceAttribute, 'post');
        }

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $maximum = $personPower > $current->maximum
                    ? $current->maximum
                    : $personPower;

                $form->purchase('attribute_id', $current->name, $current->description, $current->icon, $current->id, 0, $maximum, $current->value);
            }
        }

        foreach($expertiseList as $expertise) {
            $expList[] = $expertise->attribute['id'];
        }

        foreach($supernaturalList as $supernatural) {
            if(in_array($supernatural->id, $expList) && !in_array($supernatural->id, $idList)) {

                $maximum = $personPower > $supernatural->maximum
                    ? $current->maximum
                    : $personPower;

                $form->purchase('attribute_id', $supernatural->name, $supernatural->description, $supernatural->id, 0, $maximum);
            }
        }

        $form->formEnd();
    }

    public function postDoctrineRadio() {
        global $component;

        $component->h1('Doctrine');

        $override = '/type/'.$this->manifestation->expertiseType;

        $this->radioList('expertise_id', $this->world->getExpertise($override), [
            'do' => 'manifestation--expertise'
        ]);
    }

    public function postExpertise($cheat = false) {
        global $component, $form, $curl;

        $component->h1('Expertise');

        $exp = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $pts = $this->pointExpertise;

        $points = intval($exp->value + $pts);

        $typeList = $curl->get('expertisetype')['data'];
        $skillList = $this->getAttribute($this->world->skillAttributeType);
        $currentList = $this->getExpertise();
        $idList = [];

        $form->formStart([
            'do' => 'person--expertise',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($points);
            $form->hidden('experience', $this->world->experienceAttribute, 'post');
        }

        if(count($currentList) != null) {
            foreach($currentList as $current) {
                $idList[] = $current->id;

                $skillVal = 0;

                foreach($skillList as $skill) {
                    if($skill->id == $current->skill['id']) {
                        $skillVal = $skill->value;
                    }
                }

                $math1 = $skillVal - $current->skill['required'];
                $math2 = floor($math1 / $current->skill['increment']);

                $calculatedMax = $current->maximum < $math2
                    ? $current->maximum
                    : $math2 + 1;

                if($calculatedMax != 0) {
                    $form->purchase('expertise_id', $current->name, $current->description, $current->icon, $current->id, 0, $calculatedMax, $current->level);
                }
            }
        }

        foreach($typeList as $type) {
            foreach($skillList as $skill) {
                if($skill->value >= $type['skill_attribute_required']) {

                    $override = '/type/'.$type['id'].'/skill/'.$skill->id.'/species/'.$this->species->id;

                    $expertiseList = $this->world->getExpertise($override);

                    $math1 = $skill->value - $type['skill_attribute_required'];
                    $math2 = floor($math1 / $type['skill_attribute_increment']);

                    if(isset($expertiseList)) {
                        foreach($expertiseList as $expertise) {
                            if(!in_array($expertise->id, $idList)) {
                                $calculatedMax = $expertise->maximum < $math2
                                    ? $expertise->maximum
                                    : $math2 + 1;

                                $form->purchase('expertise_id', $expertise->name, $expertise->description, $expertise->icon, $expertise->id, 0, $calculatedMax);
                            }
                        }
                    }
                }
            }
        }

        $form->formEnd();
    }

    public function postFocus() {
        global $component;

        $component->h1('Focus');

        $this->radioList('focus_id', $this->world->getFocus($this->manifestation->id), [
            'do' => 'focus'
        ]);
    }

    public function postGift($cheat = false) {
        global $component, $system, $form;

        $component->h1('Gift');
        $component->subtitle('Get <span>'.$this->pointGift.'</span> gift that sets your character aside from others.');

        $list = null;

        if($this->isSupernatural) {
            $override = '/species/'.$this->species->id.'/manifestation/'.$this->manifestation->id;
        } else {
            $override = '/species/'.$this->species->id;
        }

        $list = $this->world->getGift($override);

        $idList = $system->idList($this->getGift());

        $form->formStart([
            'do' => 'person--gift',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($this->pointGift);
        }

        $form->randomRadio('Gift');
        $form->viewStart();
        $system->radioList('gift_id',$list, $idList);
        $form->viewEnd();
        $form->formEnd();
    }

    public function postIdentity() {
        global $component;

        $component->h1('Identity');

        $this->radioList('identity_id', $this->world->getIdentity(), [
            'do' => 'identity'
        ]);
    }

    public function postImperfection($cheat = false) {
        global $component, $system, $form;

        $component->h1('Imperfection');
        $component->subtitle('Get <span>'.$this->pointImperfection.'</span> imperfection that sets your character aside from others.');

        $list = null;

        if($this->isSupernatural) {
            $override = '/species/'.$this->species->id.'/manifestation/'.$this->manifestation->id;
        } else {
            $override = '/species/'.$this->species->id;
        }

        $list = $this->world->getImperfection($override);

        $idList = $system->idList($this->getImperfection());

        $form->formStart([
            'do' => 'person--imperfection',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($this->pointImperfection);
        }

        $form->randomRadio('Imperfection');
        $form->viewStart();
        $system->radioList('imperfection_id',$list, $idList);
        $form->viewEnd();
        $form->formEnd();
    }

    public function postManifestation() {
        global $component;

        $component->h1('Manifestation');

        $this->radioList('manifestation_id', $this->world->getManifestation(), [
            'do' => 'manifestation'
        ]);
    }

    public function postMilestone($points = null) {
        global $component, $system, $form;

        $component->h1('Milestone');
        $component->subtitle('Get <span>'.$this->pointMilestone.'</span> milestones that have happened to your character.');

        $list = null;
        $override = null;

        $points = isset($points)
            ? $points
            : $this->pointMilestone;

        if($this->isSupernatural) {
            $override = '/background/'.$this->background->id.'/species/'.$this->species->id.'/manifestation/'.$this->manifestation->id;
        } else {
            $override = '/background/'.$this->background->id.'/species/'.$this->species->id;
        }

        $list = $this->world->getMilestone($override);
        $idList = $system->idList($this->getMilestone());

        $form->formStart([
            'do' => 'person--milestone',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        $form->points($points);
        $form->randomRadio('milestone');
        $form->viewStart();
        $system->radioList('milestone_id',$list, $idList);
        $form->viewEnd();
        $form->formEnd();
    }

    public function postMoney() {
        global $component;

        $component->h1('Money');
        $component->subtitle('You will be rolling <span class="sw-js-points-text">'.$this->pointMoney.'</span> dice to either improve or impair your financial status.');

        $this->rollAttribute('attribute--money', $this->world->moneyAttribute, $this->pointMoney);
    }

    public function postNature() {
        global $component;

        $component->h1('Nature');

        $this->radioList('nature_id', $this->world->getNature(), [
            'do' => 'nature'
        ]);
    }

    public function postPotential() {
        global $component;

        $component->h1('Potential');

        $this->rollAttribute('manifestation--power', $this->manifestation->powerAttribute, $this->pointPower);
    }

    public function postProtection() {
        global $system, $form, $curl, $component;

        $typeList = $curl->get('protectiontype')['data'];
        $idList = $this->idList($this->getProtection());

        $form->formStart([
            'do' => 'person--protection',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        foreach($typeList as $type) {
            $protectionList = $this->world->getProtection('/type/'.$type['id']);

            $component->h4($type['name']);
            $system->checkboxList($protectionList, $idList);
        }

        $system->checkboxAll();
        $form->formEnd();
    }

    public function postSkill($cheat = false) {
        global $component, $form;

        $exp = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $pts = $this->pointSkill;

        $points = intval($exp->value + $pts);

        $component->h1('Skill');
        $component->subtitle('You will be using <span>'.$this->pointSkill.'</span> points to purchase Skills. Try to get at least 1 above 4, and a couple above 2.');

        $currentList = $this->getAttribute($this->world->skillAttributeType);

        $form->formStart([
            'do' => 'person--skill',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($points);
            $form->hidden('experience', $this->world->experienceAttribute, 'post');
        }

        foreach($currentList as $current) {
            $form->purchase('attribute_id', $current->name, $current->description, $current->icon, $current->id, 0, $current->maximum, $current->value);
        }

        $form->formEnd();
    }

    public function postSoftware() {

    }

    public function postWeapon() {
        global $system, $form;

        $idList = $system->idList($this->getWeapon());
        $weaponList = $this->world->getWeapon();

        $form->formStart([
            'do' => 'person--weapon',
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        $system->checkboxList($weaponList, $idList);
        $system->checkboxAll();
        $form->formEnd(false);
    }

    // CREATE

    public function create() {
        global $component;

        $component->title($this->nickname);

        echo($this->isSupernatural);

        if(!isset($this->background)) {
            $this->postBackground();
        } else if($this->isSupernatural && !isset($this->manifestation)) {
            $this->postManifestation();
        } else if($this->isSupernatural && isset($this->manifestation) && !isset($this->focus)) {
            $this->postFocus();
        } else if($this->isSupernatural && isset($this->manifestation) && isset($this->focus) && $this->getExpertise($this->manifestation->expertiseType) == null) {
            $this->postDoctrineRadio();
        } else if($this->isSupernatural && $this->pointPower > 0) {
            $this->postPotential();
        } else if($this->pointMoney > 0) {
            $this->postMoney();
        } else if(!isset($this->nature)) {
            $this->postNature();
        } else if(!isset($this->identity)) {
            $this->postIdentity();
        } else if($this->pointGift > 0) {
            $this->postGift();
        } else if($this->pointImperfection > 0) {
            $this->postImperfection();
        } else if($this->pointMilestone > 0) {
            $this->postMilestone();
        } else if($this->pointSkill > 0) {
            $this->postSkill();
        } else if($this->pointExpertise > 0) {
            $this->postExpertise();
        } else if($this->isSupernatural && $this->pointSupernatural > 0) {
            $this->postDoctrine();
        } else if(!isset($this->firstname) || !isset($this->surname) || !isset($this->gender)) {
            $this->postDescription();
        }
    }

    private function rollAttribute($do, $attributeId, $points) {
        global $component, $curl, $form;

        $attribute = $curl->get('attribute/id/'.$attributeId)['data'][0];

        $component->wrapStart();
        $form->formStart([
            'do' => 'person--'.$do,
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);
        $form->points($points);
        $form->randomNumber($attribute['name'], $points);
        $form->viewStart();
        $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, $attribute['maximum']);
        $form->viewEnd();
        $form->formEnd();
        $component->wrapEnd();
    }

    private function radioList($tableId, $list, $options) {
        global $system, $form;

        $do = isset($options['do'])
            ? $options['do']
            : 'edit';

        $form->formStart([
            'do' => 'person--'.$do,
            'id' => $this->id,
            'secret' => $this->secret,
            'return' => 'play/person/id'
        ]);

        if(isset($options['roll'])) {
            $form->randomRadio($options['roll']);
            $form->viewStart();
        }

        $system->radioList($tableId, $list);

        if(isset($options['roll'])) {
            $form->viewEnd();
        }

        $form->formEnd();
    }

    // BUILD

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

    // MAKE

    public function makeAttributeList() {
        $list = [];

        $list[] = $this->getAttribute(null,$this->world->experienceAttribute)[0];
        $list[] = $this->getAttribute(null,$this->world->damageAttribute)[0];

        if($this->isSupernatural) {
            $list[] = $this->getAttribute(null,$this->manifestation->powerAttribute)[0];
        }

        $this->makeCard($list);
    }

    public function makeAugmentation() {
        global $component;

        if($this->world->augmentationExists) {
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
        $itemAttribute = $this->getAttribute(null,$this->world->diseaseAttribute)[0];

        $stamina = $this->getAttribute(null,$this->world->staminaAttribute);
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

        $list = $this->getExpertise($this->world->diceExpertiseType);

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

        $list = $this->getExpertise($this->world->attributeExpertiseType);

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
        $attributeList = $this->getAttribute($this->world->protectionAttributeType);
        $tolerance = $this->getAttribute(null,$this->world->toleranceAttribute)[0];

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
        $itemAttribute = $this->getAttribute(null,$this->world->sanityAttribute)[0];

        $resilience = $this->getAttribute(null,$this->world->resilienceAttribute);
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
        $itemAttribute = $this->getAttribute(null,$this->world->traumaAttribute)[0];

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