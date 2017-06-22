<?php class Person {
    var $id, $nickname, $description,
        $firstname, $surname, $occupation, $gender, $age, $personality, $appearance,
        $drive, $pride, $problem;

    var $isOwner, $isPlayable, $isCalculated, $isCheater, $isSupernatural;

    var $popularity;

    var $background, $focus, $identity, $manifestation, $nature, $species, $world;

    var $pointExpertise, $pointGift, $pointImperfection, $pointMilestone, $pointMoney, $pointPowe, $pointRelationship,
        $pointSkill, $pointDoctrine;

    var $siteLink;

    public function __construct($id) {
        global $curl, $system;

        $data = $curl->get('person/id/'.$id)['data'][0];

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('person',$this->id);
        $this->isPlayable = intval($data['playable']);
        $this->isCalculated = intval($data['calculated']);

        $this->popularity = $data['popularity'];

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

            $this->pointDoctrine = intval($data['point_doctrine']);
            $this->pointExpertise = intval($data['point_expertise']);
            $this->pointGift = intval($data['point_gift']);
            $this->pointImperfection = intval($data['point_imperfection']);
            $this->pointMilestone = intval($data['point_milestone']);
            $this->pointMoney = intval($data['point_money']);
            $this->pointPower= intval($data['point_power']);
            $this->pointRelationship = intval($data['point_relationship']);
            $this->pointSkill = intval($data['point_skill']);
        }

        $this->siteLink = '/play/person/'.$this->id;
    }

    public function create() {
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

    public function put() {
        if(!$this->isOwner) exit;

        global $component, $form;

        $component->h2('Description');
        $component->wrapStart();
        $form->form([
            'do' => 'person--edit--description',
            'id' => $this->id,
            'return' => 'play/person'
        ]);
        $form->varchar(true, 'nickname', 'Nickname', null, null, $this->nickname);
        $form->varchar(true, 'firstname', 'First Name', null, null, $this->firstname);
        $form->varchar(true, 'surname', 'Surname', null, null, $this->surname);
        $form->varchar(true, 'drive', 'Drive', 'What drives your character forward?', null, $this->drive);
        $form->varchar(true, 'pride', 'Pride', 'What is the thing your character is most proud of?', null, $this->pride);
        $form->varchar(true, 'problem', 'Problem', 'What kind of problem does your character fight with?', null, $this->problem);
        $form->varchar(true, 'gender', 'Gender', null, null, $this->gender);
        $form->number(true, 'age', 'Age', 'When changing age after creation, the system will no longer change any other variables.', null, 1, $this->species->maxAge, $this->age);
        $form->text(false, 'description', 'Description', 'Describe your character. Features, etc.', null, $this->description);
        $form->text(false, 'personality', 'Personality', 'Describe your character\'s personality. Behaviour, Mannerisms, etc.');
        $form->text(false, 'appearance', 'Appearance', 'Describe your character\'s appearance.');
        $form->text(false, 'species_custom', 'Species', 'Customize your species description if you wish.',null,$this->species->description);
        $form->text(false, 'background_custom', 'Background', 'Customize your background description if you wish.',null,$this->background->description);
        $form->submit();
        $component->wrapEnd();
    }

    public function view() {
        global $component;

        if($this->isOwner && !$this->isCalculated && $this->isPlayable) {
            $this->create();
        } else {
            $this->quickLinks();

            $this->makeSavePersonButton();

            $component->sectionStart();
            $component->p('This is '.$this->firstname.' "'.$this->nickname.'" '.$this->surname.'. '.$this->firstname.' is a '.$this->occupation);

            if($this->isPlayable && $this->isCalculated) {
                $component->p($this->firstname.' is '.$this->age.' years old. '.$this->firstname.'\'s gender is '.$this->gender);
                $component->p('Drive: '.$this->drive);
                $component->p('Pride: '.$this->pride);
                $component->p('Problem: '.$this->problem);

                if($this->description != null) $component->p($this->description);
                if($this->personality != null) $component->p($this->personality);
                if($this->appearance != null) $component->p($this->appearance);
            }

            if($this->isOwner) {
                $component->link($this->siteLink.'/edit/description','Edit Description');
            }

            $component->sectionEnd();

            if($this->isPlayable && $this->isCalculated) {
                $component->sectionStart();

                $component->h2('Skill');
                $this->buildButton($this->getSkill(), 'skill');

                $this->makeExpertise();

                $this->makeDoctrine();

                $component->h2('Weapon', 'weapon');
                $this->buildButton($this->getWeapon(1), 'weapon');

                $component->h2('Consumable');
                $this->buildButton($this->getAttribute($this->world->consumableAttributeType), 'consumable');

                $component->h2('Attribute');
                $this->buildButton($this->getAttribute($this->world->reputationAttributeType), 'attribute');
                $this->buildButton($this->getAttribute($this->world->combatAttributeType), 'attribute');

                $component->sectionEnd();

                $component->sectionStart('sw-is-gray');

                $component->h2('Wound', 'wound');
                $this->makeWound();

                if($this->isOwner) {
                    $component->link($this->siteLink.'/wound','Add Wound');
                }
                if($this->isOwner) {
                    $component->link($this->siteLink.'/disease','Add Disease');
                }
                if($this->isOwner) {
                    $component->link($this->siteLink.'/sanity','Add Sanity');
                }

                $component->sectionEnd();

                $component->h2('Features');
                $this->makeAttributeList();
                $this->makeFeatures();

                if($this->isOwner) {
                    $component->linkButton($this->siteLink.'/edit', 'Level Up', '/img/arrow-up.png');
                }

                $component->h2('Equipment');
                $component->h3('Weapon','eq_weapon');
                $this->equipWeapon();

                if($this->isOwner) {
                    $component->link($this->siteLink.'/edit/weapon','Edit Weapon');
                }

                $component->h3('Protection','eq_protection');
                $this->equipProtection();

                if($this->isOwner) {
                    $component->link($this->siteLink.'/edit/protection','Edit Protection');
                }

                if($this->world->bionicExists) {
                    $component->h3('Bionic','eq_bionic');
                    $this->buildList($this->getBionic());

                    if($this->isOwner) {
                        $component->link($this->siteLink.'/edit/bionic','Edit Bionic');
                    }
                }

                $this->equipAugmentation();
            }
        }
    }

    // GET

    public function getAttribute($type = null, $id = null) {
        global $system;

        $get = isset($type)
            ? 'person/id/'.$this->id.'/attribute/type/'.$type
            : 'person/id/'.$this->id.'/attribute/id/'.$id;

        return $system->getAttribute($get);
    }

    public function getAugmentation($bionic = null) {
        global $system;

        $get = isset($bionic)
            ? 'person/id/'.$this->id.'/augmentation/bionic/'.$bionic
            : 'person/id/'.$this->id.'/augmentation';

        return $system->getAugmentation($get);
    }

    public function getBionic($id = null) {
        global $system;

        $get = isset($id)
            ? 'person/id/'.$this->id.'/bionic/id/'.$id
            : 'person/id/'.$this->id.'/bionic';

        return $system->getBionic($get);
    }

    public function getDisease() {
        global $system;

        return $system->getDisease('person/id/'.$this->id.'/disease');
    }

    public function getDoctrine() {
        global $system;

        return $system->getDoctrine('person/id/'.$this->id.'/doctrine');
    }

    public function getExpertise($override = null) {
        global $system;

        $get = isset($override)
            ? 'person/id/'.$this->id.'/expertise'.$override
            : 'person/id/'.$this->id.'/expertise';

        return $system->getExpertise($get);
    }

    public function getGift() {
        global $system;

        return $system->getGift('person/id/'.$this->id.'/gift');
    }

    public function getImperfection() {
        global $system;

        return $system->getImperfection('person/id/'.$this->id.'/imperfection');
    }

    public function getMilestone() {
        global $system;

        return $system->getMilestone('person/id/'.$this->id.'/milestone');
    }

    public function getProtection($equipped = null) {
        global $system;

        $get = isset($equipped)
            ? 'person/id/'.$this->id.'/protection/equipped/'.$equipped
            : 'person/id/'.$this->id.'/protection';

        return $system->getProtection($get);
    }

    public function getSanity() {
        global $system;

        return $system->getSanity('person/id/'.$this->id.'/sanity');
    }

    public function getSkill() {
        global $system;

        return $system->getSkill('person/id/'.$this->id.'/skill');
    }

    public function getSoftware() {
        global $system;

        return $system->getSoftware('person/id/'.$this->id.'/software');
    }

    public function getWeapon($equipped = null) {
        global $system;

        $get = isset($equipped)
            ? 'person/id/'.$this->id.'/weapon/equipped/'.$equipped
            : 'person/id/'.$this->id.'/weapon';

        return $system->getWeapon($get);
    }

    public function getWound() {
        global $system;

        return $system->getWound('person/id/'.$this->id.'/wound');
    }

    // POST

    public function postAttribute($cheat = false) {
        if(!$this->isOwner) exit;

        global $component, $form;

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $totalPoints = intval($experience->value);

        $component->h1('Purchase Attributes');
        $component->subtitle('You will be using <span>'.$totalPoints.'</span> points to increase your Attributes.');

        $form->form([
            'special' => 'person',
            'do' => 'relation--value--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'play/person'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($totalPoints);
            $form->hidden('experience', $experience->id, 'post');
        }

        $bodyList = $this->getAttribute($this->world->bodyAttributeType);
        $combatList = $this->getAttribute($this->world->combatAttributeType);
        $damageList = $this->getAttribute($this->world->damageAttributeType);
        $reputationList = $this->getAttribute($this->world->reputationAttributeType);

        foreach($bodyList as $attribute) {
            $form->purchase('insert_id', $attribute->name, $attribute->description, $attribute->icon, $attribute->id, $attribute->value, $attribute->maximum, $attribute->value);
        }

        foreach($combatList as $attribute) {
            $form->purchase('insert_id', $attribute->name, $attribute->description, $attribute->icon, $attribute->id, $attribute->value, $attribute->maximum, $attribute->value);
        }

        foreach($damageList as $attribute) {
            $form->purchase('insert_id', $attribute->name, $attribute->description, $attribute->icon, $attribute->id, $attribute->value, $attribute->maximum, $attribute->value);
        }

        foreach($reputationList as $attribute) {
            $form->purchase('insert_id', $attribute->name, $attribute->description, $attribute->icon, $attribute->id, $attribute->value, $attribute->maximum, $attribute->value);
        }

        $form->submit();
    }

    public function postAugmentation($bionicId) {
        if(!$this->isOwner) exit;

        global $system, $form, $component;

        $bionic = $this->getBionic($bionicId)[0];
        $list = $this->world->getAugmentation($bionicId);
        $idList = $system->idList($this->getAugmentation());

        $component->h2($bionic->name);

        $form->form([
            'special' => 'person',
            'do' => 'augmentation',
            'id' => $this->id,
            'return' => 'play/person',
            'returnid' => 'eq_augmentation'
        ]);
        $form->checkboxList($list,[
            'idList' => $idList
        ]);
        $form->hidden('bionic_id', $bionicId);
        $system->checkboxAll();
        $form->submit();
    }

    public function postBackground() {
        if(!$this->isOwner) exit;

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
        if(!$this->isOwner) exit;

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
        if(!$this->isOwner) exit;

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

    public function postDisease() {
        if(!$this->isOwner) exit;

        global $component, $form;

        if($this->isOwner) {
            $component->h1('Add Disease');
            $component->wrapStart();
            $form->form([
                'do' => 'context--post',
                'context' => 'person',
                'id' => $this->id,
                'context2' => 'disease',
                'return' => 'play/person',
                'returnid' => 'disease'
            ]);
            $form->varchar(true, 'name', 'Short Description', 'A disease is a persistant harmful effect that you have suffered. It can either be poison or natural sickness. You are either way probably debilitated.');
            $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
            $form->submit();
            $component->wrapEnd();
        }
    }

    public function postDoctrine($cheat = false, $creation = false) {
        if(!$this->isOwner) exit;

        global $component, $curl, $form;

        $do = $creation ? 'post--doctrine' : 'relation--value--post';

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $doctrineList = $this->manifestation->getDoctrine();
        $currentList = $this->getDoctrine();

        $powerValue = $curl->get('person/id/'.$this->id.'/attribute/id/'.$this->manifestation->power)['data'][0]['value'];

        $creationPoints = $creation ? intval($this->pointDoctrine) : 0;
        $experiencePoints = $creation ? 0 : intval($experience->value);

        $totalPoints = $creationPoints + $experiencePoints;

        $component->h1('Purchase Doctrines');
        $component->subtitle('You will be using <span>'.$totalPoints.'</span> points to add or upgrade Doctrines.');

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
            $value = null;

            $maximum = $powerValue > $doctrine->maximum
                ? $doctrine->maximum
                : $powerValue;

            foreach($currentList as $doc) {
                if($doc->id == $doctrine->id) {
                    $value = $doc->value;
                    break;
                }
            }

            $form->purchase('insert_id', $doctrine->name, $doctrine->description, $doctrine->icon, $doctrine->id, $value, $maximum, $value);
        }

        $form->submit();
    }

    public function postExpertise($cheat = false, $creation = false) {
        if(!$this->isOwner) exit;

        global $component, $form, $system;

        $do = $creation ? 'post--expertise' : 'relation--value--post';

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $skillList = $this->getSkill();
        $currentList = $this->getExpertise();

        $creationPoints = $creation ? intval($this->pointExpertise) : 0;
        $experiencePoints = $creation ? 0 : intval($experience->value);

        $totalPoints = $creationPoints + $experiencePoints;

        $component->h1('Purchase Expertise');
        $component->subtitle('You will be using <span>'.$totalPoints.'</span> points to add or upgrade Expertises.');

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
                $calculation = $skill->value - $skill->required;
                $maximumExpertiseValue = floor($calculation / $skill->increment);

                $component->h2($skill->name);

                // Looping through world list, getting the expertises that we selected when creating world
                $worldList = $this->world->getExpertise('/skill/'.$skill->id);
                $this->expertisePurchase($worldList, $currentList, $maximumExpertiseValue);

                // Looping through species list, getting the expertises associated to this species, regardless of world
                $speciesList = $system->getExpertise('expertise/skill/'.$skill->id.'/species/'.$this->species->id);
                $this->expertisePurchase($speciesList, $currentList, $maximumExpertiseValue);

                if($this->isSupernatural) {
                    // Looping through manifestation list, getting the expertises associated to this manifestation, regardless of world
                    $manifestationList = $system->getExpertise('expertise/skill/'.$skill->id.'/manifestation/'.$this->manifestation->id);
                    $this->expertisePurchase($manifestationList, $currentList, $maximumExpertiseValue);
                }
            }
        }

        $form->submit();
    }

    public function postFocus() {
        if(!$this->isOwner) exit;

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
        $form->radioList($focusList);
        $form->submit();
    }

    public function postGift($cheat = false) {
        if(!$this->isOwner) exit;

        global $component, $system, $form;

        $component->h1('Gift');
        $component->subtitle('Get <span>'.$this->pointGift.'</span> gift that sets your character aside from others.');

        $list = null;

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

        $list = $this->world->getGift();
        $form->radioList($list,['idList' => $idList]);

        $speciesList = $system->getGift('gift/species/'.$this->species->id);
        $form->radioList($speciesList,['idList' => $idList]);

        if($this->isSupernatural) {
            $manifestationList = $system->getGift('gift/manifestation/'.$this->manifestation->id);
            $form->radioList($manifestationList,['idList' => $idList]);
        }

        $form->viewEnd();
        $form->submit();
    }

    public function postIdentity() {
        if(!$this->isOwner) exit;

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
        $form->radioList($list);
        $form->submit();
    }

    public function postImperfection($cheat = false) {
        if(!$this->isOwner) exit;

        global $component, $system, $form;

        $component->h1('Imperfection');
        $component->subtitle('Get <span>'.$this->pointImperfection.'</span> imperfection that sets your character aside from others.');

        $list = null;

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

        $list = $this->world->getImperfection();
        $form->radioList($list,['idList' => $idList]);

        $speciesList = $system->getImperfection('imperfection/species/'.$this->species->id);
        $form->radioList($speciesList,['idList' => $idList]);

        if($this->isSupernatural) {
            $manifestationList = $system->getImperfection('imperfection/manifestation/'.$this->manifestation->id);
            $form->radioList($manifestationList,['idList' => $idList]);
        }

        $form->viewEnd();
        $form->submit();
    }

    public function postManifestation() {
        if(!$this->isOwner) exit;

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
        $form->radioList($list);
        $form->submit();
    }

    public function postMilestone($cheat = false) {
        if(!$this->isOwner) exit;

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
        if(!$this->isOwner) exit;

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
        if(!$this->isOwner) exit;

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
        $form->radioList($list);
        $form->submit();
    }

    public function postPower() {
        if(!$this->isOwner) exit;

        global $component, $curl, $form;

        $component->h1('Potential');
        $component->subtitle('You will be rolling <span>'.$this->pointPower.'</span> dice to determine your potential.');

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
        if(!$this->isOwner) exit;

        global $component, $form, $system;

        $component->h1('Protection');
        $component->subtitle('Select the protective gear you want to add to your character.');

        $list = $this->world->getProtection();
        $idList = $system->idList($this->getProtection());

        $form->form([
            'do' => 'relation--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'protection',
            'return' => 'play/person'
        ]);

        $form->checkboxList($list, [
            'idList' => $idList
        ]);

        $system->checkboxAll();
        $form->submit();
    }

    public function postSanity() {
        if(!$this->isOwner) exit;

        global $component, $form;

        if($this->isOwner) {
            $component->h1('Add Sanity');
            $component->wrapStart();
            $form->form([
                'do' => 'context--post',
                'context' => 'person',
                'id' => $this->id,
                'context2' => 'sanity',
                'return' => 'play/person',
                'returnid' => 'sanity'
            ]);
            $form->varchar(true, 'name', 'Short Description', 'Taking sanity damage is no easy thing. Every mind can only take so much pressure before breaking.');
            $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
            $form->submit();
            $component->wrapEnd();
        }
    }

    public function postSkill($cheat = false, $creation = false) {
        if(!$this->isOwner) exit;

        global $component, $form;

        $do = $creation ? 'post--skill' : 'relation--value--post';

        $experience = $this->getAttribute(null, $this->world->experienceAttribute)[0];
        $skillList = $this->getSkill();

        $creationPoints = $creation ? intval($this->pointSkill) : 0;
        $experiencePoints = $creation ? 0 : intval($experience->value);

        $totalPoints = $creationPoints + $experiencePoints;

        $component->h1('Purchase Skills');
        $component->subtitle('You will be using <span>'.$totalPoints.'</span> points to upgrade your Skills. Ensure that at least one skill is above 3.');

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
            $form->purchase('insert_id', $skill->name, $skill->description, $skill->icon, $skill->id, $skill->value, $skill->maximum, $skill->value);
        }

        $form->submit();
    }

    public function postSoftware() {} //todo

    public function postWeapon() {
        if(!$this->isOwner) exit;

        global $component, $form, $system;

        $component->h1('Weapon');
        $component->subtitle('Select the weapons you want to add to your character.');

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

    public function postWound() {
        if(!$this->isOwner) exit;

        global $component, $form;

        if($this->isOwner) {
            $component->h1('Add Wound');
            $component->wrapStart();
            $form->form([
                'do' => 'context--post',
                'context' => 'person',
                'id' => $this->id,
                'context2' => 'wound',
                'return' => 'play/person',
                'returnid' => 'wound'
            ]);
            $form->varchar(true, 'name', 'Short Description', 'A wound is significant damage that you have taken. It can either be serious or lethal.');
            $form->pick(true, 'timestwo', 'Double Damage','Check this if you have suffered double damage.');
            $form->submit();
            $component->wrapEnd();
        }
    }

    // PUT

    public function putAmmunition() {
        if(!$this->isOwner) exit;

        global $component, $form;

        $attribute = $this->getAttribute(null, $this->world->ammunitionAttribute)[0];

        $component->h2('Ammunition');
        $component->wrapStart();
        $form->form([
            'do' => 'relation--value--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'play/person'
        ]);
        $form->number(true, 'insert_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
        $form->submit();
        $component->wrapEnd();
    }

    public function putExperience() {
        if(!$this->isOwner) exit;

        global $component, $form;

        $attribute = $this->getAttribute(null, $this->world->experienceAttribute)[0];

        $component->h1('Experience');
        $component->wrapStart();
        $form->form([
            'do' => 'relation--value--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'play/person'
        ]);
        $form->number(true, 'insert_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
        $form->submit();
        $component->wrapEnd();
    }

    public function putMoney() {
        if(!$this->isOwner) exit;

        global $component, $form;

        $attribute = $this->getAttribute(null, $this->world->moneyAttribute)[0];

        $component->h2('Money');
        $component->wrapStart();
        $form->form([
            'do' => 'relation--value--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'play/person'
        ]);
        $form->number(true, 'insert_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
        $form->submit();
        $component->wrapEnd();
    }

    public function putRations() {
        if(!$this->isOwner) exit;

        global $component, $form;

        $attribute = $this->getAttribute(null, $this->world->rationsAttribute)[0];

        $component->h2('Rations');
        $component->wrapStart();
        $form->form([
            'do' => 'relation--value--post',
            'context' => 'person',
            'id' => $this->id,
            'context2' => 'attribute',
            'return' => 'play/person'
        ]);
        $form->number(true, 'insert_id', $attribute->name, $attribute->description, $attribute->id, null, $attribute->maximum, $attribute->value);
        $form->submit();
        $component->wrapEnd();
    }

    // BUILD

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
                    'icon' => '/img/delete.png'
                ])
            :   null;

        $component->listAction($title, $quick, ['icon' => $icon]);
    }

    function buildList($list) {
        global $component;

        if($list) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }
    }

    function buildButton($list, $type) {
        global $component, $system;

        $component->wrapStart(true);

        if($list) {
            foreach($list as $item) {

                $value = null;
                $data = null;

                switch($type)
                {
                    case 'consumable':
                        $value = $item->value.'d'.$system->defaultDice['value'];
                        $data = 'data-roll-type="consumable" 
                             data-roll-dice="'.$item->value.'"';
                        break;

                    case 'attribute':
                        $value = $item->value > 0
                            ? $system->defaultDice['amount'].'d'.$system->defaultDice['value'].'+'.$item->value
                            : $system->defaultDice['amount'].'d'.$system->defaultDice['value'];

                        $data = 'data-roll-type="attribute" 
                             data-roll-dice="'.$system->defaultDice['amount'].'" 
                             data-roll-bonus="'.$item->value.'"';
                        break;

                    case 'skill':
                        $value = $item->diceText;
                        $data = $item->diceData;
                        break;

                    case 'weapon':
                        $value = $item->diceText;
                        $data = $item->diceData;
                        break;

                }

                $component->roll($item->name, $item->description, $item->icon, $value, $data);
            }
        }

        $component->wrapEnd();
    }

    function buildWound($context, $id, $title, $heal, $rowIcon, $actionIcon) {
        global $component, $form;

        $title = $heal == 1
            ? $title . ' (Healed)'
            : $title;

        $opacity = $heal == 1
            ? ' sw-is-opacity'
            : null;

        $flipHeal = $heal == 1
            ? 0
            : 1;

        $quick = $this->isOwner
            ?   $form->quick([
                'special' => 'person',
                'do' => 'heal',
                'context' => $context,
                'id' => $this->id,
                'context2' => $id,
                'extra' => $flipHeal,
                'return' => 'play/person',
                'returnid' => 'wound',
                'icon' => $actionIcon
            ])
            :   null;

        $component->listAction($title, $quick, ['icon' => $rowIcon, 'class' => $opacity]);
    }

    // MAKE

    public function makeAttributeList() {
        global $component;

        $list = [];

        $list[] = $this->getAttribute(null,$this->world->experienceAttribute)[0];
        $list[] = $this->getAttribute(null,$this->world->damageAttribute)[0];

        if($this->isSupernatural) {
            $list[] = $this->getAttribute(null,$this->manifestation->power)[0];
        }

        if($this->world->bionicExists) {
            $list[] = $this->getAttribute(null,$this->world->energyAttribute)[0];
        }

        echo('<div class="sw-u-center">');

        foreach($list as $object) {
            $color = $object->value < 0
                ? ' sw-is-invalid'
                : null;

            $component->attribute($object->name, $object->value, $color);
        }

        echo('</div>');
    }

    public function makeDoctrine() {
        global $system;

        if($this->isSupernatural) {
            global $component;

            $expertiseList = $this->getExpertise('/manifestation/'.$this->manifestation->id);

            $component->h2($this->manifestation->name);
            $component->wrapStart(true);

            $list = $this->getDoctrine();

            foreach($list as $item) {
                $rollD12 = $system->defaultDice['amount'];
                $rollBonus = 0;

                if($expertiseList) {
                    foreach($expertiseList as $expertise) {
                        if($item->expertise == $expertise->id) {
                            $rollD12 += intval($expertise->value);
                            $rollBonus += intval($expertise->bonus);
                        }
                    }
                }

                $data = 'data-roll-type="doctrine" 
                         data-roll-dice="'.$rollD12.'" 
                         data-roll-bonus="'.$rollBonus.'" 
                         data-strike-dice="'.$item->value.'"';

                $component->roll($item->name, $item->description, $item->icon, $item->diceText, $data);
            }

            $component->wrapEnd();
        }
    }

    public function makeExpertise() {
        global $component;

        $list = $this->getExpertise($this->world->diceExpertiseType);

        if($list) {
            $component->h2('Expertise');
            $component->wrapStart(true);

            foreach($list as $item) {
                $component->roll($item->name, $item->description, $item->icon, $item->diceText, $item->diceData);
            }

            $component->wrapEnd();
        }
    }

    public function makeFeatures() {
        global $component;

        echo('<div class="sw-c-content">');

        $giftList = $this->getGift();
        $imperfectionList = $this->getImperfection();
        $milestoneList = $this->getMilestone();

        $component->listItem($this->species->name, $this->species->description, $this->species->icon);
        $component->listItem($this->background->name, $this->background->description, $this->background->icon);
        $component->listItem($this->nature->name, $this->nature->description, $this->nature->icon);
        $component->listItem($this->identity->name, $this->identity->description, $this->identity->icon);

        if($giftList) {
            foreach($giftList as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        if($imperfectionList) {
            foreach($imperfectionList as $item) {
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

    public function makeWound() {
        global $component;

        $woundCount = 0;
        $sanityCount = 0;
        $diseaseCount = 0;

        $woundList = $this->getWound();
        $sanityList = $this->getSanity();
        $diseaseList = $this->getDisease();

        $traumaAttribute = $this->getAttribute(null,$this->world->traumaAttribute)[0];
        $sanityAttribute = $this->getAttribute(null,$this->world->sanityAttribute)[0];
        $diseaseAttribute = $this->getAttribute(null,$this->world->diseaseAttribute)[0];

        $tolerance = $this->getAttribute(null,$this->world->toleranceAttribute)[0];
        $stamina = $this->getAttribute(null,$this->world->staminaAttribute)[0];
        $resilience = $this->getAttribute(null,$this->world->resilienceAttribute)[0];

        $protectionList = $this->getAttribute($this->world->protectionAttributeType);

        // MAKE CARDS WITH RESISTANCE ATTRIBUTES

        echo('<div class="sw-u-center">');

        $component->attribute($tolerance->name, $tolerance->value);
        $component->attribute($stamina->name, $stamina->value);
        $component->attribute($resilience->name, $resilience->value);

        echo('</div>');

        echo('<div class="sw-u-center">');

        foreach($protectionList as $item) {
            $item->value = intval($item->value) + intval($tolerance->value);

            if($item->value > $tolerance->value) {
                $component->attribute($item->name, $item->value);
            }
        }

        echo('</div>');

        // MAKE LISTS

        if(isset($woundList)) {
            foreach($woundList as $item) {
                if($item->heal == 0) {
                    $woundCount = $woundCount + $item->value;
                }

                $this->buildWound('wound', $item->id, $item->name, $item->heal, $item->icon, $item->healIcon);
            }
        }

        if(isset($sanityList)) {
            foreach($sanityList as $item) {
                if($item->heal == 0) {
                    $sanityCount = $sanityCount + $item->value;
                }

                $this->buildWound('sanity', $item->id, $item->name, $item->heal, $item->icon, $item->healIcon);
            }
        }

        if(isset($diseaseList)) {
            foreach($diseaseList as $item) {
                if($item->heal == 0) {
                    $diseaseCount = $diseaseCount + $item->value;
                }

                $this->buildWound('disease', $item->id, $item->name, $item->heal, $item->icon, $item->healIcon);
            }
        }

        // MAKE CARDS WITH WOUNDS LEFT

        echo('<div class="sw-u-center">');

        if($woundCount != 0) {
            $color = $woundCount >= $traumaAttribute->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($traumaAttribute->name, $woundCount.'/'.$traumaAttribute->value,$color);
        }

        if($sanityCount != 0) {
            $color = $sanityCount >= $sanityAttribute->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($sanityAttribute->name, $sanityCount.'/'.$sanityAttribute->value,$color);
        }

        if($diseaseCount != 0) {
            $color = $diseaseCount >= $diseaseAttribute->value
                ? ' sw-is-invalid'
                : null;

            $component->attribute($diseaseAttribute->name, $diseaseCount.'/'.$diseaseAttribute->value,$color);
        }

        echo('</div>');
    }

    // EQUIP

    public function equipAugmentation() {
        global $component, $form;

        if($this->world->augmentationExists) {
            $component->h3('Augmentation','eq_augmentation');

            $bionicList = $this->getBionic();

            if($bionicList) {
                foreach($bionicList as $bionic) {
                    $augmentationList = $this->getAugmentation($bionic->id);

                    if($augmentationList) {
                        $component->h4($bionic->name);

                        foreach($augmentationList as $item) {
                            echo $item->active;

                            $opacity = $item->active == 1
                                ? null
                                : ' sw-is-opacity';

                            $img = $item->active == 1
                                ? '/img/color/switch-true.png'
                                : '/img/color/switch-false.png';

                            $do = $item->active == 1
                                ? 'deactivate'
                                : 'activate';

                            $quick = $this->isOwner
                                ?   $form->quick([
                                    'special' => 'person',
                                    'do' => $do,
                                    'context' => 'augmentation',
                                    'id' => $this->id,
                                    'extra' => $item->id,
                                    'extra2' => $bionic->id,
                                    'return' => 'play/person',
                                    'returnid' => 'eq_augmentation',
                                    'icon' => $img
                                ])
                                :   null;

                            $component->listAction($item->name, $quick, [
                                'icon' => $item->icon,
                                'class' => $opacity
                            ]);
                        }
                    }
                }
            }

            if($this->isOwner) {
                $component->link($this->siteLink.'/edit/augmentation','Edit Augmentation');
            }
        }
    }

    public function equipProtection() {
        $list = $this->getProtection();

        if(isset($list)) {
            foreach($list as $item) {
                $this->equip('protection', $item->id, $item->name, $item->icon, $item->equipped, 'eq_protection');
            }
        }
    }

    public function equipWeapon() {
        $list = $this->getWeapon();

        if(isset($list)) {
            foreach($list as $item) {
                $this->equip('weapon', $item->id, $item->name, $item->icon, $item->equipped, 'eq_weapon');
            }
        }
    }

    // PRIVATE

    private function makeSavePersonButton() {
        global $form, $user;

        if(!$user->isActive || $this->isOwner) exit;

        $form->form([
            'special' => 'user',
            'do' => 'save',
            'context' => 'person',
            'return' => 'play/person',
            'id' => $this->id
        ]);
        $form->submit(false, 'Save this person');
    }

    private function expertisePurchase($list, $personList, $maximumExpertiseValue) {
        global $form;

        if($list) {
            foreach($list as $expertise) {
                $value = null;

                $calculatedMax = $expertise->maximum <= $maximumExpertiseValue
                    ? $expertise->maximum
                    : $maximumExpertiseValue + 1;

                if($personList) {
                    foreach($personList as $exp) {
                        if($exp->id == $expertise->id) {
                            $value = $exp->value;
                            break;
                        }
                    }
                }

                if($calculatedMax != 0) {
                    $form->purchase('insert_id', $expertise->name, $expertise->description, $expertise->icon, $expertise->id, $value, $calculatedMax, $value);
                }
            }
        }
    }

    private function equip($tableName, $tableId, $title, $icon, $equipped, $returnId = null) {
        global $component, $form;

        $opacity = $equipped == 1
            ? null
            : ' sw-is-opacity';

        $img = $equipped == 1
            ? '/img/color/switch-true.png'
            : '/img/color/switch-false.png';

        $do = $equipped == 1
            ? 'unequip'
            : 'equip';

        $quick = $this->isOwner
            ?   $form->quick([
                'special' => 'person',
                'do' => $do,
                'context' => $tableName,
                'id' => $this->id,
                'extra' => $tableId,
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

    private function quickLinks() {
        global $component;
        if($this->isPlayable && $this->isCalculated && $this->isOwner) {
            echo('<div class="sw-l-quicklink">');
            $component->linkQuick($this->siteLink.'/edit/weapon','Weapon','/img/weapon.png');
            $component->linkQuick($this->siteLink.'/edit/protection','Protection','/img/armor.png');
            $component->linkQuick($this->siteLink.'/edit','Edit','/img/edit.png');
            echo('</div>');
        }
    }
}