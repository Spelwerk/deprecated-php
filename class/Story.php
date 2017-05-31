<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-11-16
 * Time: 16:49
 */

require_once('World.php');

class Story {

    var $id, $secret, $name, $description, $plot;

    var $isOwner;

    var $world;

    public function __construct($id = null, $secret = null) {
        global $curl;

        $data = $curl->get('story/id/'.$id)['data'][0];

        $this->secret = isset($secret)
            ? $secret
            : null;

        $this->isOwner = isset($secret) && $secret == $data['secret']
            ? true
            : false;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->plot = $data['plot'];

        $this->world = isset($data['world_id']) ? new World($data['world_id']) : null;

        $this->siteLink = $this->isOwner
            ? '/play/story/id/'.$this->id.'/'.$this->secret
            : '/play/story/id/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->formStart([
                'do' => 'basic--put',
                'context' => 'story',
                'return' => 'content/focus',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);
            $form->text(false,'plot','Plot',null,null,$this->plot);
            $component->wrapEnd();
            $form->formEnd();
        }
    }

    public function view() {
        global $component;

        $this->verifyUserOwnership();

        $component->sectionStart();

        $component->h1('Description');
        $component->subtitle('World is: '.$this->world->name);
        $component->p($this->description);

        $component->h1('Plot');
        $component->p($this->plot);

        $component->h1('Roll');
        $this->makeButton();

        $component->h1('Weapon');
        $this->makeWeapon();

        $component->h1('Person');
        $this->makePerson();

        $component->sectionEnd();
    }

    // GET

    public function getPerson() {
        global $curl;

        $arrayList = null;

        $result = $curl->get('story/id/'.$this->id.'/person');

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

        $result = $curl->get('story/id/'.$this->id.'/location');

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

        $result = $curl->get('story/id/'.$this->id.'/meeting');

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = $array;
            }
        }

        return $arrayList;
    }

    // MAKE

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

        $component->link('/play/story/id/'.$this->id.'/'.$this->secret.'/person/add','Add Person');
    }

    // BUILD

    public function buildRemoval($thing, $title, $icon, $context) {
        global $component, $form;

        $quick = $this->isOwner
            ? $form->quick('story--delete--has',$this->id,$this->secret,'play/story/id','delete',[
                'context' => $context,
                'thing' => $thing
            ])
            : null;

        $component->listAction($title, $quick, ['icon' => $icon]);
    }

    // PRIVATE

    private function verifyUserOwnership() {
        global $form, $user;

        $userOwner = false;

        if($this->isOwner) {
            $list = $user->getStory();

            if($list) {
                foreach($list as $item) {
                    if($this->id == $item->id) {
                        $userOwner = true;
                    }
                }
            }
        }

        if(!$userOwner) {
            $form->formStart([
                'do' => 'user--save',
                'context' => 'story',
                'return' => 'play/story',
                'id' => $this->id,
                'secret' => $this->secret
            ]);
            $form->formEnd(false, 'Save this story');
        }
    }
}