<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-23
 * Time: 14:14
 */
class System {
    public function __construct() {}


    public function createPerson($person = null, $world = null, $species = null) {
        global $component;

        if(!isset($person) && !isset($world) && !isset($species)) {
            $component->title('Create');
            $component->h1('Select World');
            $component->subtitle('You will need to select a world in which your character exists.');

            $this->person_selectWorld();

        } else if(!isset($person) && isset($world) && !isset($species)) {
            $component->title('Create');
            $component->h1('Select Species');

            $this->person_selectSpecies($world);

        } else if(!isset($person) && isset($world) && isset($species)) {
            $component->title('Create');
            $component->h1('Nickname, Age, and Occupation');

            $this->person_make($world, $species);

        } else if(isset($person)) {
            $component->title($person->nickname);

            if(!isset($person->background)) {
                $component->linkAction('#','Bookmark this Person','The framework for your character has been created in our database. Time to bookmark so you can return whenever you want!','/img/link-bookmark-w.png',true,'sw-js-bookmark');
                
                $component->h1('Background');
                $component->subtitle('You will select <span>1</span> background from which you will gain a few attribute and skill changes.');

                $this->person_select(
                    $person,
                    $person->world->getBackground($person->species->id),
                    'background_id',
                    'Background',
                    'background'
                );

            } else if($person->isSupernatural && !isset($person->manifestation)) {
                $component->h1('Manifestation');

                $this->person_select(
                    $person,
                    $person->world->getManifestation(),
                    'manifestation_id',
                    null,
                    'manifestation'
                );

            } else if($person->isSupernatural && isset($person->manifestation) && !isset($person->focus)) {
                $component->h1('Focus');

                $this->person_select(
                    $person,
                    $person->world->getFocus($person->manifestation->id),
                    'focus_id',
                    null,
                    'focus'
                );

            } else if($person->isSupernatural && isset($person->manifestation) && isset($person->focus) && $person->getExpertise($person->manifestation->expertiseType) == null) {
                $component->h1('Doctrine');

                $this->person_select(
                    $person,
                    $person->world->getExpertise($person->manifestation->expertiseType),
                    'expertise_id',
                    null,
                    'manifestation--expertise'
                );

            } else if($person->isSupernatural && $person->pointPower > 0) {
                $component->h1('Potential');

                $this->person_rollAttribute(
                    $person,
                    $person->manifestation->powerAttribute,
                    $person->pointPower,
                    'manifestation--power'
                );

            } else if($person->pointMoney > 0) {
                $component->h1('Money');
                $component->subtitle('You will be rolling <span class="sw-js-points-text">'.$person->pointMoney.'</span> dice to either improve or impair your financial status.');

                $this->person_rollAttribute($person,$person->world->money,$person->pointMoney,'attribute--money');

            } else if(!isset($person->nature)) {
                $component->h1('Nature');

                $this->person_select(
                    $person,
                    $person->world->getNature(),
                    'nature_id',
                    null,
                    'nature'
                );

            } else if(!isset($person->identity)) {
                $component->h1('Identity');

                $this->person_select(
                    $person,
                    $person->world->getIdentity(),
                    'identity_id',
                    null,
                    'identity'
                );

            } else if($person->pointGift > 0) {
                $component->h1('Gift');
                $component->subtitle('Get <span>'.$person->pointGift.'</span> gift that sets your character aside from others.');

                $this->person_selectCharacteristic($person, 1, $person->pointGift);

            } else if($person->pointImperfection > 0) {
                $component->h1('Imperfection');
                $component->subtitle('Get <span>'.$person->pointImperfection.'</span> imperfection that sets your character aside from others.');

                $this->person_selectCharacteristic($person, 0, $person->pointImperfection);

            } else if($person->pointMilestone > 0) {
                $component->h1('Milestone');
                $component->subtitle('Get <span>'.$person->pointMilestone.'</span> milestones that have happened to your character.');

                $this->person_selectMilestone($person, $person->pointMilestone);

            } else if($person->pointSkill > 0) {
                $component->h1('Skill');
                $component->subtitle('You will be using <span>'.$person->pointSkill.'</span> points to purchase Skills. Try to get at least 1 above 4, and a couple above 2.');

                $this->person_purchaseSkill($person, $person->pointSkill);

            } else if($person->pointExpertise > 0) {
                $component->h1('Expertise');

                $exp = $person->getAttribute(null, $person->world->experience)[0];
                $pts = $person->pointExpertise;

                $this->person_purchaseExpertise($person, intval($exp->value + $pts));

            } else if($person->isSupernatural && $person->pointSupernatural > 0) {
                $component->h1($person->manifestation->name);

                $exp = $person->getAttribute(null, $person->world->experience)[0];
                $pts = $person->pointSupernatural;

                $this->person_purchaseDiscipline($person, intval($exp->value + $pts));

            } else if(!isset($person->firstname) || !isset($person->surname) || !isset($person->gender)) {
                $component->h1('Name & Details');

                $this->person_describe($person);

            }
        }
    }

