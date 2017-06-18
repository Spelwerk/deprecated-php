<?php class Expertise {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $value, $bonus;

    var $required, $increment, $maximum;

    var $skill;

    var $species;

    var $manifestation;

    var $doctrine;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('expertise/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('expertise',$this->id);

        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = $data['icon'];

        $this->value = isset($data['value']) ? $data['value'] : null;
        $this->bonus = isset($data['bonus']) ? $data['bonus'] : null;

        $this->maximum = $system->defaultExpertise['maximum'];

        $this->skill = $data['skill_id'];
        $this->skillName = isset($data['skill_name']) ? $data['skill_name'] : null;
        $this->species = $data['species_id'];
        $this->speciesName = isset($data['species_name']) ? $data['species_name'] : null;
        $this->manifestation = $data['manifestation_id'];
        $this->manifestationName = isset($data['manifestation_name']) ? $data['manifestation_name'] : null;

        $this->dice = $system->defaultDice['amount'] + intval($this->value);
        $this->diceText = $this->dice.'d'.$system->defaultDice['value'].'+'.intval($this->bonus);
        $this->diceData = 'data-roll-type="default" 
                           data-roll-d12="'.$this->dice.'" 
                           data-roll-bonus="'.$this->bonus.'"';

        $this->siteLink = '/content/expertise/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $form;

            $form->form([
                'do' => 'put',
                'return' => 'content/expertise',
                'context' => 'expertise',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);
            $component->wrapEnd();
            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/expertise');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Skill: '.$this->skillName);
        $component->p('Species: '.$this->speciesName);
        $component->p('Manifestation: '.$this->manifestationName);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }

    public function delete() {} //todo
}