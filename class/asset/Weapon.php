<?php class Weapon {
    var $id, $canon, $popularity, $name, $description, $icon, $price, $legal;

    var $damageD12, $damageBonus, $criticalD12, $hand, $initiative, $hit, $distance;

    var $special, $species, $augmentation;

    var $type, $group, $skill, $damage, $expertise;

    var $equipped;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('weapon/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];
        $this->icon = $data['icon'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->legal = $data['legal'];

        $this->damageD12 = isset($data['quality_damage_d12'])
            ? intval($data['damage_d12']) + intval($data['quality_damage_d12'])
            : intval($data['damage_d12']);

        $this->damageBonus = isset($data['quality_damage_bonus'])
            ? intval($data['damage_bonus']) + intval($data['quality_damage_bonus'])
            : intval($data['damage_bonus']);

        $this->criticalD12 = isset($data['quality_critical_d12'])
            ? intval($data['critical_d12']) + intval($data['quality_critical_d12'])
            : intval($data['critical_d12']);

        $this->hand = $data['hand'];

        $this->initiative = isset($data['quality_initiative'])
            ? intval($data['initiative']) + intval($data['quality_initiative'])
            : intval($data['initiative']);

        $this->hit = isset($data['quality_hit'])
            ? intval($data['hit']) + intval($data['quality_hit'])
            : intval($data['hit']);

        $this->distance = isset($data['quality_distance'])
            ? intval($data['distance']) + intval($data['quality_distance'])
            : intval($data['distance']);

        $this->type = $data['weapontype_id'];
        $this->group = $data['weapongroup_id'];

        $this->special = $data['special'];
        $this->species = $data['species'];
        $this->augmentation = $data['augmentation'];

        $this->skill = $data['skill_id'];
        $this->skillValue = isset($data['skill_value']) ? intval($data['skill_value']) : null;

        $this->expertise = $data['expertise_id'];
        $this->expertiseValue = isset($data['expertise_value']) ? $data['expertise_value'] : null;

        $this->damage = $data['damage_id'];

        $this->equipped = isset($data['equipped'])
            ? $data['equipped']
            : false;

        $this->hitDice = intval($system->defaultDice['amount']) + $this->expertiseValue;
        $this->hitBonus = $this->skillValue + $this->hit;

        $this->strikeDice = $this->damageD12;
        $this->strikeBonus = $this->damageBonus;
        $this->strikeCritical = $this->criticalD12;

        $this->diceText = $this->strikeBonus > 0
            ? $this->strikeDice.'d'.$system->defaultDice['value'].'+'.$this->strikeBonus
            : $this->strikeDice.'d'.$system->defaultDice['value'];

        $this->diceData = 'data-roll-type="weapon" 
                           data-roll-d12="'.$this->hitDice.'" 
                           data-roll-bonus="'.$this->hitBonus.'" 
                           data-strike-d12="'.$this->damageD12.'" 
                           data-strike-bonus="'.$this->damageBonus.'" 
                           data-strike-critical="'.$this->criticalD12.'"';

        $this->siteLink = '/content/weapon/'.$this->id;
    }

    public function put() {
        global $component, $form;

        $form->form([
            'do' => 'put',
            'id' => $this->id,
            'context' => 'weapon',
            'return' => 'content/weapon'
        ]);
        $component->wrapStart();
        $form->varchar(true,'name','Name',null,null,$this->name);
        $form->text(false,'description','Description',null,null,$this->description);
        $form->number(true, 'damage_bonus','Damage Bonus','Weapons have a static damage bonus value that gets added to the dice rolled from Weapon Type.',null,0,32,$this->damageBonus);
        $form->pick(true, 'legal', 'Legality', 'Will a person be arrested for using this weapon?', null, 'Legal', 'Illegal', $this->legal);
        $form->submit();
    }

    public function view() {
        global $component;

        $component->returnButton('/content/weapon');

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

        $component->p('Damage D12: '.$this->damageD12);
        $component->p('Damage Bonus: '.$this->damageBonus);
        $component->p('Critical D12: '.$this->criticalD12);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}