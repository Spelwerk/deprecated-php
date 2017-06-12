<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */

require_once('World.php');

class Person {

    var $id, $nickname, $description,
        $firstname, $surname, $occupation, $gender, $age, $personality, $appearance,
        $drive, $pride, $problem;

    var $isOwner, $isPlayable, $isCalculated, $isCheater, $isSupernatural;

    var $popularity, $thumbsup, $thumbsdown;

    var $background, $focus, $identity, $manifestation, $nature, $species, $world;

    var $pointExpertise, $pointGift, $pointImperfection, $pointMilestone, $pointMoney, $pointPowe, $pointRelationship,
        $pointSkill, $pointDoctrine, $pointDoctrineExpertise;

    var $siteLink;

    public function __construct($id) {
        global $curl;

        $data = $curl->get('person/id/'.$id)['data'][0];

        $this->isOwner = isset($data['owner']) ? $data['owner'] : false;

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
            $this->pointDoctrine = intval($data['point_doctrine']);
            $this->pointDoctrineExpertise = intval($data['point_doctrine_expertise']);
        }

        $this->siteLink = '/play/person/'.$this->id;
    }

    public function create() {
        echo($this->isSupernatural);

        if(!isset($this->background)) {
            $this->postBackground();
        } else if($this->isSupernatural && !isset($this->manifestation)) {
            $this->postManifestation();
        } else if($this->isSupernatural && !isset($this->focus)) {
            $this->postFocus();
        } else if($this->isSupernatural && $this->pointPower > 0) {
            $this->postPower();
        } else if($this->pointMoney > 0) {
            $this->postMoney();
        } else if(!isset($this->nature)) {
            $this->postNature();
        } else if(!isset($this->identity)) {
            $this->postIdentity();
        } else if($this->pointGift > 0) {
            $this->postGift(false);
        } else if($this->pointImperfection > 0) {
            $this->postImperfection(false);
        } else if($this->pointMilestone > 0) {
            $this->postMilestone(false);
        } else if($this->pointSkill > 0) {
            $this->postSkill(false, true);
        } else if($this->pointExpertise > 0) {
            $this->postExpertise(false, true);
        } else if($this->isSupernatural && $this->pointDoctrine > 0) {
            $this->postDoctrine(false, true);
        } else if(!isset($this->firstname) || !isset($this->surname) || !isset($this->gender)) {
            $this->postDescription(true);
        }
    }

    public function put() {} //todo

    public function view() {
        global $component;

        if($this->isOwner && !$this->isCalculated && $this->isPlayable) {
            $this->create();
        } else {
            $this->makeQuickLinks();

            $this->verifyUserOwnership();

            $this->makeDescription();

            if($this->isPlayable && $this->isCalculated) {
                $component->sectionStart();
                $component->h2('Skill');
                $this->makeButton($this->getAttribute($this->world->skillAttributeType), 'skill');
                $this->makeExpertise();
                $this->makeSupernatural();

                $component->h2('Weapon', 'weapon');
                $this->makeButton($this->getWeapon(1), 'weapon');

                $component->h2('Consumable');
                $this->makeButton($this->getAttribute($this->world->consumableAttributeType), 'consumable');

                $component->h2('Attribute');
                $this->makeButton($this->getAttribute($this->world->reputationAttributeType), 'skill');
                $this->makeButton($this->getAttribute($this->world->combatAttributeType), 'skill');

                $component->sectionEnd();

                $component->sectionStart('sw-is-gray');

                $component->h2('Wound', 'wound');
                $this->makeWound();

                if($this->isOwner) {
                    $component->linkButton($this->siteLink.'/wound','Add Wound');
                }

                $component->h2('Disease','disease');
                $this->makeDisease();

                if($this->isOwner) {
                    $component->linkButton($this->siteLink.'/disease','Add Disease');
                }

                $component->h2('Sanity','sanity');
                $this->makeSanity();

                if($this->isOwner) {
                    $component->linkButton($this->siteLink.'/sanity','Add Sanity');
                }

                $component->sectionEnd();
            }

            $component->h2('Description');

            if($this->description != null) {
                $component->p($this->description);
            }

            if($this->personality != null) {
                $component->p($this->personality);
            }

            if($this->isOwner) {
                $component->link($this->siteLink.'/edit/description','Edit Description');
            }

            if($this->isPlayable && $this->isCalculated) {
                $component->h2('Features');
                $this->makeFeatures();
                $this->makeAttributeList();

                if($this->isOwner) {
                    $component->linkButton($this->siteLink.'/edit', 'Level Up', '/img/arrow-up.png');
                }

                $component->h2('Equipment');
                $component->h3('Weapon','eq_weapon');
                $this->makeWeaponEquip();

                if($this->isOwner) {
                    $component->link($this->siteLink.'/edit/weapon','Edit Weapon');
                }

                $component->h3('Protection','eq_protection');
                $this->makeProtectionEquip();

                if($this->isOwner) {
                    $component->link($this->siteLink.'/edit/protection','Edit Protection');
                }

                if($this->world->bionicExists) {
                    $component->h3('Bionic','eq_bionic');
                    $this->makeList($this->getBionic());

                    if($this->isOwner) {
                        $component->link($this->siteLink.'/edit/bionic','Edit Bionic');
                    }
                }

                $this->makeAugmentation();

                $component->h1('Reminder');
                $component->linkButton('#','Bookmark this Person',true,'sw-js-bookmark');
            }
        }
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

    public function getDoctrine() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person/id/'.$this->id.'/doctrine');

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
            ? 'person/id/'.$this->id.'/expertise'.$override
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

    public function getSkill() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('person/id/'.$this->id.'/skill');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Skill(null, $array);
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

    public function postAttribute($attributeId) {} //todo

    public function postAugmentation($bionicId) {
        global $system, $form, $component;

        $bionic = $this->getBionic($bionicId)[0];
        $list = $this->world->getAugmentation($bionicId);
        $idList = $system->idList($this->getAugmentation());

        $component->h2($bionic->name);

        $form->form([
            'do' => 'relation--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'augmentation',
            'return' => 'play/person'
        ]);
        $form->checkboxList($list,[
            'idList' => $idList
        ]);
        $form->hidden('bionic_id', $bionicId);
        $system->checkboxAll();
        $form->submit();
    }

    public function postBackground() {
        global $component, $form;

        $list = $this->world->getBackground('/species/'.$this->species->id);

        $component->h1('Background');
        $component->subtitle('You will select <span>1</span> background from which you may gain a few attribute and skill changes.');

        $form->form([
            'do' => 'context--put',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'background',
            'return' => 'play/person'
        ]);
        $form->randomRadio('Background');
        $form->viewStart();
        $form->radioList($list);
        $form->viewEnd();
        $form->submit();
    }

    public function postBionic() {
        global $system, $form;

        $list = $this->world->getBionic();
        $idList = $system->idList($this->getBionic());

        $form->form([
            'do' => 'relation--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'bionic',
            'return' => 'play/person'
        ]);
        $form->checkboxList($list, [
            'idList' => $idList
        ]);
        $system->checkboxAll();
        $form->submit();
    }

    public function postDescription($creation = false) {
        global $form, $component;

        $do = $creation ? 'post--description' : 'put';

        $component->h1('Name & Details');

        $component->wrapStart();
        $form->form([
            'special' => 'person',
            'do' => $do,
            'id' => $this->id,
            'return' => 'play/person'
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
        $form->submit();
        $component->wrapEnd();
    }

    public function postDoctrine($cheat = false, $creation = false) {
        global $component, $curl, $form;

        $component->h1($this->manifestation->name);

        $do = $creation ? 'post--doctrine' : 'relation--value--post';

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $doctrineList = $this->world->getDoctrine($this->manifestation->id);

        $powerValue = $curl->get('person/id/'.$this->id.'/attribute/id/'.$this->manifestation->power)[0]['value'];

        $creationPoints = $creation ? intval($this->pointDoctrine) : 0;
        $experiencePoints = $creation ? 0 : intval($experience->value);

        $totalPoints = $creationPoints + $experiencePoints;

        $form->form([
            'special' => 'person',
            'do' => $do,
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'doctrine',
            'return' => 'play/person'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($totalPoints);
            $form->hidden('experience', $experience->id, 'post');
        }

        foreach($doctrineList as $doctrine) {
            $maximum = $powerValue > $doctrine->maximum
                ? $doctrine->maximum
                : $powerValue;

            $form->purchase('insert_id', $doctrine->name, $doctrine->description, $doctrine->id, 0, $maximum, $doctrine->value);
        }

        $form->submit();
    }

    public function postExpertise($cheat = false, $creation = false) {
        global $component, $form;

        $do = $creation ? 'post--expertise' : 'relation--value--post';

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $skillList = $this->getSkill();

        $creationPoints = $creation ? intval($this->pointSkill) : 0;
        $experiencePoints = $creation ? 0 : intval($experience->value);

        $totalPoints = $creationPoints + $experiencePoints;

        $component->h1('Expertise');
        $component->subtitle('You will be using <span>'.$totalPoints.'</span> points to purchase Expertises.');

        $form->form([
            'special' => 'person',
            'do' => $do,
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'expertise',
            'return' => 'play/person'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($totalPoints);
            $form->hidden('experience', $experience->id, 'post');
        }

        foreach($skillList as $skill) {
            if($skill->value >= $skill->required) {
                $math1 = $skill->value - $skill->required;
                $math2 = floor($math1 / $skill->increment);

                $override = $this->isSupernatural
                    ? '/skill/' . $skill->id . '/species/' . $this->species->id . '/manifestation/' . $this->manifestation->id
                    : '/skill/' . $skill->id . '/species/' . $this->species->id;

                $expertiseList = $this->world->getExpertise($override);

                foreach($expertiseList as $expertise) {
                    $calculatedMax = $expertise->maximum <= $math2
                        ? $expertise->maximum
                        : $math2 + 1;

                    if($calculatedMax != 0) {
                        $form->purchase('insert_id', $expertise->name, $expertise->description, $expertise->icon, $expertise->id, 0, $calculatedMax, $expertise->value);
                    }
                }
            }
        }

        $form->submit();
    }

    public function postFocus() {
        global $component, $form;

        $focusList = $this->manifestation->getFocus();

        $component->h1('Focus');
        $component->subtitle('You will select <span>1</span> focus from which you draw your power.');

        $form->form([
            'do' => 'context--put',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'focus',
            'return' => 'play/person'
        ]);
        $form->randomRadio('Focus');
        $form->viewStart();
        $form->radioList($focusList);
        $form->viewEnd();
        $form->submit();
    }

    public function postGift($cheat = false) {
        global $component, $system, $form;

        $component->h1('Gift');
        $component->subtitle('Get <span>'.$this->pointGift.'</span> gift that sets your character aside from others.');

        $list = null;

        $override = $this->isSupernatural
            ? '/species/'.$this->species->id.'/manifestation/'.$this->manifestation->id
            : '/species/'.$this->species->id;

        $list = $this->world->getGift($override);
        $idList = $system->idList($this->getGift());

        $form->form([
            'special' => 'person',
            'do' => 'post--gift',
            'id' => $this->id,
            'return' => 'play/person'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($this->pointGift);
        }

        $form->randomRadio('Gift');
        $form->viewStart();
        $form->radioList($list,[
            'idList' => $idList
        ]);
        $form->viewEnd();
        $form->submit();
    }

    public function postIdentity() {
        global $component, $form;

        $list = $this->world->getIdentity();

        $component->h1('Identity');

        $form->form([
            'do' => 'context--put',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'identity',
            'return' => 'play/person'
        ]);
        $form->randomRadio('Identity');
        $form->viewStart();
        $form->radioList($list);
        $form->viewEnd();
        $form->submit();
    }

    public function postImperfection($cheat = false) {
        global $component, $system, $form;

        $component->h1('Imperfection');
        $component->subtitle('Get <span>'.$this->pointImperfection.'</span> imperfection that sets your character aside from others.');

        $list = null;

        $override = $this->isSupernatural
            ? '/species/'.$this->species->id.'/manifestation/'.$this->manifestation->id
            : '/species/'.$this->species->id;

        $list = $this->world->getImperfection($override);
        $idList = $system->idList($this->getImperfection());

        $form->form([
            'special' => 'person',
            'do' => 'post--imperfection',
            'id' => $this->id,
            'return' => 'play/person'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($this->pointImperfection);
        }

        $form->randomRadio('Imperfection');
        $form->viewStart();
        $form->radioList($list,[
            'idList' => $idList
        ]);
        $form->viewEnd();
        $form->submit();
    }

    public function postManifestation() {
        global $component, $form;

        $list = $this->world->getManifestation();

        $component->h1('Manifestation');

        $form->form([
            'do' => 'context--put',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'manifestation',
            'return' => 'play/person'
        ]);
        $form->randomRadio('Manifestation');
        $form->viewStart();
        $form->radioList($list);
        $form->viewEnd();
        $form->submit();
    }

    public function postMilestone($cheat = false) {
        global $component, $system, $form;

        $points = $cheat
            ? 1
            : $this->pointMilestone;

        $component->h1('Milestone');
        $component->subtitle('Get <span>'.$points.'</span> milestones that have happened to your character.');

        $list = null;

        $override = $this->isSupernatural
            ? '/background/'.$this->background->id.'/species/'.$this->species->id.'/manifestation/'.$this->manifestation->id
            : '/background/'.$this->background->id.'/species/'.$this->species->id;

        $list = $this->world->getMilestone($override);
        $idList = $system->idList($this->getMilestone());

        $form->form([
            'special' => 'person',
            'do' => 'post--milestone',
            'id' => $this->id,
            'return' => 'play/person'
        ]);

        $form->points($points);
        $form->randomRadio('Milestone');
        $form->viewStart();
        $form->radioList($list, [
            'idList' => $idList
        ]);
        $form->viewEnd();
        $form->submit();
    }

    public function postMoney() {
        global $component, $curl, $form;

        $component->h1('Money');
        $component->subtitle('You will be rolling <span>'.$this->pointMoney.'</span> dice to either improve or impair your financial status.');

        $attribute = $curl->get('attribute/id/'.$this->world->moneyAttribute)['data'][0];

        $component->wrapStart();
        $form->form([
            'special' => 'person',
            'do' => 'post--money',
            'id' => $this->id,
            'return' => 'play/person'
        ]);
        $form->points($this->pointMoney);
        $form->randomNumber($attribute['name'], $this->pointMoney);
        $form->viewStart();
        $form->number(true, 'insert_id', $attribute['name'], $attribute['description'], $attribute['id'], null, $attribute['maximum']);
        $form->viewEnd();
        $form->submit();
        $component->wrapEnd();
    }

    public function postNature() {
        global $component, $form;

        $list = $this->world->getNature();

        $component->h1('Nature');

        $form->form([
            'do' => 'context--put',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'nature',
            'return' => 'play/person'
        ]);
        $form->randomRadio('Nature');
        $form->viewStart();
        $form->radioList($list);
        $form->viewEnd();
        $form->submit();
    }

    public function postPower() {
        global $component, $curl, $form;

        $component->h1('Money');
        $component->subtitle('You will be rolling <span>'.$this->pointPower.'</span> dice to either improve or impair your financial status.');

        $attribute = $curl->get('attribute/id/'.$this->manifestation->power)['data'][0];

        $component->wrapStart();
        $form->form([
            'special' => 'person',
            'do' => 'post--power',
            'id' => $this->id,
            'return' => 'play/person'
        ]);
        $form->points($this->pointPower);
        $form->randomNumber($attribute['name'], $this->pointPower);
        $form->viewStart();
        $form->number(true, 'insert_id', $attribute['name'], $attribute['description'], $attribute['id'], null, $attribute['maximum']);
        $form->viewEnd();
        $form->submit();
        $component->wrapEnd();
    }

    public function postProtection() {
        global $system, $form, $curl, $component;

        $typeList = $curl->get('protectiontype')['data'];
        $idList = $system->idList($this->getProtection());

        $form->form([
            'do' => 'relation--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'protection',
            'return' => 'play/person'
        ]);

        foreach($typeList as $type) {
            $protectionList = $this->world->getProtection('/type/'.$type['id']);

            $component->h4($type['name']);

            $form->checkboxList($protectionList, [
                'idList' => $idList
            ]);
        }

        $system->checkboxAll();
        $form->submit();
    }

    public function postSkill($cheat = false, $creation = false) {
        global $component, $form;

        $do = $creation ? 'post--skill' : 'relation--value--post';

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $skillList = $this->getSkill();

        $creationPoints = $creation ? intval($this->pointSkill) : 0;
        $experiencePoints = $creation ? 0 : intval($experience->value);

        $totalPoints = $creationPoints + $experiencePoints;

        $component->h1('Skill');
        $component->subtitle('You will be using <span>'.$totalPoints.'</span> points to purchase Skills. Ensure that at least one skill is above 3.');

        $form->form([
            'special' => 'person',
            'do' => $do,
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'skill',
            'return' => 'play/person'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($totalPoints);
            $form->hidden('experience', $experience->id, 'post');
        }

        foreach($skillList as $skill) {
            $form->purchase('insert_id', $skill->name, $skill->description, $skill->icon, $skill->id, 0, $skill->maximum, $skill->value);
        }

        $form->submit();
    }

    public function postSoftware() {} //todo

    public function postWeapon() {
        global $system, $form;

        $list = $this->world->getWeapon();
        $idList = $system->idList($this->getWeapon());

        $form->form([
            'do' => 'relation--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'weapon',
            'return' => 'play/person'
        ]);

        $form->checkboxList($list, [
            'idList' => $idList
        ]);

        $system->checkboxAll();
        $form->submit(false);
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
                    'do' => 'context--delete',
                    'context' => 'person',
                    'id' => $this->id,
                    'context2' => $tableName,
                    'extra' => $tableId,
                    'return' => 'play/person',
                    'returnid' => $returnId,
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
                    'special' => 'person',
                    'do' => 'equip',
                    'context' => $tableName,
                    'id' => $this->id,
                    'context2' => $tableId,
                    'extra' => $flip,
                    'return' => 'play/person',
                    'returnid' => $returnId,
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
            '<input type="hidden" name="post--special" value="person"/>'.
            '<input type="hidden" name="post--do" value="heal"/>'.
            '<input type="hidden" name="post--context" value="'.$context.'"/>'.
            '<input type="hidden" name="post--id" value="'.$this->id.'"/>'.
            '<input type="hidden" name="post--context2" value="'.$id.'"/>'.
            '<input type="hidden" name="post--extra" value="'.$flipHeal.'"/>'.
            '<input type="hidden" name="post--return" value="play/person"/>'.
            '<input type="hidden" name="post--returnid" value="'.$context.'"/>'.
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

    public function makeDescription() {
        global $component;

        $component->sectionStart();
        $component->p('This is '.$this->firstname.' "'.$this->nickname.'" '.$this->surname.'. '.$this->firstname.' is a '.$this->occupation);

        if($this->isPlayable && $this->isCalculated) {
            $component->p($this->firstname.' is '.$this->age.' years old. '.$this->firstname.'\'s gender is '.$this->gender);
        }

        $component->sectionEnd();
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

    public function makeQuickLinks() {
        global $component;

        if($this->isPlayable && $this->isCalculated && $this->isOwner) {
            echo('<div class="sw-l-quicklink">');

            $component->linkQuick($this->siteLink.'/wound','Wound','/img/wound-wound.png');
            $component->linkQuick($this->siteLink.'/edit/weapon','Weapon','/img/weapon.png');
            $component->linkQuick($this->siteLink.'/edit/protection','Protection','/img/armor.png');

            if($this->world->bionicExists) {
                $component->linkQuick($this->siteLink.'/edit/bionic','Bionic','/img/bionic.png');
            }

            $component->linkQuick($this->siteLink.'/edit','Edit','/img/edit.png');

            echo('</div>');
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

    // PRIVATE

    private function verifyUserOwnership() {
        global $form, $user;

        $userOwner = false;

        if($this->isOwner) {
            $list = $user->getPerson();

            if($list) {
                foreach($list as $item) {
                    if($this->id == $item->id) {
                        $userOwner = true;
                    }
                }
            }
        }

        if(!$userOwner) {
            $form->form([
                'special' => 'user',
                'do' => 'save',
                'context' => 'person',
                'return' => 'play/person',
                'id' => $this->id
            ]);
            $form->submit(false, 'Save this person');
        }
    }
}