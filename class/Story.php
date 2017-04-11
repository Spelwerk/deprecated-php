<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */

require_once('World.php');

class Story {

    var $id, $hash, $name, $description, $plot;

    var $isOwner;

    var $world;

    public function __construct($id = null, $hash = null) {
        global $curl;

        $data = $curl->get('story/id/'.$id)['data'][0];

        $this->hash = isset($hash)
            ? $hash
            : null;

        $this->isOwner = isset($hash) && $hash == $data['hash']
            ? true
            : false;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->plot = $data['plot'];

        $this->world = isset($data['world_id'])
            ? new World($data['world_id'])
            : null;

        $this->siteLink = $this->isOwner
            ? '/play/story/id/'.$this->id.'/'.$this->hash
            : '/play/story/id/'.$this->id;
    }


    public function getPerson() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('story-person/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = $array;
            }
        }

        return $arrayList;
    }

    public function getLocation() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('story-location/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = $array;
            }
        }

        return $arrayList;
    }

    public function getMeeting() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('story-meeting/id/'.$this->id);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = $array;
            }
        }

        return $arrayList;
    }


    public function makeButton() {
        global $component;

        $component->wrapStart(true);

        for($i = 1; $i <= 8; $i++) {
            $title = 'Roll';

            $value = $i.'d12';

            $data = 'data-roll-type="default" 
                     data-roll-d12="'.$i.'" 
                     data-roll-bonus="0"';

            $component->roll($title, null, '/img/modal/dice.png', $value, $data);
        }

        $component->wrapEnd();
    }

    public function makeWeapon() {
        global $component;

        $component->wrapStart(true);

        for($i = 1; $i <= 6; $i++) {
            $title = 'Weapon';

            $value = $i.'d12';

            $data = 'data-roll-type="weapon" 
                     data-roll-d12="2" 
                     data-roll-bonus="0" 
                     data-strike-d12="'.$i.'" 
                     data-strike-bonus="0" 
                     data-strike-critical="1"';

            $component->roll($title, null, '/img/modal/damage.png', $value, $data);
        }

        $component->wrapEnd();
    }

    public function makePerson() {
        global $component;

        $list = $this->getPerson();

        if($list) {
            foreach($list as $person) {
                $link = isset($person['person_hash'])
                    ? '/play/person/id/'.$person['person_id'].'/'.$person['person_hash']
                    : '/play/person/id/'.$person['person_id'];

                $component->linkAction($link, $person['person_nickname'], $person['person_occupation'], '/img/link-person-w.png');
            }
        }

        $component->link('/play/story/id/'.$this->id.'/'.$this->hash.'/person/add','Add Person');
    }


    public function buildRemoval($thing, $title, $icon, $context) {
        global $component, $form;

        $quick = $this->isOwner
            ? $form->quick('story--delete--has',$this->id,$this->hash,'play/story/id','delete',[
                'context' => $context,
                'thing' => $thing
            ])
            : null;

        $component->listAction($title, $quick, ['icon' => $icon]);
    }
}