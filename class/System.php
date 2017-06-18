<?php

require_once('asset/Asset.php');
require_once('asset/AssetGroup.php');
require_once('asset/AssetType.php');
require_once('asset/Augmentation.php');
require_once('asset/Bionic.php');
require_once('asset/Protection.php');
require_once('asset/Software.php');
require_once('asset/Weapon.php');
require_once('asset/WeaponGroup.php');
require_once('asset/WeaponType.php');

require_once('feature/Attribute.php');
require_once('feature/Background.php');
require_once('feature/Doctrine.php');
require_once('feature/Expertise.php');
require_once('feature/Focus.php');
require_once('feature/Gift.php');
require_once('feature/Imperfection.php');
require_once('feature/Identity.php');
require_once('feature/Manifestation.php');
require_once('feature/Milestone.php');
require_once('feature/Nature.php');
require_once('feature/Skill.php');
require_once('feature/Species.php');

require_once('wound/Disease.php');
require_once('wound/Sanity.php');
require_once('wound/Wound.php');

require_once('Location.php');
require_once('Meeting.php');

require_once('Person.php');
require_once('Story.php');
require_once('World.php');

class System {
    public function __construct() {}

    // GET

    public function getAsset($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'asset';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Asset(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAssetGroup($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'assetgroup';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new AssetGroup(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAssetType($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'assettype';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new AssetType(null, $array);
            }
        }

        return $arrayList;
    }

    public function getAttribute($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
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
            ? $override
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
            ? $override
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
            ? $override
            : 'bionic';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Bionic(null, $array);
            }
        }

        return $arrayList;
    }

