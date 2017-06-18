<?php class Story {
    var $id, $name, $description, $plot;

    var $isOwner;

    var $world;

    public function __construct($id = null) {
        global $curl;

        $data = $curl->get('story/id/'.$id)['data'][0];

        $this->isOwner = isset($data['owner']) ? $data['owner'] : false;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->plot = $data['plot'];

        $this->world = isset($data['world_id']) ? new World($data['world_id']) : null;

        $this->siteLink = '/play/story/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'context' => 'story',
                'return' => 'content/focus',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);
            $form->text(false,'plot','Plot',null,null,$this->plot);
            $component->wrapEnd();
            $form->submit();
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

    public function delete() {} //todo

    // GET

    public function getPerson() {
        global $system;

        return $system->getPerson('story/id/'.$this->id.'/person');
    }

    public function getLocation() {
        global $system;

        return $system->getLocation('story/id/'.$this->id.'/location');
    }

    public function getMeeting() {
        global $system;

        return $system->getMeeting('story/id/'.$this->id.'/meeting');
    }

    // POST

    public function postPerson() {
        global $component, $form;

        $form->form([
            'do' => 'context--post',
            'context' => 'story',
            'id' => $this->id,
            'context2' => 'person',
            'return' => 'play/story'
        ]);
        $component->wrapStart();
        $form->number(true,'insert_id','Person ID','Which person would you like to add?');
        $component->wrapEnd();
        $form->submit();
    }

    // DELETE

    public function deletePerson() {

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
                $component->linkAction($person->siteLink, $person->nickname, $person->occupation, '/img/link-person-w.png');
            }
        }

        $component->link($this->siteLink.'/person/add','Add Person');
    }

    // BUILD

    public function buildRemoval($thing, $title, $icon, $context) {
        global $component, $form;

        $quick = $this->isOwner
            ? $form->quick('story--delete--has',$this->id,'play/story/id','/img/delete.png',[
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
            $form->form([
                'special' => 'user',
                'do' => 'save',
                'context' => 'story',
                'return' => 'play/story',
                'id' => $this->id
            ]);
            $form->submit(false, 'Save this story');
        }
    }
}