    public function createStory($story = null, $world = null) {
        global $component;

        if(!isset($story) && !isset($world)) {
            $component->title('Create');
            $component->h1('Select World');
            $component->subtitle('You will need to select a world in which your story takes place. It will also enable the system to understand what persons you can add.');

            $this->story_selectWorld();

        } else if(!isset($person) && isset($world)) {
            $component->title('Create');
            $component->h1('Story Details');

            $this->story_make($world);
        }
    }

    public function createWorld($world = null) {
        if(!isset($world)) {
            echo('<h2>Create World</h2>');
            $this->world_make();

        } else {
            if($world->splitSupernatural == 0 && $world->splitSkill == 0 && $world->splitExpertise == 0 && $world->splitMilestone == 0 && $world->splitRelationship == 0) {
                echo(
                    '<h2>Manage Age Split</h2>'.
                    '<p>When creating a new person, some features are calculated based on: [age/world_modifier]. It is time to set this modifier. We have given you example values from our usual worlds.</p>'
                );
                $this->world_makeSplit($world);

            } else if($world->maxGift == 0 && $world->maxImperfection == 0 && $world->maxSupernatural == 0 && $world->maxSkill == 0 && $world->maxExpertise == 0 && $world->maxMilestone == 0 && $world->maxRelationship == 0) {
                echo(
                    '<h2>Manage Maximum</h2>'.
                    '<p>After calculating the agesplit, we also take into account that you may want to set a maximum value. It is time to set this value. We have given you example values from our usual worlds. There are hard limitations here for data weight purposes.</p>'
                );
                $this->world_makeMaximum($world);

            } else if(count($world->getSpecies()) == 0) {
                echo(
                    '<h2>Species</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'species');

            } else if(count($world->getBackground()) == 0) {
                echo(
                    '<h2>Background</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'background');

            } else if(count($world->getNature()) == 0) {
                echo(
                    '<h2>Nature</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'nature');

            } else if(count($world->getIdentity()) == 0) {
                echo(
                    '<h2>Identity</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'identity');

            } else if(count($world->getAttribute()) == 0) {
                echo(
                    '<h2>Defaults</h2>'.
                    '<p></p>'
                );
                $this->world_makeDefaultAttribute($world);

            } else if(count($world->getAttribute($world->attributeSkill)) == 0) {
                echo(
                    '<h2>Skills</h2>'.
                    '<p></p>'
                );
                $this->world_checkSkill($world);

            } else if(count($world->getExpertise($world->expertiseAttribute)) == 0) {
                echo(
                    '<h2>Attribute Expertise</h2>'.
                    '<p></p>'
                );
                $this->world_checkExpertise($world, $world->expertiseAttribute);

            } else if(count($world->getExpertise($world->expertiseDice)) == 0) {
                echo(
                    '<h2>Dice Expertise</h2>'.
                    '<p></p>'
                );
                $this->world_checkExpertise($world, $world->expertiseDice);

            } else if($world->existsSupernatural && $world->supernaturalName == null) {
                echo(
                    '<h2>Supernatural Name</h2>'.
                    '<p>What is the formal name of supernatural people in your world?</p>'
                );
                $this->world_makeSupernaturalName($world);

            } else if($world->existsSupernatural && count($world->getManifestation()) == 0) {
                echo(
                    '<h2>Manifestation</h2>'.
                    '<p></p>'
                );
                $this->world_checkManifestation($world, 'manifestation');

            } else if(count($world->getCharacteristic(1)) == 0) {
                echo(
                    '<h2>Gift</h2>'.
                    '<p></p>'
                );
                $this->world_checkCharacteristic($world, 1);

            } else if(count($world->getCharacteristic(0)) == 0) {
                echo(
                    '<h2>Imperfection</h2>'.
                    '<p></p>'
                );
                $this->world_checkCharacteristic($world, 0);

            } else if(count($world->getMilestone()) == 0) {
                echo(
                    '<h2>Milestone</h2>'.
                    '<p></p>'
                );
                $this->world_checkMilestone($world);

            } else if(count($world->getWeapon()) == 0) {
                echo(
                    '<h2>Weapon</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'weapon');

            } else if(count($world->getProtection()) == 0) {
                echo(
                    '<h2>Protection</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'protection');

            } else if($world->existsBionic && count($world->getBionic()) == 0) {
                echo(
                    '<h2>Bionic</h2>'.
                    '<p></p>'
                );
                $this->world_checklist($world, 'bionic');

            } else if($world->existsAugmentation && count($world->getAugmentation()) == 0) {
                echo(
                    '<h2>Augmentation</h2>'.
                    '<p></p>'
                );
                $this->world_checkAugmentation($world);

            }
        }
    }


    function idList($list) {
        $idList = null;

        if(count($list) != null) {
            foreach($list as $item) {
                $idList[] = $item->id;
            }
        }

        return $idList;
    }

    function checkboxList($itemList, $idList = null) {
        global $form;

        echo('<section class="sw-l-padding">');

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if(!$idList || !in_array($item->id, $idList)) {
                    $form->checkbox($item->name, $item->description, $item->id);
                }
            }
        }

        echo('</section>');
    }

    function checkboxAll() {
        echo(
            '<div class="sw-js-checkbox-item sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<label for="post--checkall">'.
            '<input class="sw-js-checkbox-all sw-is-hidden" type="checkbox" name="post--checkall" id="post--checkall" value="0"/>'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-js-checkbox-true sw-c-list__select sw-is-hidden"><img src="/img/check-true.png"/></div>'.
            '<div class="sw-js-checkbox-false sw-c-list__select"><img src="/img/check-false.png"/></div>'.
            '<div class="sw-c-list__title">Check All</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    function radioList($tableName, $itemList, $idList = null, $currentId = null) {
        global $form;

        echo('<section class="sw-l-padding">');

        if(isset($itemList)) {
            foreach($itemList as $item) {
                $selected = false;

                if(!$idList || !in_array($item->id, $idList)) {
                    if($item->id == $currentId) {
                        $selected = true;
                    }
                    $form->radio($tableName, $item->name, $item->description, $item->id, $selected);
                }
            }
        }

        echo('</section>');
    }


    function person_selectWorld() {
        global $form, $curl, $user, $component;

        $list = null;

        if($user) {
            $userList = $curl->get('user-world/id/'.$user->id.'/calculated');

            if(isset($userList['data'])) {
                foreach($userList['data'] as $item) {
                    $list[] = new World($item['world_id']);
                }
            }
        }

        $worldList = $curl->get('world')['data']; // todo remove template

        foreach($worldList as $item) {
            $list[] = new World(null, null, $item);
        }

        $form->formStart(['action' => 'play/person/new']);
        $this->radioList('world_id',$list);
        $form->formEnd();
    }

    function person_selectSpecies($world) {
        global $form, $component;

        $list = $world->getSpecies();

        $form->formStart(['action' => 'play/person/new']);
        $this->radioList('species_id', $list);
        $form->hidden('world_id', $world->id);
        $form->formEnd();
    }

    function person_make($world, $species) {
        global $form, $user, $component;

        $userid = $user && isset($user->id)
            ? $user->id
            : null;

        $component->wrapStart();
        $form->formStart([
            'do' => 'person--add',
            'user' => $userid,
            'return' => 'play/person/id'
        ]);
        $form->hidden('world_id', $world->id);
        $form->hidden('species_id', $species->id);
        $form->varchar(true, 'nickname', 'Nickname', 'The nickname of your character will be your primary simple identifier.');
        $form->number(true, 'age', 'Age', 'Deciding age is important, as it determines many important things for the creation of your character. While you can change age at a later stage, the system will not take that into account after creation.', null, 5, $species->maxAge);
        $form->varchar(true, 'occupation', 'Occupation', 'The occupation of your character is your secondary simple identifier.');

        if($world->existsSupernatural) {
            $form->pick(true, 'supernatural', $world->supernaturalName, 'In this world, your character can have supernatural ('.$world->supernaturalName.') abilities. Choose yes if this is the case.');
        } else {
            $form->hidden('supernatural', 0);
        }

        $form->formEnd();
        $component->wrapEnd();
    }

    function person_describe($person) {
        global $form, $component;

        $component->wrapStart();
        $form->formStart([
            'do' => 'person--describe',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);
        $form->varchar(true, 'firstname', 'First Name');
        $form->varchar(true, 'surname', 'Surname');
        $form->varchar(true, 'gender', 'Gender');
        $form->text(false, 'description', 'Description', 'Describe your character.');
        $form->text(false, 'personality', 'Personality', 'Describe your character\'s personality. Behaviour, Mannerisms, etc.');
        $form->text(false, 'appearance', 'Appearance', 'Describe your character\'s appearance.');
        $form->formEnd();
        $component->wrapEnd();
    }

    public function person_rollAttribute($person, $attributeId, $points, $postDo) {
        global $curl, $form, $component;

        $attribute = $curl->get('attribute/id/'.$attributeId)['data'][0];

        $component->wrapStart();
        $form->formStart([
            'do' => 'person--'.$postDo,
            'id' => $person->id,
            'secret' => $person->secret,
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

    public function person_select($person, $list, $listTableName, $withRoll = null, $do = null, $value = null) {
        global $form;

        $do = isset($do)
            ? $do
            : 'edit';

        $form->formStart([
            'do' => 'person--'.$do,
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        if(isset($withRoll)) {
            $form->randomRadio($withRoll);
            $form->viewStart();
        }

        $this->radioList($listTableName,$list);

        if(isset($withRoll)) {
            $form->viewEnd();
        }
        $form->formEnd();
    }

    public function person_selectCharacteristic($person, $gift, $points = null) {
        global $form;

        $list = null;

        if($person->isSupernatural) {
            $list = $person->world->getCharacteristic($gift, $person->species->id, $person->manifestation->id);
        } else {
            $list = $person->world->getCharacteristic($gift, $person->species->id);
        }

        $idList = $this->idList($person->getCharacteristic());

        $text = $gift == 1
            ? 'gift'
            : 'imperfection';

        $form->formStart([
            'do' => 'person--characteristic--'.$text,
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);
        $form->points($points);
        $form->randomRadio('characteristic');
        $form->viewStart();
        $this->radioList('characteristic_id',$list, $idList);
        $form->viewEnd();
        $form->formEnd();
    }

    public function person_selectMilestone($person, $points) {
        global $form;

        $list = null;

        if($person->isSupernatural) {
            $list = $person->world->getMilestone($person->background->id, $person->species->id, $person->manifestation->id);
        } else {
            $list = $person->world->getMilestone($person->background->id, $person->species->id);
        }


        $idList = $this->idList($person->getMilestone());

        $form->formStart([
            'do' => 'person--milestone',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);
        $form->points($points);
        $form->randomRadio('milestone');
        $form->viewStart();
        $this->radioList('milestone_id',$list, $idList);
        $form->viewEnd();
        $form->formEnd();
    }

    public function person_purchaseSkill($person, $points, $cheat = false) {
        global $form, $component;

        $currentList = $person->getAttribute($person->world->attributeSkill);

        $form->formStart([
            'do' => 'person--attribute--skill',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($points);
            $form->hidden('experience', $person->world->experience, 'post');
        }

        foreach($currentList as $current) {
            $form->purchase('attribute_id', $current->name, $current->description, $current->icon, $current->id, 0, $current->maximum, $current->value);
        }

        $form->formEnd();
    }

    public function person_purchaseExpertise($person, $points, $cheat = false) {
        global $form, $curl;

        $typeList = $curl->get('expertisetype')['data'];
        $skillList = $person->getAttribute($person->world->attributeSkill);
        $currentList = $person->getExpertise();
        $idList = [];

        $form->formStart([
            'do' => 'person--expertise',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">9999</span>');
        } else {
            $form->points($points);
            $form->hidden('experience', $person->world->experience, 'post');
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
                    $expertiseList = $person->world->getExpertise($type['id'], $skill->id, $person->species->id);

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

    public function person_purchaseDiscipline($person, $points, $cheat = false) {
        global $curl, $form;

        $supernaturalList = $person->world->getAttribute($person->manifestation->disciplineAttributeType, $person->species->id);
        $expertiseList = $person->getExpertise();
        $currentList = $person->getAttribute($person->manifestation->disciplineAttributeType);
        $idList = [];
        $expList = [];

        $personPower = $curl->get('person-attribute/id/'.$person->id.'/attribute/'.$person->manifestation->powerAttribute)['data'][0]['value'];

        $form->formStart([
            'do' => 'person--manifestation--doctrine',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        if($cheat) {
            echo('<span class="sw-js-points-text sw-is-hidden">999</span>');
        } else {
            $form->points($points);
            $form->hidden('experience', $person->world->experience, 'post');
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

    public function person_checkAugmentation($person, $bionicId) {
        global $form, $component;

        $bionic = $person->getBionic(null,$bionicId)[0];
        $augmentationList = $person->world->getAugmentation($bionicId);
        $idList = $this->idList($person->getAugmentation());

        $component->h2($bionic->name);

        $form->formStart([
            'do' => 'person--augmentation',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id',
            'context' => $bionicId
        ]);

        $this->checkboxList($augmentationList, $idList);
        $this->checkboxAll();
        $form->formEnd();
    }

    public function person_checkBionic($person) {
        global $form;

        $bionicList = $person->world->getBionic();
        $idList = $this->idList($person->getBionic());

        $form->formStart([
            'do' => 'person--bionic',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        $this->checkboxList($bionicList, $idList);

        $this->checkboxAll();
        $form->formEnd();
    }

    public function person_checkProtection($person) {
        global $form, $curl;

        $typeList = $curl->get('protectiontype')['data'];
        $idList = $this->idList($person->getProtection());

        $form->formStart([
            'do' => 'person--protection',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        foreach($typeList as $type) {
            $protectionList = $person->world->getProtection($type['id']);

            echo('<h4>'.$type['name'].'</h4>');

            $this->checkboxList($protectionList, $idList);
        }

        $this->checkboxAll();
        $form->formEnd();
    }

    public function person_checkWeapon($person) {
        global $form;

        $idList = $this->idList($person->getWeapon());
        $weaponList = $person->world->getWeapon();

        $form->formStart([
            'do' => 'person--weapon',
            'id' => $person->id,
            'secret' => $person->secret,
            'return' => 'play/person/id'
        ]);

        $this->checkboxList($weaponList, $idList);
        $this->checkboxAll();
        $form->formEnd(false);
    }


    function story_selectWorld() {
        global $form, $curl, $user;

        $list = null;

        if($user) {
            $userList = $curl->get('user-world/id/'.$user->id.'/calculated');

            if(isset($userList['data'])) {
                foreach($userList['data'] as $item) {
                    $list[] = new World($item['world_id']);
                }
            }
        }

        $worldList = $curl->get('world/template')['data']; // todo remove template

        foreach($worldList as $item) {
            $list[] = new World(null, null, $item);
        }


        $form->formStart(['action' => 'play/story/new']);
        $this->radioList('world_id',$list);
        $form->formEnd();
    }

    function story_make($world) {
        global $form, $user, $component;

        $userid = $user && isset($user->id)
            ? $user->id
            : null;

        $component->wrapStart();
        $form->formStart([
            'do' => 'story--add',
            'user' => $userid,
            'return' => 'play/story/id',
        ]);

        $form->hidden('world_id', $world->id);

        $form->varchar(true, 'name', 'Name', 'The name of your story will make it easier to remember which one it is.');
        $form->text(false, 'description', 'Description', 'Describe your Story. This field can be added to in the future.');
        $form->text(false, 'plot', 'Plot', 'Describe the plot of your Story. This field can be added to in the future.');

        $form->formEnd();
        $component->wrapEnd();
    }


    function world_make() {
        global $form, $curl, $user;

        $userid = $user && isset($user->id)
            ? $user->id
            : null;

        //$attribute = $curl->get('attribute/type/8')['data'];
        $attributetype = $curl->get('attributetype')['data'];
        $expertisetype = $curl->get('expertisetype')['data'];

        $form->genericStart([
            'do' => 'world--post',
            'user' => $userid,
            'return' => 'world'
        ]);

        $form->getVarchar('world', 'name', true);
        $form->getText('world', 'description', false);

        $form->getBool('world', 'bionic', true);
        $form->getBool('world', 'augmentation', true);
        $form->getBool('world', 'software', true);
        $form->getBool('world', 'supernatural', true);

        //$form->getDropdown('world', 'skill_attributetype_id', false, $attributetype, 10);
        $form->getHidden('world', 'skill_attributetype_id', 10);

        $form->getDropdown('world', 'attribute_expertisetype_id', false, $expertisetype, 1);
        $form->getDropdown('world', 'dice_expertisetype_id', false, $expertisetype, 2);

        //$form->getDropdown('world', 'money_attribute_id', true, $attribute);
        $form->getHidden('world', 'money_attribute_id', 19);

        $form->genericEnd();
    }

    function world_checklist($world, $thing) {
        global $form, $curl;

        $checkList = null;
        $list = $curl->get($thing)['data'];

        switch($thing)
        {
            case 'species':
                foreach($list as $item) {
                    $checkList[] = new Species(null, $item);
                }
                break;

            case 'background':
                foreach($list as $item) {
                    $checkList[] = new Background(null, $item);
                }
                break;

            case 'nature':
                foreach($list as $item) {
                    $checkList[] = new Nature(null, $item);
                }
                break;

            case 'identity':
                foreach($list as $item) {
                    $checkList[] = new Identity(null, $item);
                }
                break;

            case 'focus':
                foreach($list as $item) {
                    $checkList[] = new Focus(null, $item);
                }
                break;

            case 'weapon':
                foreach($list as $item) {
                    $checkList[] = new Weapon(null, $item);
                }
                break;

            case 'protection':
                foreach($list as $item) {
                    $checkList[] = new Protection(null, $item);
                }
                break;

            case 'bionic':
                foreach($list as $item) {
                    $checkList[] = new Bionic(null, $item);
                }
                break;
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', $thing);

        $this->checkboxList($checkList, null, $thing);

        $form->genericEnd(true);
    }

    function world_makeSupernaturalName($world) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--put');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $form->getVarchar('world', 'supernatural_name', true);

        $form->genericEnd();
    }

    function world_makeSplit($world) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--put');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        if($world->existsSupernatural) {
            $form->getNumber('world', 'split_supernatural', true, 1, null, 4);
        } else {
            $form->getHidden('world', 'split_supernatural', 4);
        }

        $form->getNumber('world', 'split_supernatural', true, 1, null, 4);
        $form->getNumber('world', 'split_skill', true, 1, null, 1);
        $form->getNumber('world', 'split_expertise', true, 1, null, 4);
        $form->getNumber('world', 'split_milestone', true, 1, null, 8);
        $form->getNumber('world', 'split_relationship', true, 1, null, 8);

        $form->genericEnd(false);
    }

    function world_makeMaximum($world) {
        global $form;

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--put');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $form->getNumber('world', 'max_characteristic_gift', true, 1, 20, 1);
        $form->getNumber('world', 'max_characteristic_imperfection', true, 1, 20, 1);

        if($world->existsSupernatural) {
            $form->getNumber('world', 'max_supernatural', true, 1, 90, 12);
        } else {
            $form->getHidden('world', 'max_supernatural', 12);
        }

        $form->getNumber('world', 'max_skill', true, 1, 90, 32);
        $form->getNumber('world', 'max_expertise', true, 1, 90, 12);
        $form->getNumber('world', 'max_milestone', true, 1, 20, 8);
        $form->getNumber('world', 'max_relationship', true, 1, 20, 8);
        $form->genericEnd(false);
    }

    public function world_makeDefaultAttribute($world) {
        global $curl, $form;

        $bodyList = $curl->get('attribute/type/1')['data'];
        $combatList = $curl->get('attribute/type/2')['data'];
        $woundList = $curl->get('attribute/type/5')['data'];

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--default');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        foreach($bodyList as $attribute) {
            $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, null, 8);
        }

        foreach($combatList as $attribute) {
            $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, null, 0);
        }

        foreach($woundList as $attribute) {
            $form->number(true, 'attribute_id', $attribute['name'], $attribute['description'], $attribute['id'], null, null, 2);
        }

        $form->genericEnd(false);
    }

    public function world_checkSkill($world) {
        global $curl, $form;

        $idList = null;
        $speciesList = $world->getSpecies();
        $skillList = $curl->get('attribute/type/'.$world->attributeSkill)['data'];
        $list = null;

        foreach($speciesList as $species) {
            $idList[] = $species->id;
        }

        foreach($skillList as $skill) {
            if(in_array($skill['species_id'], $idList) || $skill['species_id'] == null) {
                $list[] = new Attribute(null, $skill);
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--skill');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $this->checkboxList($list, null, 'attribute');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkExpertise($world, $type) {
        global $curl, $form;

        $idList = null;
        $speciesList = $world->getSpecies();
        $expertiseList = $curl->get('expertise/type/'.$type)['data'];
        $list = null;

        foreach($speciesList as $species) {
            $idList[] = $species->id;
        }

        foreach($expertiseList as $item) {
            if(in_array($item['species_id'], $idList) || $item['species_id'] == null) {
                $list[] = new Expertise(null, $item);
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', 'expertise');

        $this->checkboxList($list, null, 'expertise');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkManifestation($world) {
        global $form, $curl;

        $checkList = null;
        $list = $curl->get('manifestation')['data'];

        foreach($list as $item) {
            $checkList[] = new Manifestation(null, $item);
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--manifestation');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $this->checkboxList($checkList, null, 'manifestation');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkCharacteristic($world, $type) {
        global $curl, $form;

        $speciesIdList = null;
        $manifestationIdList = null;

        $speciesList = $world->getSpecies();
        $manifestationList = $world->getManifestation();

        $characteristicList = $curl->get('characteristic/gift/'.$type)['data'];
        $list = null;

        foreach($speciesList as $item) {
            $speciesIdList[] = $item->id;
        }

        foreach($manifestationList as $item) {
            $manifestationIdList[] = $item->id;
        }

        foreach($characteristicList as $item) {
            if(in_array($item['species_id'], $speciesIdList) || $item['species_id'] == null) {
                if(in_array($item['manifestation_id'], $manifestationIdList) || $item['manifestation_id'] == null) {
                    $list[] = new Characteristic(null, $item);
                }
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', 'characteristic');

        $this->checkboxList($list, null, 'characteristic');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkMilestone($world) {
        global $curl, $form;

        $speciesList = $world->getSpecies();
        $speciesIdList = null;

        $manifestationList = $world->getManifestation();
        $manifestationIdList = null;

        $attributeList = $world->getAttribute();
        $attributeIdList = null;

        $milestoneList = $curl->get('milestone')['data'];
        $list = null;

        foreach($speciesList as $item) {
            $speciesIdList[] = $item->id;
        }

        foreach($manifestationList as $item) {
            $manifestationIdList[] = $item->id;
        }

        foreach($attributeList as $item) {
            $attributeIdList[] = $item->id;
        }

        foreach($milestoneList as $item) {
            if(
                in_array($item['species_id'], $speciesIdList) ||
                in_array($item['manifestation_id'], $manifestationIdList) ||
                in_array($item['attribute_id'], $attributeIdList) ||
                $item['species_id'] == null ||
                $item['manifestation_id'] == null ||
                $item['attribute_id'] == null
            ) {
                $milestone = new Milestone(null, $item);

                if(isset($milestone->backgroundId)) {
                    $milestone->name = $milestone->name.' ('.$milestone->backgroundName.')';
                }

                if(isset($milestone->speciesId)) {
                    $milestone->name = $milestone->name.' ('.$milestone->speciesName.')';
                }

                if(isset($milestone->manifestationId)) {
                    $milestone->name = $milestone->name.' ('.$milestone->manifestationName.')';
                }

                $list[] = $milestone;
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--has');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);
        $form->getHidden('post', 'thing', 'milestone');

        $this->checkboxList($list, null, 'milestone');
        $this->checkboxAll();

        $form->genericEnd(true);
    }

    public function world_checkAugmentation($world) {
        global $curl, $form;

        $idList = null;
        $bionicList = $world->getBionic();
        $augmentationList = $curl->get('augmentation')['data'];
        $list = null;

        foreach($bionicList as $item) {
            $idList[] = $item->id;
        }

        foreach($augmentationList as $aug) {
            if(in_array($aug['bionic_id'], $idList)) {
                $augmentation = new Augmentation(null, $aug);

                $augmentation->name = $augmentation->name.' ('.$augmentation->bionicName.')';

                $list[] = $augmentation;
            }
        }

        $form->genericStart();
        $form->getHidden('post', 'return', 'world');
        $form->getHidden('post', 'do', 'world--augmentation');
        $form->getHidden('post', 'id', $world->id);
        $form->getHidden('post', 'hash', $world->hash);

        $this->checkboxList($list, null, 'augmentation');
        $this->checkboxAll();

        $form->genericEnd(true);
    }
}