    public function getDisease($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'disease';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Disease(null, $array);
            }
        }

        return $arrayList;
    }

    public function getDoctrine($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
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
            ? $override
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
            ? $override
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
            ? $override
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
            ? $override
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
            ? $override
            : 'imperfection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Imperfection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getLocation($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'location';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Location(null, $array);
            }
        }

        return $arrayList;
    }

    public function getManifestation($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'manifestation';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Manifestation(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMeeting($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'meeting';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Meeting(null, $array);
            }
        }

        return $arrayList;
    }

    public function getMilestone($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
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
            ? $override
            : 'nature';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Nature(null, $array);
            }
        }

        return $arrayList;
    }

    public function getPerson($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'person';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Person($array['id']);
            }
        }

        return $arrayList;
    }

    public function getProtection($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'protection';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Protection(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSanity($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'sanity';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Sanity(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSkill($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'skill';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Skill(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSoftware($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'software';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Software(null, $array);
            }
        }

        return $arrayList;
    }

    public function getSpecies($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'species';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Species(null, $array);
            }
        }

        return $arrayList;
    }

    public function getStory($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'story';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Story($array['id']);
            }
        }

        return $arrayList;
    }

    public function getWeapon($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'weapon';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Weapon(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWeaponGroup($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'weapongroup';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new WeaponGroup(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWeaponType($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'weapontype';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new WeaponType(null, $array);
            }
        }

        return $arrayList;
    }

    public function getWorld($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'world';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new World($array['id']);
            }
        }

        return $arrayList;
    }

    public function getWound($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? $override
            : 'wound';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach ($result['data'] as $array) {
                $arrayList[] = new Wound(null, $array);
            }
        }

        return $arrayList;
    }

    // CREATE

    public function createAsset() {
        global $curl, $component, $form;

        $list = $curl->get('assettype')['data'];

        $component->h1('Create Asset');

        $form->form([
            'do' => 'post',
            'context' => 'asset',
            'return' => 'content/asset'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->select(true,'assettype_id',$list,'Type','All assets are in a type');
        $form->text(false,'description','Description');
        $form->pick(true, 'legal', 'Legality', 'Will a person be arrested for using this augmentation?', null, 'Legal', 'Illegal', true);
        $component->wrapEnd();
        $form->submit();
    }

    public function createAssetGroup() {
        global $component, $form;

        $component->h1('Create Asset Group');

        $form->form([
            'do' => 'post',
            'context' => 'assetgroup',
            'return' => 'content/assetgroup'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $component->wrapEnd();
        $form->submit();
    }

    public function createAssetType() {
        global $curl, $component, $form;

        $list = $curl->get('assetgroup')['data'];

        $component->h1('Create Asset Type');

        $form->form([
            'do' => 'post',
            'context' => 'assettype',
            'return' => 'content/assettype'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->select(true,'assetgroup_id',$list,'Group','All asset types are in a group');
        $form->icon();
        $component->wrapEnd();
        $form->submit();
    }

    public function createAugmentation() {
        global $component, $form;

        $component->h1('Create Augmentation');

        $form->form([
            'do' => 'post',
            'context' => 'augmentation',
            'return' => 'content/augmentation'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->number(true, 'energy', 'Energy Modification', 'Does this augmentation consume or produce energy? Use a negative value if the augmentation uses energy.',null,-12,12,-1);
        $form->pick(true, 'legal', 'Legality', 'Will a person be arrested for using this augmentation?', null, 'Legal', 'Illegal', true);
        $component->wrapEnd();
        $form->submit();

        // todo v4 add weapon creation information in here as well hidden
    }

    public function createBackground($species = null, $manifestation = null) {
        global $component, $form;

        $component->h1('Create Background');

        $form->form([
            'do' => 'post',
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

        $form->submit();
    }

    public function createBionic() {
        global $curl, $component, $form;

        $component->h1('Create Bionic');

        $bodypartList = $curl->get('bodypart')['data'];

        $form->form([
            'do' => 'post',
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

        $form->submit();
    }

    public function createDoctrine($manifestation = null) {
        global $component, $form;

        $component->h1('Add Doctrine');

        $form->form([
            'do' => 'post',
            'context' => 'doctrine',
            'return' => 'content/manifestation'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->icon();
        $component->wrapEnd();
        $form->hidden('manifestation_id',$manifestation);
        $form->submit();
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

        $form->form([
            'do' => 'post',
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

        $form->submit();
    }

    public function createFocus($manifestation) {
        global $component, $form;

        $component->h1('Add Focus');

        $form->form([
            'do' => 'post',
            'context' => 'focus',
            'return' => 'content/manifestation'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->icon();
        $component->wrapEnd();
        $form->hidden('manifestation_id',$manifestation);
        $form->submit();
    }

    public function createGift($species = null, $manifestation = null) {
        global $component, $form;

        $component->h1('Create Gift');

        $form->form([
            'do' => 'post',
            'return' => 'content/gift',
            'context' => 'gift'
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

        $form->submit();
    }

    public function createImperfection($species = null, $manifestation = null) {
        global $component, $form;

        $component->h1('Create Imperfection');

        $form->form([
            'do' => 'post',
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

        $form->submit();
    }

    public function createManifestation() {
        global $component, $form;

        $component->h1('Create Manifestation');

        $form->form([
            'do' => 'post',
            'return' => 'content/manifestation',
            'context' => 'manifestation'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->varchar(true,'power','Power','A manifestation uses a power of some sort. What is the catalyst of your manifestation?');
        $form->varchar(true,'skill','Skill','A manifestation needs to be controlled by something, a skill. What is the name of that skill?');
        $component->wrapEnd();

        $form->submit();
    }

    public function createMilestone($background = null, $species = null, $manifestation = null) {
        global $curl, $component, $form;

        $component->h1('Create Milestone');

        $form->form([
            'do' => 'post',
            'return' => 'content/milestone',
            'context' => 'milestone'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
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

        $form->submit();
    }

    public function createPerson($world = null, $species = null, $playable = 1) {
        global $component, $form;

        if(!isset($world) && !isset($species)) {
            $component->h1('Select World');
            $component->subtitle('You will need to select a world in which your character exists.');

            $this->selectWorld('play/person/create');

        } else if(isset($world) && !isset($species)) {
            $component->h1('Select Species');

            $this->selectSpecies('play/person/create', $world);

        } else if(isset($world) && isset($species)) {
            $component->h1('Nickname, Age, and Occupation');

            $component->wrapStart();
            $form->form([
                'do' => 'post',
                'context' => 'person',
                'return' => 'play/person'
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

            $form->hidden('playable', $playable);

            $form->submit();
            $component->wrapEnd();
        }
    }

    public function createProtection() {
        global $component, $curl, $form;

        $component->h1('Create Protection');

        $bodypartList = $curl->get('bodypart')['data'];

        $form->form([
            'do' => 'post',
            'context' => 'protection',
            'return' => 'content/protection'
        ]);
        $component->wrapStart();
        $form->select(true,'bodypart_id',$bodypartList,'Body Part','Reference to what area the protection is.');
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->icon();
        $component->wrapEnd();
        $form->submit();
    }

    public function createSkill($species = null) {
        global $component, $form;

        $component->h1('Create Skill');

        $form->form([
            'do' => 'post',
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

        $form->submit();
    }

    public function createSoftware() {
        global $component, $form;

        $component->h1('Create Software');

        $form->form([
            'do' => 'post',
            'context' => 'software',
            'return' => 'content/software'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->number(true, 'hacking', 'Hacking Difficulty', '', null, 0, 64, 12);
        $form->number(true, 'hacking_bonus', 'Hacking Bonus', '', null, 0, 12);
        $form->pick(true, 'legal', 'Legality', 'Will a person be arrested for using this software?', null, 'Legal', 'Illegal', true);
        $component->wrapEnd();
        $form->submit();
    }

    public function createSpecies() {
        global $component, $form;

        $component->h1('Create Species');

        $form->form([
            'do' => 'post',
            'return' => 'content/species',
            'context' => 'species'
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

        $form->submit();
    }

    public function createStory($world = null) {
        global $component, $form;

        if(!isset($world)) {
            $component->h1('Create Story');
            $component->h2('Select World');
            $component->subtitle('You will need to select a world in which your story takes place. It will also enable the system to understand what persons you can add.');
            $this->selectWorld('play/story/create');
        } else {
            $component->h1('Create Story');
            $component->h2('Details');
            $component->wrapStart();
            $form->form([
                'do' => 'post',
                'context' => 'story',
                'return' => 'play/story'
            ]);
            $form->hidden('world_id', $world->id);
            $form->varchar(true, 'name', 'Name', 'The name of your story will make it easier to remember which one it is.');
            $form->text(false, 'description', 'Description', 'Describe your Story. This field can be added to in the future.');
            $form->text(false, 'plot', 'Plot', 'Describe the plot of your Story. This field can be added to in the future.');
            $form->submit();
            $component->wrapEnd();
        }
    }

    public function createWeapon() {
        global $curl, $component, $form;

        $component->h1('Create Weapon');

        $typeList = $curl->get('weapontype')['data'];

        $form->form([
            'do' => 'post',
            'context' => 'weapon',
            'return' => 'content/weapon'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->select(true,'weapontype_id',$typeList,'Type','All weapons belong to a Weapon Type.');
        $form->number(true, 'damage_bonus','Damage Bonus','Weapons have a static damage bonus value that gets added to the dice rolled from Weapon Type.',null,0,32);
        $form->pick(true, 'legal', 'Legality', 'Will a person be arrested for using this weapon?', null, 'Legal', 'Illegal', true);
        $form->submit();
    }

    public function createWeaponGroup() {
        global $curl, $component, $form;

        $component->h1('Create Weapon Group');

        $attributeType = $curl->get('system/attribute')['type']['protection'];

        $skillList = $curl->get('skill')['data'];
        $attributeList = $curl->get('attribute/type/'.$attributeType)['data'];

        $form->form([
            'do' => 'post',
            'context' => 'weapongroup',
            'return' => 'content/weapongroup'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->select(true,'skill_id',$skillList,'Skill','Which skill does this weapon fit into? We\'d recommend: Melee | Projectiles | Guns');
        $form->select(true,'damage_id',$attributeList,'Damage Type','What sort of damage does this weapon inflict?');
        $form->icon();
        $form->submit();
    }

    public function createWeaponType() {
        global $curl, $component, $form;

        $component->h1('Create Weapon Type');

        $groupList = $curl->get('weapongroup')['data'];

        $form->form([
            'do' => 'post',
            'context' => 'weapontype',
            'return' => 'content/weapontype'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name');
        $form->text(false,'description','Description');
        $form->select(true,'weapongroup_id',$groupList,'Group','All weapon types belong to a Weapon Group.');
        $form->number(true, 'damage_d12','Amount of Damage Dice','How many dice will a player roll upon hitting someone. Remember that standard tolerance without protection is: 8',null,0,32,1);
        $form->number(true, 'critical_d12','Amount of Critical Dice','How many extra dice will a player roll when scoring a critical hit?',null,0,32,1);
        $form->number(false, 'hand','Hands required','Does this weapon require one hand or two hands to use?',null,1,2);
        $form->number(false, 'initiative','Initiative Modification','Will this weapon affect your ability to react quicker in battle?',null,null,32);
        $form->number(false, 'hit','Hit chance modification','Does this weapon affect your ability to hit?',null,null,16);
        $form->number(false, 'distance','Distance','If this weapon is ranged - how far can a projectile travel?');
        $form->submit();
    }

    public function createWorld() {
        global $component, $form;

        $component->h1('Create World');

        $form->form([
            'do' => 'post',
            'return' => 'content/world',
            'context' => 'world'
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
        $form->number(false,'split_doctrine','Split Doctrine','',null,1,128,4);
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
        $form->number(false,'max_doctrine','Maximum Supernatural','',null,1,128,12);
        $form->number(false,'max_skill','Maximum Skill','',null,1,128,32);
        $form->number(false,'max_expertise','Maximum Expertise','',null,1,128,12);
        $form->number(false,'max_milestone','Maximum Milestone','',null,1,12,6);
        $form->number(false,'max_relationship','Maximum Relationship','',null,1,12,4);
        $component->wrapEnd();

        $form->submit();
    }

    // LIST

    public function listAsset() {
        global $user;

        $this->listStandard('asset', $user->getAsset(), $this->getAsset());
    }

    public function listAssetGroup() {
        global $user;

        $this->listStandard('assetgroup', $user->getAssetGroup(), $this->getAssetGroup());
    }

    public function listAssetType() {
        global $user;

        $this->listStandard('assettype', $user->getAssetType(), $this->getAssetType());
    }

    public function listAugmentation() {
        global $user;

        $this->listStandard('augmentation', $user->getAugmentation(), $this->getAugmentation());
    }

    public function listAttribute() {
        $this->listStandard('attribute', null, $this->getAttribute());
    }

    public function listBackground() {
        global $user;

        $this->listStandard('background', $user->getBackground(), $this->getBackground());
    }

    public function listBionic() {
        global $user;

        $this->listStandard('bionic', $user->getBionic(), $this->getBionic());
    }

    public function listDoctrine() {
        global $component, $user;

        $userArray = $user->getDoctrine();
        $manifestationArray = $this->getManifestation();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/doctrine/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        foreach($manifestationArray as $manifestation) {
            $list = $this->getDoctrine('doctrine/manifestation/'.$manifestation->id);

            if(!$list) continue;

            $component->h3($manifestation->name);

            foreach($list as $item) {
                $component->linkButton('/content/doctrine/'.$item->id, $item->name);
            }
        }
    }

    public function listExpertise() {
        global $user;

        $this->listStandard('expertise', $user->getExpertise(), $this->getExpertise());
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
            $list = $this->getFocus('focus/manifestation/'.$manifestation->id);

            $component->h3($manifestation->name);

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

    public function listIdentity() {
        $this->listStandard('identity', null, $this->getIdentity());
    }

    public function listImperfection() {
        global $user;

        $this->listStandard('imperfection', $user->getImperfection(), $this->getImperfection());
    }

    public function listManifestation() {
        global $user;

        $this->listStandard('manifestation', $user->getManifestation(), $this->getManifestation());
    }

    public function listMilestone() {
        global $component, $user;

        $userArray = $user->getMilestone();
        $list = $this->getMilestone();
        $backgroundArray = $this->getBackground();
        $speciesArray = $this->getSpecies();
        $manifestationArray = $this->getManifestation();

        if($userArray) {
            $component->h2('Your Content');
            foreach($userArray as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }

        $component->h2('Canon');

        if($list) {
            foreach($list as $item) {
                $component->linkButton('/content/milestone/'.$item->id, $item->name);
            }
        }

        if($backgroundArray) {
            foreach($backgroundArray as $background) {
                $list = $this->getMilestone('/background/'.$background->id);

                if(!$list) continue;

                foreach($list as $item) {
                    $component->linkButton('/content/milestone/'.$item->id, $item->name);
                }
            }
        }

        if($speciesArray) {
            foreach($speciesArray as $species) {
                $list = $this->getMilestone('/species/'.$species->id);

                if(!$list) continue;

                foreach($list as $item) {
                    $component->linkButton('/content/milestone/'.$item->id, $item->name);
                }
            }
        }

        if($manifestationArray) {
            foreach($manifestationArray as $manifestation) {
                $list = $this->getMilestone('/manifestation/'.$manifestation->id);

                if(!$list) continue;

                foreach($list as $item) {
                    $component->linkButton('/content/milestone/'.$item->id, $item->name);
                }
            }
        }
    }

    public function listNature() {
        $this->listStandard('nature', null, $this->getNature());
    }

    public function listPerson() {
        global $user, $component;

        $userList = $user->isActive
            ? $user->getPerson()
            : null;

        $filterList = [];

        if($userList) {
            $component->h1('Your saved persons');

            foreach($userList as $item) {
                $filterList[] = $item->id;

                $component->linkButton('/play/person/'.$item->id,$item->nickname.' ('.$item->occupation.')');
            }
        }
    }

    public function listProtection() {
        global $user;

        $this->listStandard('protection', $user->getProtection(), $this->getProtection());
    }

    public function listSkill() {
        global $user;

        $this->listStandard('skill', $user->getSkill(), $this->getSkill());
    }

    public function listSoftware() {
        global $user;

        $this->listStandard('software', $user->getSoftware(), $this->getSoftware());
    }

    public function listSpecies() {
        global $user;

        $this->listStandard('species', $user->getSpecies(), $this->getSpecies());
    }

    public function listStory() {
        global $user, $component;

        $userList = $user->isActive
            ? $user->getStory()
            : null;

        $filterList = [];

        if($userList) {
            $component->h1('Your saved stories');

            foreach($userList as $item) {
                $filterList[] = $item->id;

                $component->linkButton('play/story/'.$item->id, $item->name);
            }
        }
    }

    public function listWeapon() {
        global $user;

        $this->listStandard('weapon', $user->getWeapon(), $this->getWeapon());
    }

    public function listWeaponGroup() {
        global $user;

        $this->listStandard('weapongroup', $user->getWeaponGroup(), $this->getWeaponGroup());
    }

    public function listWeaponType() {
        global $user;

        $this->listStandard('weapontype', $user->getWeaponType(), $this->getWeaponType());
    }

    public function listWorld() {
        global $user;

        $this->listStandard('world', $user->getWorld(), $this->getWorld());
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

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if(!$idList || !in_array($item->id, $idList)) {
                    $form->checkbox($item->name, $item->description, $item->id);
                }
            }
        }
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

        $form->form([
            'do' => $tableName.'--has--'.$do,
            'return' => 'content/'.$tableName,
            'returnafter' => $relationName,
            'id' => $tableId,
            'context' => $relationName
        ]);

        $system->checkboxList($list, $idList);
        $system->checkboxAll();

        $form->submit();
    }

    function contentSelectList($tableName, $relationName, $do, $tableId, $tableList, $idList = null, $userList = null) {
        global $form, $system;

        $form->form([
            'do' => 'relation--'.$do,
            'return' => 'content/'.$tableName,
            'id' => $tableId,
            'context' => $tableName,
            'context2' => $relationName
        ]);

        $system->checkboxList($tableList, $idList);

        if($userList) $system->checkboxList($userList, $idList);

        $system->checkboxAll();

        $form->submit();
    }

    function selectWorld($action) {
        global $form, $user;

        $worldList = $this->getWorld();
        $idList = null;

        $form->form(['action' => $action]);

        if($user) {
            $userList = $user->getWorld();

            $this->radioList('world_id', $userList);

            $idList = $this->idList($userList);
        }

        $this->radioList('world_id', $worldList, $idList);
        $form->submit();
    }

    function selectSpecies($action, $world) {
        global $form, $user;

        $speciesList = $world->getSpecies();
        $idList = null;

        $form->form(['action' => $action]);

        if($user) {
            $userList = $user->getSpecies();

            $this->radioList('species_id', $userList);

            $idList = $this->idList($userList);
        }

        $form->hidden('world_id', $world->id);
        $this->radioList('species_id', $speciesList, $idList);
        $form->submit();
    }

    function verifyOwner($data) {
        global $user;

        if($user->isAdmin) return true;

        $isOwner = isset($data['owner']) ? intval($data['owner']) : false;

        return $isOwner;
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

    function listStandard($contentHref, $userList, $canonList) {
        global $component;

        if($userList) {
            $component->h2('Your Content');

            foreach($userList as $item) {
                $component->linkButton('/content/'.$contentHref.'/'.$item->id, $item->name);
            }
        }

        if($canonList) {
            $component->h2('Canon');

            foreach($canonList as $item) {
                $component->linkButton('/content/'.$contentHref.'/'.$item->id, $item->name);
            }
        }
    }
}
