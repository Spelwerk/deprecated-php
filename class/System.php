<?php

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

require_once('World.php');
require_once('Person.php');
require_once('Story.php');

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

    public function getWorld($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'world'.$override
            : 'world';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new World(null, $array);
            }
        }

        return $arrayList;
    }

    // CREATE

    public function createAugmentation() {} //todo

    public function createBackground($species = null, $manifestation = null) {
        global $component, $form;

        $component->h1('Create Background');

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/background',
            'context' => 'background'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $component->wrapEnd();

        if($species) {
            $form->hidden('species_id',$species);
        }

        if($manifestation) {
            $form->hidden('manifestation_id',$manifestation);
        }

        $form->formEnd();
    }

    public function createBionic() {
        global $curl, $component, $form;

        $component->h1('Create Bionic');

        $bodypartList = $curl->get('bodypart')['data'];

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/bionic',
            'context' => 'bionic'
        ]);
        $component->wrapStart();
        $form->select(true,'bodypart_id',$bodypartList,'Body Part','Reference to what area the bionic is.');
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->number(true,'energy','Energy','Amount of energy this bionic has in store to install extra augmentations.',null,0,16);
        $form->pick(true,'legal','Legality','Will a person be arrested for using this bionic?',null,'Legal','Illegal');
        $component->wrapEnd();

        $form->formEnd();
    }

    public function createExpertise($species = null) {
        global $curl, $component, $form;

        $component->h1('Create Expertise');

        $list = null;
        $route = 'skill';

        if($species) {
            $route = 'skill/species/'.$species;
        }

        $list = $curl->get($route)['data'];

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/expertise',
            'context' => 'expertise'
        ]);
        $component->wrapStart();
        $form->select(true,'skill_id',$list,'Skill','All expertises are tied to a skill.');
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $component->wrapEnd();

        if($species) {
            $form->hidden('species_id',$species);
        }

        $form->formEnd();
    }

    public function createGift($species = null, $manifestation = null) {
        global $curl, $component, $form;

        $component->h1('Create Gift');

        $skillListPrimary = $curl->get('skill')['data'];
        $skillListSpecies = [];
        $attributeList = $curl->get('attribute/special/0')['data'];

        $skillList = null;

        if($species) {
            $skillListSpecies = $curl->get('skill/species/'.$species)['data'];
        }

        $skillList = array_merge($skillListPrimary, $skillListSpecies);

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/gift',
            'context' => 'gift'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');

        $form->select(false,'attribute_id',$attributeList,'Attribute','If this gift increases an attribute, which one?');
        $form->number(false,'attribute_value','Attribute Value','Amount of points this gift will increase by.',null,0,16);

        $form->select(false,'skill_id',$skillList,'Skill','If this gift increases a skill, which one?');
        $form->number(false,'skill_value','Skill Value','Amount of points this gift will increase by.',null,0,16);

        $component->wrapEnd();

        if($species) {
            $form->hidden('species_id',$species);
        }

        if($manifestation) {
            $form->hidden('manifestation_id',$manifestation);
        }

        $form->formEnd();
    }

    public function createImperfection($species = null, $manifestation = null) {
        global $component, $form;

        $component->h1('Create Imperfection');

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/imperfection',
            'context' => 'imperfection'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $component->wrapEnd();

        if($species) {
            $form->hidden('species_id',$species);
        }

        if($manifestation) {
            $form->hidden('manifestation_id',$manifestation);
        }

        $form->formEnd();
    }

    public function createManifestation() {
        global $component, $form;

        $component->h1('Create Manifestation');

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/manifestation',
            'context' => 'manifestation'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->varchar(true,'power','Power','A manifestation uses a power of some sort. What is the catalyst of your manifestation?');
        $form->varchar(true,'skill','Skill','A manifestation needs to be controlled by something, a skill. What is the name of that skill?');
        $component->wrapEnd();

        $form->formEnd();
    }

    public function createMilestone($background = null, $species = null, $manifestation = null) {
        global $curl, $component, $form;

        $component->h1('Create Milestone');

        $skillList = $curl->get('skill')['data'];
        $attributeList = $curl->get('attribute/special/0')['data'];

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/milestone',
            'context' => 'milestone'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');

        $form->select(false,'attribute_id',$attributeList,'Attribute','If this gift increases an attribute, which one?');
        $form->number(false,'attribute_value','Attribute Value','Amount of points this gift will increase by.',null,0,16);

        $form->select(false,'skill_id',$skillList,'Skill','If this gift increases a skill, which one?');
        $form->number(false,'skill_value','Skill Value','Amount of points this gift will increase by.',null,0,16);

        //todo add loyalty and relationship here

        $component->wrapEnd();

        if($species) {
            $form->hidden('background_id',$background);
        }

        if($species) {
            $form->hidden('species_id',$species);
        }

        if($manifestation) {
            $form->hidden('manifestation_id',$manifestation);
        }

        $form->formEnd();
    }

    public function createPerson($world = null, $species = null) {
        global $component, $form;

        if(!isset($world) && !isset($species)) {
            $component->h1('Create Person');
            $component->h2('Select World');
            $component->subtitle('You will need to select a world in which your character exists.');

            $this->selectWorld('play/person/new');

        } else if(isset($world) && !isset($species)) {
            $component->h1('Create Person');
            $component->h2('Select Species');

            $this->selectSpecies('play/person/new', $world);

        } else if(isset($world) && isset($species)) {
            $component->h1('Create Person');
            $component->h2('Nickname, Age, and Occupation');

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

    public function createProtection() {} //todo

    public function createSkill($species = null) {
        global $component, $form;

        $component->h1('Create Skill');

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/skill',
            'context' => 'skill'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $component->wrapEnd();

        if($species) {
            $form->hidden('species_id',$species);
        }

        $form->formEnd();
    }

    public function createSpecies() {
        global $component, $form;

        $component->h1('Create Species');

        $form->formStart([
            'do' => 'basic--post',
            'return' => 'content/species'
        ]);

        $component->h2('Basic Information');
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->pick(true,'playable','Playable','Select this if the species you\'re creating is playable by other people.',null,'Playable','Creature',true);
        $form->number(false,'max_age','Maximum Age','What is the maximum age your species can live?',null,1,9001,100);
        $component->wrapEnd();

        $component->h2('Multiplication');
        $component->subtitle('During person/character creation, a person will multiply age with a value to receive points. With what value? This is useful for species that won\'t live long, but mature quickly.');
        $component->wrapStart();
        $form->number(false,'multiply_skill','Multiplying Skill','Increase this if your species should receive bonuses to skill',null,1,16,1);
        $form->number(false,'multiply_expertise','Multiplying Expertise','Increase this if your species should receive bonuses to expertises',null,1,16,1);
        $component->wrapEnd();

        $form->formEnd();
    }

    public function createStory($world = null) {
        global $component, $form;

        if(!isset($world)) {
            $component->h1('Create Story');
            $component->h2('Select World');
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

    public function createWeapon($species = null) {} //todo

    public function createWorld() {
        global $component, $form;

        $component->h1('Create World');

        $form->formStart([
            'do' => 'world--post',
            'return' => 'content/world'
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

    // LIST

    public function listAugmentation() {} //todo

    public function listBackground() {
        global $component, $user;

        $userArray = $user->getBackground();
        $list = $this->getBackground();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/background/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/background/'.$item->id, $item->name);
        }
    }

    public function listBionic() {
        global $component, $user;

        $userArray = $user->getBionic();
        $list = $this->getBionic();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/bionic/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/bionic/'.$item->id, $item->name);
        }
    }

    public function listExpertise() {
        global $component, $user;

        $userArray = $user->getExpertise();
        $list = $this->getExpertise();
        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/expertise/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/expertise/'.$item->id, $item->name);
        }

        foreach($speciesArray as $species) {
            $list = $this->getExpertise('/species/'.$species->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/expertise/'.$item->id, $item->name);
            }
        }

        foreach($manifestationArray as $manifestation) {
            $list = $this->getExpertise('/manifestation/'.$manifestation->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/expertise/'.$item->id, $item->name);
            }
        }
    }

    public function listFocus() {
        global $component, $user;

        $userArray = $user->getFocus();
        $manifestationArray = $this->getManifestation();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/focus/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($manifestationArray as $manifestation) {
            $list = $this->getFocus('/manifestation/'.$manifestation->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/focus/'.$item->id, $item->name);
            }
        }
    }

    public function listGift() {
        global $component, $user;

        $userArray = $user->getGift();
        $list = $this->getGift();
        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();
        $skillArray = $this->getSkill();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/gift/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/gift/'.$item->id, $item->name);
        }

        foreach($skillArray as $skill) {
            $list = $this->getGift('/skill/'.$skill->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/gift/'.$item->id, $item->name);
            }
        }

        foreach($speciesArray as $species) {
            $list = $this->getGift('/species/'.$species->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/gift/'.$item->id, $item->name);
            }
        }

        foreach($manifestationArray as $manifestation) {
            $list = $this->getGift('/manifestation/'.$manifestation->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/gift/'.$item->id, $item->name);
            }
        }
    }

    public function listImperfection() {
        global $component, $user;

        $userArray = $user->getImperfection();
        $list = $this->getImperfection();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/imperfection/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/imperfection/'.$item->id, $item->name);
        }
    }

    public function listManifestation() {
        global $component, $user;

        $userArray = $user->getManifestation();
        $list = $this->getManifestation();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/manifestation/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/manifestation/'.$item->id, $item->name);
        }
    }

    public function listMilestone() {
        global $component, $user;

        $userArray = $user->getMilestone();
        $list = $this->getMilestone();
        $backgroundArray = $this->getBackground();
        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();
        $skillArray = $this->getSkill();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/milestone/'.$item->id, $item->name);
        }

        foreach($backgroundArray as $background) {
            $list = $this->getMilestone('/background/'.$background->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }

        foreach($speciesArray as $species) {
            $list = $this->getMilestone('/species/'.$species->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }

        foreach($manifestationArray as $manifestation) {
            $list = $this->getMilestone('/manifestation/'.$manifestation->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }

        foreach($skillArray as $skill) {
            $list = $this->getMilestone('/skill/'.$skill->id);

            if(!$list) continue;

            foreach($list as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }
    }

    public function listProtection() {} //todo

    public function listSkill() {
        global $component, $user;

        $userArray = $user->getSkill();
        $list = $this->getSkill();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/skill/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/skill/'.$item->id, $item->name);
        }
    }

    public function listSpecies() {
        global $component, $user;

        $userArray = $user->getSpecies();
        $list = $this->getSpecies();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/species/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/species/'.$item->id, $item->name);
        }
    }

    public function listWeapon() {} //todo

    public function listWorld() {
        global $component, $user;

        $userArray = $user->getWorld();
        $list = $this->getWorld();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/world/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($list as $item) {
            $component->linkButton('/content/world/'.$item->id, $item->name);
        }
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
    }

    function checkList($tableName, $tableId, $relationName, $do, $list, $idList = null) {
        global $form, $system;

        $form->formStart([
            'do' => $tableName.'--has--'.$do,
            'return' => 'content/'.$tableName,
            'returnafter' => $relationName,
            'id' => $tableId,
            'context' => $relationName
        ]);

        $system->checkboxList($list, $idList);
        $system->checkboxAll();

        $form->formEnd();
    }

    function contentSelectList($tableName, $relationName, $do, $tableId, $tableList, $idList = null) {
        global $form, $system;

        $form->formStart([
            'do' => 'basic--has--'.$do,
            'return' => 'content/'.$tableName,
            'returnafter' => $relationName,
            'id' => $tableId,
            'context' => $tableName,
            'context2' => $relationName
        ]);

        $system->checkboxList($tableList, $idList);
        $system->checkboxAll();

        $form->formEnd();
    }

    function selectWorld($action) {
        global $form, $user;

        $worldList = $this->getWorld();
        $idList = null;

        $form->formStart(['action' => $action]);

        if($user) {
            $userList = $user->getWorld();

            $this->radioList('world_id', $userList);

            $idList = $this->idList($userList);
        }

        $this->radioList('world_id', $worldList, $idList);
        $form->formEnd();
    }

    function selectSpecies($action, $world) {
        global $form, $user;

        $speciesList = $world->getSpecies();
        $idList = null;

        $form->formStart(['action' => $action]);

        if($user) {
            $userList = $user->getSpecies();

            $this->radioList('species_id', $userList);

            $idList = $this->idList($userList);
        }

        $form->hidden('world_id', $world->id);
        $this->radioList('species_id', $speciesList, $idList);
        $form->formEnd();
    }

    function verifyOwner($data) {
        global $user;

        if($user->isAdmin) return true;

        $result = isset($data['owner']) ? $data['owner'] : null;

        return $result;
    }

    function listRelation($list, $relationName, $siteLink) {
        global $component;

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        $component->linkButton($siteLink.'/'.$relationName.'/add','Add');
        $component->linkButton($siteLink.'/'.$relationName.'/delete','Delete',true);
    }
}
