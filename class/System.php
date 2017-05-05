<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-23
 * Time: 14:14
 */
class System {

    public function __construct() {}

    // GET

    public function getAttribute($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'attribute'.$override
            : 'attribute';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Attribute(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAugmentation($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'augmentation'.$override
            : 'augmentation';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Augmentation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getBionic($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'bionic'.$override
            : 'bionic';

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
            ? 'background'.$override
            : 'background';

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
            ? 'doctrine'.$override
            : 'doctrine';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Doctrine(null, $array);
            }
        }

        return $arrayList;
    }

    public function getGift($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'gift'.$override
            : 'gift';

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
            ? 'imperfection'.$override
            : 'imperfection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Imperfection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getExpertise($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'expertise'.$override
            : 'expertise';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Expertise(null, $array);
            }
        }

        return $arrayList;
    }

    public function getFocus($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'focus'.$override
            : 'focus';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Focus(null, $array);
            }
        }

        return $arrayList;
    }

    public function getIdentity($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'identity'.$override
            : 'identity';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Identity(null, $array);
            }
        }

        return $arrayList;
    }

    public function getManifestation($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'manifestation'.$override
            : 'manifestation';

        $result = $curl->get($get);

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
            ? 'milestone'.$override
            : 'milestone';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Milestone(null, $array);
            }
        }

        return $arrayList;
    }

    public function getNature($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'nature'.$override
            : 'nature';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Nature(null, $array);
            }
        }

        return $arrayList;
    }

    public function getProtection($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'protection'.$override
            : 'protection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Protection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSpecies($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'species'.$override
            : 'species';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Species(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSkill($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'skill'.$override
            : 'skill';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Skill(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWeapon($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'weapon'.$override
            : 'weapon';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Weapon(null, $array);
            }
        }

        return $arrayList;
    }

    // CREATE

    public function createPerson($world = null, $species = null) {
        global $component, $form;

        if(!isset($world) && !isset($species)) {
            $component->title('Create');
            $component->h1('Select World');
            $component->subtitle('You will need to select a world in which your character exists.');

            $this->selectWorld('play/person/new');

        } else if(isset($world) && !isset($species)) {
            $component->title('Create');
            $component->h1('Select Species');

            $this->selectSpecies('play/person/new', $world);

        } else if(isset($world) && isset($species)) {
            $component->title('Create');
            $component->h1('Nickname, Age, and Occupation');

            $component->wrapStart();
            $form->formStart([
                'do' => 'person--post',
                'return' => 'play/person/id'
            ]);
            $form->hidden('world_id', $world->id);
            $form->hidden('species_id', $species->id);
            $form->varchar(true, 'nickname', 'Nickname', 'The nickname of your character will be your primary simple identifier.');
            $form->number(true, 'age', 'Age', 'Deciding age is important, as it determines many important things for the creation of your character. While you can change age at a later stage, the system will not take that into account after creation.', null, 5, $species->maxAge);
            $form->varchar(true, 'occupation', 'Occupation', 'The occupation of your character is your secondary simple identifier.');

            if($world->supernaturalExists) {
                $form->pick(true, 'supernatural', $world->supernaturalName, 'In this world, your character can have supernatural ('.$world->supernaturalName.') abilities. Choose yes if this is the case.');
            } else {
                $form->hidden('supernatural', 0);
            }

            $form->formEnd();
            $component->wrapEnd();
        }
    }

    public function createStory($world = null) {
        global $component, $form;

        if(!isset($world)) {
            $component->title('Create');
            $component->h1('Select World');
            $component->subtitle('You will need to select a world in which your story takes place. It will also enable the system to understand what persons you can add.');

            $this->selectWorld('play/story/new');

        } else {
            $component->title('Create');
            $component->h1('Story Details');

            $component->wrapStart();
            $form->formStart([
                'do' => 'story--add',
                'return' => 'play/story/id',
            ]);

            $form->hidden('world_id', $world->id);

            $form->varchar(true, 'name', 'Name', 'The name of your story will make it easier to remember which one it is.');
            $form->text(false, 'description', 'Description', 'Describe your Story. This field can be added to in the future.');
            $form->text(false, 'plot', 'Plot', 'Describe the plot of your Story. This field can be added to in the future.');

            $form->formEnd();
            $component->wrapEnd();
        }
    }

    public function createWorld() {
        global $component, $form;

        $component->title('Create World');

        $form->formStart([
            'do' => 'world--post',
            'return' => 'content/world/id'
        ]);
        $component->h2('Basic Information');
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $component->wrapEnd();

        $component->h2('Existance');
        $component->subtitle('Which of these will exist in your world?');
        $component->wrapStart();
        $form->pick(true,'bionic','Bionic');
        $form->pick(true,'augmentation','Augmentation');
        $form->pick(true,'software','Software');
        $form->pick(true,'supernatural','Supernatural');
        $component->wrapEnd();

        $component->h2('Split Values');
        $component->subtitle('During person/character creation, a person will split age with a value to receive points. With what value?');
        $component->wrapStart();
        $form->number(false,'split_supernatural','Split Supernatural','',null,1,128,4);
        $form->number(false,'split_skill','Split Skill','',null,1,128,1);
        $form->number(false,'split_expertise','Split Expertise','',null,1,128,4);
        $form->number(false,'split_milestone','Split Milestone','',null,1,12,8);
        $form->number(false,'split_relationship','Split Relationship','',null,1,12,8);
        $component->wrapEnd();

        $component->h2('Maximum Values');
        $component->subtitle('During person/character creation, which is the maximum of points/items they are able to receive?');
        $component->wrapStart();
        $form->number(false,'max_gift','Maximum Gift','',null,1,12,1);
        $form->number(false,'max_imperfection','Maximum Imperfection','',null,1,12,1);
        $form->number(false,'max_supernatural','Maximum Supernatural','',null,1,128,12);
        $form->number(false,'max_skill','Maximum Skill','',null,1,128,32);
        $form->number(false,'max_expertise','Maximum Expertise','',null,1,128,12);
        $form->number(false,'max_milestone','Maximum Milestone','',null,1,12,6);
        $form->number(false,'max_relationship','Maximum Relationship','',null,1,12,4);
        $component->wrapEnd();

        $form->formEnd();
    }

    // SYSTEM

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

        //echo('<section class="sw-l-padding">');

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if(!$idList || !in_array($item->id, $idList)) {
                    $form->checkbox($item->name, $item->description, $item->id);
                }
            }
        }

        //echo('</section>');
    }

    function checkboxAll() {
        echo(
            '<br/><br/><br/>'.
            '<div class="sw-js-checkbox-item sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<label for="post--checkall">'.
            '<input class="sw-js-checkbox-all sw-is-hidden" type="checkbox" name="post--checkall" id="post--checkall" value="0"/>'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-js-checkbox-true sw-c-list__select sw-is-hidden"><img src="/img/color/check-true.png"/></div>'.
            '<div class="sw-js-checkbox-false sw-c-list__select"><img src="/img/color/check-false.png"/></div>'.
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

    function selectWorld($action) {
        global $form, $curl, $user;

        $list = null;

        if($user) {
            $userList = $curl->get('user/id/'.$user->id.'/world/calculated');

            if(isset($userList['data'])) {
                foreach($userList['data'] as $item) {
                    $list[] = new World($item['id']);
                }
            }
        }

        $worldList = $curl->get('world')['data'];

        foreach($worldList as $item) {
            $list[] = new World(null, $item);
        }

        $form->formStart(['action' => $action]);
        $this->radioList('world_id',$list);
        $form->formEnd();
    }

    function selectSpecies($action, $world) {
        global $form;

        $list = $world->getSpecies();

        $form->formStart(['action' => $action]);
        $this->radioList('species_id', $list);
        $form->hidden('world_id', $world->id);
        $form->formEnd();
    }
}
