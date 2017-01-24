<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-10
 * Time: 09:09
 */

require_once('feature/Attribute.php');
require_once('feature/Augmentation.php');
require_once('feature/Bionic.php');
require_once('feature/Caste.php');
require_once('feature/Characteristic.php');
require_once('feature/Expertise.php');
require_once('feature/Focus.php');
require_once('feature/Identity.php');
require_once('feature/Manifestation.php');
require_once('feature/Milestone.php');
require_once('feature/Nature.php');
require_once('feature/Species.php');
require_once('feature/Weapon.php');

class Person {

    var $id, $hash, $template, $popularity, $cheated;

    var $owner;

    var $name;

    var $supernatural;

    var $description;

    var $attributeList, $bionicList, $characteristicList, $expertiseList,
        $milestoneList, $weaponList;

    var $world, $attributetype, $species, $caste, $nature, $identity, $manifestation, $focus;

    var $asset, $attribute, $augmentation, $bionic, $characteristic, $expertise, $milestone, $relationship, $protection, $software, $weapon, $weaponmod, $wounds;

    public function __construct($id = null, $hash = null) {
        global $Curl;

        $get = $hash != null
            ? 'person/hash/'.$hash
            : 'person/id/'.$id;

        $this->owner = $hash != null
            ? true
            : false;

        $data = $Curl->get($get)['data'][0];


        $this->id = intval($data['id']);

        $this->hash = $data['hash'];

        $this->name = [
            'nick' => $data['nickname'],
            'first' => $data['firstname'],
            'last' => $data['surname'],
        ];

        $this->description = [
            'age' => $data['age'],
            'gender' => $data['gender'],
            'occupation' => $data['occupation'],
            'description' => $data['description'],
            'behaviour' => $data['behaviour'],
            'appearance' => $data['appearance'],
            'features' => $data['features'],
            'personality' => $data['personality']
        ];


        $this->template = intval($data['template']) == 1
            ? true
            : false;

        $this->popularity = $data['popularity'];

        $this->cheated = intval($data['cheated']) == 1
            ? true
            : false;

        $this->world = intval($data['world_id']);

        $this->species = new Species([
            'id' => $data['species_id'],
            'name' => $data['species_name'],
            'description' => $data['species_description'],
            'icon_path' => $data['species_icon_path']
        ]);

        $this->caste = new Caste([
            'id' => $data['caste_id'],
            'name' => $data['caste_name'],
            'description' => $data['caste_description'],
            'icon_path' => $data['caste_icon_path']
        ]);

        $this->nature = new Nature([
            'id' => $data['nature_id'],
            'name' => $data['nature_name'],
            'description' => $data['nature_description'],
            'icon_path' => $data['nature_icon_path'],
        ]);

        $this->identity = new Identity([
            'id' => $data['identity_id'],
            'name' => $data['identity_name'],
            'description' => $data['identity_description'],
            'icon_path' => $data['identity_icon_path'],
        ]);

        $this->supernatural = intval($data['supernatural']) == 1
            ? true
            : false;

        if($this->supernatural == true)
            $this->manifestation = new Manifestation([
            'id' => $data['manifestation_id'],
            'name' => $data['manifestation_name'],
            'description' => $data['manifestation_description'],
            'attributetype_id' => $data['manifestation_attributetype_id'],
            'attributetype_name' => $data['manifestation_attributetype_name'],
            'expertisetype_id' => $data['manifestation_expertisetype_id'],
            'expertisetype_name' => $data['manifestation_expertisetype_name'],
            'icon_path' => $data['manifestation_icon_path']
        ]);

        if($this->supernatural == true)
            $this->focus = new Focus([
            'id' => $data['focus_id'],
            'name' => $data['focus_name'],
            'description' => $data['focus_description'],
            'icon_path' => $data['focus_icon_path'],
        ]);
    }
}