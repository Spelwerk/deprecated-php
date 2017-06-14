<?php class Milestone {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $background;

    var $species;

    var $manifestation;

    var $attribute, $attributeValue;

    var $skill, $skillValue;

    var $loyalty, $loyaltyOccupation;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('milestone/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->popularity = $data['popularity'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->icon = '/img/color/milestone.png';

        $this->background = $data['background_id'];
        $this->species = $data['species_id'];
        $this->manifestation = $data['manifestation_id'];

        $this->attribute = $data['attribute_id'];
        $this->attributeValue = $data['attribute_value'];

        $this->skill = $data['skill_id'];
        $this->skillValue = $data['skill_value'];

        $this->loyalty = $data['loyalty_id'];
        $this->loyaltyOccupation = $data['loyalty_occupation'];

        $this->siteLink = '/content/milestone/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $component, $curl, $form;

            $skillList = $curl->get('skill')['data'];
            $attributeList = $curl->get('attribute/special/0')['data'];

            $form->form([
                'do' => 'put',
                'return' => 'content/milestone',
                'context' => 'milestone',
                'id' => $this->id
            ]);
            $component->wrapStart();
            $form->varchar(true,'name','Name',null,null,$this->name);
            $form->text(false,'description','Description',null,null,$this->description);

            $form->select(false,'attribute_id',$attributeList,'Attribute','If this gift increases an attribute, which one?');
            $form->number(false,'attribute_value','Attribute Value','Amount of points this gift will increase by.',null,0,16);

            $form->select(false,'skill_id',$skillList,'Skill','If this gift increases a skill, which one?');
            $form->number(false,'skill_value','Skill Value','Amount of points this gift will increase by.',null,0,16);

            $component->wrapEnd();
            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/milestone');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Background ID: '.$this->background); //todo api return name
        $component->p('Species ID: '.$this->species); //todo api return name
        $component->p('Manifestation ID: '.$this->manifestation); //todo api return name
        $component->p('Attribute ID: '.$this->attribute); //todo api return name
        $component->p('Attribute Value: '.$this->attributeValue); //todo api return name
        $component->p('Skill ID: '.$this->skill); //todo api return name
        $component->p('Skill Value: '.$this->skillValue); //todo api return name

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            //todo link to delete();
        }
    }

    public function delete() {} //todo
}