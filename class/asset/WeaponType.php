<?php class WeaponType {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $special;

    var $damageDice, $criticalDice;

    var $hand, $initiative, $hit, $distance;

    var $group, $skill, $damage, $expertise;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('weapontype/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->damageDice = intval($data['damage_dice']);
        $this->criticalDice = intval($data['critical_dice']);
        $this->hand = intval($data['hand']);
        $this->initiative = intval($data['initiative']);
        $this->hit = intval($data['hit']);
        $this->distance = intval($data['distance']);

        $this->group = $data['weapongroup_id'];

        $this->special = $data['special'];

        $this->skill = $data['skill_id'];
        $this->expertise = $data['expertise_id'];
        $this->damage = $data['damage_id'];

        $this->siteLink = '/content/weapontype/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('weapontype', $this->id);
    }

    public function put() {
        if($this->verifyOwner()) {
            global $component, $form;

            $form->form([
                'do' => 'post',
                'id' => $this->id,
                'context' => 'weapontype',
                'return' => 'content/weapontype'
            ]);
            $component->wrapStart();
            $form->varchar(true, 'name', 'Name', null, null, $this->name);
            $form->text(false, 'description', 'Description', null, null, $this->description);
            $form->number(true, 'damage_dice', 'Amount of Damage Dice', 'How many dice will a player roll upon hitting someone. Remember that standard tolerance without protection is: 8', null, 0, 32, $this->damageDice);
            $form->number(true, 'critical_dice', 'Amount of Critical Dice', 'How many extra dice will a player roll when scoring a critical hit?', null, 0, 32, $this->criticalDice);
            $form->number(false, 'hand', 'Hands required', 'Does this weapon require one hand or two hands to use?', null, 1, 2, $this->hand);
            $form->number(false, 'initiative', 'Initiative Modification', 'Will this weapon affect your ability to react quicker in battle?', null, null, 32, $this->initiative);
            $form->number(false, 'hit', 'Hit chance modification', 'Does this weapon affect your ability to hit?', null, null, 16, $this->hit);
            $form->number(false, 'distance', 'Distance', 'If this weapon is ranged - how far can a projectile travel?', null, 0, null, $this->distance);
            $form->submit();
        }
    }

    public function view() {
        global $component;

        $component->returnButton('/content/weapontype');

        $component->roundImage($this->icon);
        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Group ID: '.$this->group);

        $component->p('Skill ID: '.$this->skill);
        $component->p('Damage ID: '.$this->damage);
        $component->p('Expertise ID: '.$this->expertise);

        $component->p('Hand: '.$this->hand);
        $component->p('Initiative: '.$this->initiative);
        $component->p('Hit: '.$this->hit);
        $component->p('Distance: '.$this->distance);

        $component->p('Damage D12: '.$this->damageDice);
        $component->p('Critical D12: '.$this->criticalDice);

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}