<?php class World {
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
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('world/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $defaults = $curl->get('system/attribute');

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

        $this->ammunitionAttribute = $defaults['id']['ammunition'];
        $this->damageAttribute = $defaults['id']['damage'];
        $this->diseaseAttribute = $defaults['id']['disease'];
        $this->experienceAttribute = $defaults['id']['experience'];
        $this->honorAttribute = $defaults['id']['honor'];
        $this->infamyAttribute = $defaults['id']['infamy'];
        $this->moneyAttribute = $defaults['id']['money'];
        $this->rationsAttribute = $defaults['id']['rations'];
        $this->resilienceAttribute = $defaults['id']['resilience'];
        $this->sanityAttribute = $defaults['id']['sanity'];
        $this->speedAttribute = $defaults['id']['speed'];
        $this->staminaAttribute = $defaults['id']['stamina'];
        $this->toleranceAttribute = $defaults['id']['tolerance'];
        $this->traumaAttribute = $defaults['id']['trauma'];
        $this->initiativeAttribute = $defaults['id']['initiative'];

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

        $this->siteLink = '/content/world/'.$this->id;
    }

    public function put() {} //todo

    public function view() {
        global $form, $component, $curl;

        $component->returnButton('/content/world');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Has Bionic: '.$this->bionicExists);
        $component->p('Has Supernatural: '.$this->supernaturalExists);

        $component->p('Split Supernatural: '.$this->splitSupernatural);
        $component->p('Split Skill: '.$this->splitSkill);
        $component->p('Split Expertise: '.$this->splitExpertise);
        $component->p('Split Milestone: '.$this->splitMilestone);
        $component->p('Split Relationship: '.$this->splitRelationship);

        $component->p('Maximum Gift: '.$this->maxGift);
        $component->p('Maximum Imperfection: '.$this->maxImperfection);
        $component->p('Maximum Supernatural: '.$this->maxSupernatural);
        $component->p('Maximum Skill: '.$this->maxSkill);
        $component->p('Maximum Expertise: '.$this->maxExpertise);
        $component->p('Maximum Milestone: '.$this->maxMilestone);
        $component->p('Maximum Relationship: '.$this->maxRelationship);

        if($this->isOwner) {

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
                    $form->form([
                        'do' => 'put',
                        'return' => 'content/world',
                        'context' => 'world',
                        'id' => $this->id
                    ]);
                    $form->hidden('calculated',1);
                    $form->submit(false,'This world is ready to play. Press here!');
                }
            } else {
                $component->h1('Lists');
                $component->linkButton($this->siteLink.'/attribute','Attribute');
                $component->linkButton($this->siteLink.'/background','Background');

                if($this->bionicExists) {
                    $component->linkButton($this->siteLink.'/bionic','Bionic');
                }

                $component->linkButton($this->siteLink.'/expertise','Expertise');
                $component->linkButton($this->siteLink.'/gift','Gift');
                $component->linkButton($this->siteLink.'/imperfection','Imperfection');

                if($this->supernaturalExists) {
                    $component->linkButton($this->siteLink.'/manifestation','Manifestation');
                }

                $component->linkButton($this->siteLink.'/milestone','Milestone');
                $component->linkButton($this->siteLink.'/protection','Protection');
                $component->linkButton($this->siteLink.'/skill','Skill');
                $component->linkButton($this->siteLink.'/species','Species');
                $component->linkButton($this->siteLink.'/weapon','Weapon');
            }

        }
    }

    public function delete() {} //todo

    // GET

    public function getAttribute($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/attribute'.$override
            : 'world/id/'.$this->id.'/attribute';

        return $system->getAttribute($get);
    }

    public function getAugmentation($bionic) {
        global $system;

        return $system->getAugmentation('bionic/id/'.$bionic.'/augmentation');
    }

    public function getBionic($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/bionic'.$override
            : 'world/id/'.$this->id.'/bionic';

        return $system->getBionic($get);
    }

    public function getBackground($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/background'.$override
            : 'world/id/'.$this->id.'/background';

        return $system->getBackground($get);
    }

    public function getDoctrine($manifestation = null) {
        global $system;

        $override = isset($manifestation)
            ? '/manifestation/'.$manifestation
            : null;

        return $system->getDoctrine('doctrine'.$override);
    }

    public function getExpertise($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/expertise'.$override
            : 'world/id/'.$this->id.'/expertise';

        return $system->getExpertise($get);
    }

    public function getFocus($manifestation) {
        global $system;

        return $system->getFocus('focus/manifestation/'.$manifestation);
    }

    public function getGift($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/gift'.$override
            : 'world/id/'.$this->id.'/gift';

        return $system->getGift($get);
    }

    public function getImperfection($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/imperfection'.$override
            : 'world/id/'.$this->id.'/imperfection';

        return $system->getImperfection($get);
    }

    public function getIdentity() {
        global $system;

        return $system->getIdentity();
    }

    public function getManifestation() {
        global $system;

        return $system->getManifestation('world/id/'.$this->id.'/manifestation');
    }

    public function getMilestone($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/milestone'.$override
            : 'world/id/'.$this->id.'/milestone';

        return $system->getMilestone($get);
    }

    public function getNature() {
        global $system;

        return $system->getNature();
    }

    public function getProtection($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/protection'.$override
            : 'world/id/'.$this->id.'/protection';

        return $system->getProtection($get);
    }

    public function getSkill($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/skill'.$override
            : 'world/id/'.$this->id.'/skill';

        return $system->getSkill($get);
    }

    public function getSoftware($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/software'.$override
            : 'world/id/'.$this->id.'/software';

        return $system->getSoftware($get);
    }

    public function getSpecies() {
        global $system;

        return $system->getSpecies('world/id/'.$this->id.'/species');
    }

    public function getWeapon($override = null) {
        global $system;

        $get = isset($override)
            ? 'world/id/'.$this->id.'/weapon'.$override
            : 'world/id/'.$this->id.'/weapon';

        return $system->getAttribute($get);
    }

    // POST

    public function postAttribute() {
        global $component, $form, $curl;

        $component->h1('Attribute Defaults');
        $form->form([
            'do' => 'relation--value--post',
            'context' => 'world',
            'context2' => 'attribute',
            'return' => 'content/world',
            'returnafter' => 'attribute',
            'id' => $this->id
        ]);

        $tolerance = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->toleranceAttribute)['data'][0]['value'];
        $stamina = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->staminaAttribute)['data'][0]['value'];
        $resilience = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->resilienceAttribute)['data'][0]['value'];
        $trauma = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->traumaAttribute)['data'][0]['value'];
        $disease = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->diseaseAttribute)['data'][0]['value'];
        $sanity = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->sanityAttribute)['data'][0]['value'];
        $damage = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->damageAttribute)['data'][0]['value'];
        $initiative = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->initiativeAttribute)['data'][0]['value'];
        $speed = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->speedAttribute)['data'][0]['value'];
        $honor = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->honorAttribute)['data'][0]['value'];
        $infamy = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->infamyAttribute)['data'][0]['value'];
        $money = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->moneyAttribute)['data'][0]['value'];
        $ammunition = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->ammunitionAttribute)['data'][0]['value'];
        $rations = $curl->get('world/id/'.$this->id.'/attribute/value/'.$this->rationsAttribute)['data'][0]['value'];

        echo $money;

        $component->h2('Wounds');
        $component->subtitle('This section contains the different kinds of wounds a person can take.');
        $component->wrapStart();
        $form->number(true,'insert_id','Tolerance','Designates the default value for a person\'s resistance against Trauma attacks.',$this->toleranceAttribute,0,96,$tolerance);
        $form->number(true,'insert_id','Stamina','Designates the default value for a person\'s resistance against Diseases and Poison.',$this->staminaAttribute,0,96,$stamina);
        $form->number(true,'insert_id','Resilience','Designates the default value for a person\'s resistance against falling into madness and losing sanity.',$this->resilienceAttribute,0,96,$resilience);
        $form->number(true,'insert_id','Trauma','Designates the default amount of Trauma wounds a person can handle before being incapacitated.',$this->traumaAttribute,0,96,$trauma);
        $form->number(true,'insert_id','Disease','Designates the default amount of Diseases a person can handle before being incapacitated.',$this->diseaseAttribute,0,96,$disease);
        $form->number(true,'insert_id','Sanity','Designates the default amount of Sanity hits a person can handle before being incapacitated.',$this->sanityAttribute,0,96,$sanity);
        $component->wrapEnd();

        $component->h2('Combat');
        $component->subtitle('This section contains the three base attributes for combat.');
        $component->wrapStart();
        $form->number(true,'insert_id','Damage','Default damage bonus you will get to your attacks.',$this->damageAttribute,0,96,$damage);
        $form->number(true,'insert_id','Initiative','Default value for initiative, which handles a person\'s order of fighting.',$this->initiativeAttribute,0,96,$initiative);
        $form->number(true,'insert_id','Speed','Default value for speed which, which handles a person\'s ability to chase down, or avoid chasers.',$this->speedAttribute,0,96,$speed);
        $component->wrapEnd();

        $component->h2('Reputation');
        $component->subtitle('This section contains reputation attributes.');
        $component->wrapStart();
        $form->number(true,'insert_id','Honor','A person\'s positive reputation.',$this->honorAttribute,0,96,$honor);
        $form->number(true,'insert_id','Infamy','A person\'s negative reputation.',$this->infamyAttribute,0,96,$infamy);
        $component->wrapEnd();

        $component->h2('Consumable & Money');
        $component->subtitle('This section contains consumable and financial attributes.');
        $component->wrapStart();
        $form->number(true,'insert_id','Money','Default financial situation.',$this->moneyAttribute,0,96,$money);
        $form->number(true,'insert_id','Ammunition','Default ammunition.',$this->ammunitionAttribute,0,96,$ammunition);
        $form->number(true,'insert_id','Rations','Default daily rations.',$this->rationsAttribute,0,96,$rations);
        $component->wrapEnd();

        $form->submit(false);
    }

    public function postBackground() {
        global $system, $form;

        $idList = $system->idList($this->getBackground());

        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();

        $form->form([
            'do' => 'relation--post',
            'return' => 'content/world',
            'returnafter' => 'background',
            'id' => $this->id,
            'context' => 'world',
            'context2' => 'background'
        ]);

        $system->checkboxList($system->getBackground(), $idList);

        foreach($speciesArray as $species) {
            $list = $system->getBackground('background/species/'.$species->id, $idList);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        if($this->supernaturalExists) {
            foreach($manifestationArray as $manifestation) {
                $list = $system->getBackground('background/manifestation/'.$manifestation->id, $idList);

                if(!$list) continue;

                $system->checkboxList($list, $idList);
            }
        }

        $system->checkboxAll();
        $form->submit();
    }

    public function postBionic() {
        global $system;

        $system->contentSelectList('world', 'bionic', 'post', $this->id, $system->getBionic(), $system->idList($this->getBionic()));
    }

    public function postExpertise() {
        global $system, $form, $component;

        $idList = $system->idList($this->getExpertise());

        $skillArray = $this->getSkill();
        $manifestationArray = $this->getManifestation();

        $form->form([
            'do' => 'relation--post',
            'return' => 'content/world',
            'returnafter' => 'expertise',
            'id' => $this->id,
            'context' => 'world',
            'context2' => 'expertise'
        ]);

        foreach($skillArray as $skill) {
            $list = $system->getExpertise('expertise/skill/'.$skill->id);

            if(!$list) continue;

            $component->h2($skill->name);
            $system->checkboxList($list, $idList);
        }

        if($this->supernaturalExists) {
            foreach($manifestationArray as $manifestation) {
                $list = $system->getExpertise('expertise/manifestation/'.$manifestation->id);

                if(!$list) continue;

                $component->h2($manifestation->name);
                $system->checkboxList($list, $idList);
            }
        }

        $system->checkboxAll();
        $form->submit();
    }

    public function postGift() {
        global $system, $form, $component;

        $idList = $system->idList($this->getGift());

        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();
        $skillArray = $this->getSkill();

        $form->form([
            'do' => 'relation--post',
            'return' => 'content/world',
            'returnafter' => 'gift',
            'id' => $this->id,
            'context' => 'world',
            'context2' => 'gift'
        ]);

        $system->checkboxList($system->getGift(), $idList);

        foreach($skillArray as $skill) {
            $list = $system->getGift('gift/skill/'.$skill->id);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($speciesArray as $species) {
            $list = $system->getGift('gift/species/'.$species->id, $idList);

            if(!$list) continue;

            $component->h2($species->name);
            $system->checkboxList($list, $idList);
        }

        if($this->supernaturalExists) {
            foreach($manifestationArray as $manifestation) {
                $list = $system->getGift('gift/manifestation/'.$manifestation->id, $idList);

                if(!$list) continue;

                $component->h2($manifestation->name);
                $system->checkboxList($list, $idList);
            }
        }

        $system->checkboxAll();
        $form->submit();
    }

    public function postImperfection() {
        global $system, $form, $component;

        $idList = $system->idList($this->getImperfection());

        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();

        $form->form([
            'do' => 'relation--post',
            'return' => 'content/world',
            'returnafter' => 'imperfection',
            'id' => $this->id,
            'context' => 'world',
            'context2' => 'imperfection'
        ]);

        $system->checkboxList($system->getImperfection(), $idList);

        foreach($speciesArray as $species) {
            $list = $system->getImperfection('imperfection/species/'.$species->id, $idList);

            if(!$list) continue;

            $component->h2($species->name);
            $system->checkboxList($list, $idList);
        }

        if($this->supernaturalExists) {
            foreach($manifestationArray as $manifestation) {
                $list = $system->getImperfection('imperfection/manifestation/'.$manifestation->id, $idList);

                if(!$list) continue;

                $component->h2($manifestation->name);
                $system->checkboxList($list, $idList);
            }
        }

        $system->checkboxAll();
        $form->submit();
    }

    public function postManifestation() {
        global $system;

        $system->contentSelectList('world', 'manifestation', 'post', $this->id, $system->getManifestation(), $system->idList($this->getManifestation()));
    }

    public function postMilestone() {
        global $system, $form, $component;

        $idList = $system->idList($this->getGift());

        $backgroundArray = $this->getBackground();
        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();
        $skillArray = $this->getSkill();

        $form->form([
            'do' => 'relation--post',
            'return' => 'content/world',
            'returnafter' => 'milestone',
            'id' => $this->id,
            'context' => 'world',
            'context2' => 'milestone'
        ]);

        $system->checkboxList($system->getMilestone(), $idList);

        foreach($backgroundArray as $background) {
            $list = $system->getMilestone('milestone/background/'.$background->id);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($skillArray as $skill) {
            $list = $system->getMilestone('milestone/skill/'.$skill->id);

            if(!$list) continue;

            $system->checkboxList($list, $idList);
        }

        foreach($speciesArray as $species) {
            $list = $system->getMilestone('milestone/species/'.$species->id, $idList);

            if(!$list) continue;

            $component->h2($species->name);
            $system->checkboxList($list, $idList);
        }

        if($this->supernaturalExists) {
            foreach($manifestationArray as $manifestation) {
                $list = $system->getMilestone('milestone/manifestation/'.$manifestation->id, $idList);

                if(!$list) continue;

                $component->h2($manifestation->name);
                $system->checkboxList($list, $idList);
            }
        }

        $system->checkboxAll();
        $form->submit();
    }

    public function postProtection() {
        global $system;

        $system->contentSelectList('world', 'protection', 'post', $this->id, $system->getProtection(), $system->idList($this->getProtection()));
    }

    public function postSkill() {
        global $system;

        $system->contentSelectList('world', 'skill', 'post', $this->id, $system->getSkill(), $system->idList($this->getSkill()));
    }

    public function postSoftware() {
        global $system;

        $system->contentSelectList('world', 'software', 'post', $this->id, $system->getSoftware(), $system->idList($this->getSoftware()));
    }

    public function postSpecies() {
        global $system;

        $system->contentSelectList('world', 'species', 'post', $this->id, $system->getSpecies('species/playable'), $system->idList($this->getSpecies()));
    }

    public function postWeapon() {
        global $system;

        $system->contentSelectList('world', 'weapon', 'post', $this->id, $system->getWeapon(), $system->idList($this->getWeapon()));
    }

    // DELETE

    public function deleteBionic() {
        global $system;

        $system->contentSelectList('world', 'bionic', 'delete', $this->id, $this->getBionic());
    }

    public function deleteBackground() {
        global $system;

        $system->contentSelectList('world', 'background', 'delete', $this->id, $this->getBackground());
    }

    public function deleteExpertise() {
        global $system;

        $system->contentSelectList('world', 'expertise', 'delete', $this->id, $this->getExpertise());
    }

    public function deleteGift() {
        global $system;

        $system->contentSelectList('world', 'gift', 'delete', $this->id, $this->getGift());
    }

    public function deleteImperfection() {
        global $system;

        $system->contentSelectList('world', 'imperfection', 'delete', $this->id, $this->getImperfection());
    }

    public function deleteManifestation() {
        global $system;

        $system->contentSelectList('world', 'manifestation', 'delete', $this->id, $this->getManifestation());
    }

    public function deleteMilestone() {
        global $system;

        $system->contentSelectList('world', 'milestone', 'delete', $this->id, $this->getMilestone());
    }

    public function deleteProtection() {
        global $system;

        $system->contentSelectList('world', 'protection', 'delete', $this->id, $this->getProtection());
    }

    public function deleteSkill() {
        global $system;

        $system->contentSelectList('world', 'skill', 'delete', $this->id, $this->getSkill());
    }

    public function deleteSoftware() {
        global $system;

        $system->contentSelectList('world', 'software', 'delete', $this->id, $this->getSoftware());
    }

    public function deleteSpecies() {
        global $system;

        $system->contentSelectList('world', 'species', 'delete', $this->id, $this->getSpecies());
    }

    public function deleteWeapon() {
        global $system;

        $system->contentSelectList('world', 'weapon', 'delete', $this->id, $this->getWeapon());
    }

    // LIST

    public function listBackground() {
        global $system;

        $system->listRelation($this->getBackground(), 'background', $this->siteLink);
    }

    public function listBionic() {
        global $system;

        $system->listRelation($this->getBionic(), 'bionic', $this->siteLink);
    }

    public function listExpertise() {
        global $component;

        $skillArray = $this->getSkill();
        $manifestationArray = $this->getManifestation();

        if($skillArray[0]) {
            foreach($skillArray as $skill) {
                $list = $this->getExpertise('/skill/'.$skill->id);

                if(!$list) continue;

                $component->h2($skill->name);

                foreach($list as $item) {
                    $component->listItem($item->name, $item->description, $item->icon);
                }
            }
        }

        if($manifestationArray[0]) {
            foreach($manifestationArray as $manifestation) {
                $list = $this->getExpertise('/manifestation/'.$manifestation->id);

                if(!$list) continue;

                $component->h2($manifestation->name);

                foreach($list as $item) {
                    $component->listItem($item->name, $item->description, $item->icon);
                }
            }
        }

        $component->linkButton($this->siteLink.'/expertise/add','Add');
        $component->linkButton($this->siteLink.'/expertise/delete','Delete',true);
    }

    public function listGift() {
        global $system;

        $system->listRelation($this->getGift(), 'gift', $this->siteLink);
    }

    public function listImperfection() {
        global $system;

        $system->listRelation($this->getImperfection(), 'imperfection', $this->siteLink);
    }

    public function listManifestation() {
        global $system;

        $system->listRelation($this->getManifestation(), 'manifestation', $this->siteLink);
    }

    public function listMilestone() {
        global $system;

        $system->listRelation($this->getMilestone(), 'milestone', $this->siteLink);
    }

    public function listProtection() {
        global $system;

        $system->listRelation($this->getProtection(), 'protection', $this->siteLink);
    }

    public function listSkill() {
        global $system;

        $system->listRelation($this->getSkill(), 'skill', $this->siteLink);
    }

    public function listSoftware() {
        global $system;

        $system->listRelation($this->getSoftware(), 'software', $this->siteLink);
    }

    public function listSpecies() {
        global $system;

        $system->listRelation($this->getSpecies(), 'species', $this->siteLink);
    }

    public function listWeapon() {
        global $system;

        $system->listRelation($this->getWeapon(), 'weapon', $this->siteLink);
    }
}