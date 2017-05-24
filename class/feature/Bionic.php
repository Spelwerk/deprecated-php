<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-02
 * Time: 07:28
 */

class Bionic {
    var $id, $canon, $name, $description, $price, $energy, $legal, $icon;

    var $bodypart;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system, $user;

        $data = isset($id)
            ? $curl->get('bionic/id/'.$id, $user->token)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = isset($data['custom'])
            ? $data['custom']
            : $data['description'];

        $this->price = isset($data['quality_price'])
            ? intval($data['price']) * intval($data['quality_price'])
            : intval($data['price']);

        $this->energy = isset($data['quality_energy'])
            ? intval($data['energy']) * intval($data['quality_energy'])
            : intval($data['energy']);

        $this->legal = $data['legal'];
        $this->icon = $data['icon'];

        $this->bodypart = $data['bodypart_id'];

        $this->siteLink = '/content/bionic/id/'.$this->id;
    }

    public function put() {
        if($this->isOwner) {
            global $curl, $component, $form;

            $bodypartList = $curl->get('bodypart')['data'];

            $form->formStart([
                'do' => 'basic--put',
                'return' => 'content/bionic',
                'context' => 'bionic',
                'id' => $this->id
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
    }

    public function view() {
        global $component;

        $component->returnButton('/content/bionic');

        $component->h1('Description');
        $component->p($this->description);
        $component->h1('Data');
        $component->p('Energy: '.$this->energy); //todo api return not boolean
        $component->p('Legality: '.$this->legal); //todo api return not boolean

        //todo foreach attribute/skill

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
            $component->linkButton($this->siteLink.'/attribute','Add Attribute');
            $component->linkButton($this->siteLink.'/augmentation','Add Augmentation');
            //todo link to delete();
        }
    }

    // GET

    public function getAttribute($override = null) {
        global $curl;

        $arrayList = null;

        $get = isset($override)
            ? 'bionic/id/'.$this->id.'/attribute'.$override
            : 'bionic/id/'.$this->id.'/attribute';

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
            ? 'bionic/id/'.$this->id.'/augmentation'.$override
            : 'bionic/id/'.$this->id.'/augmentation';

        $result = $curl->get($get);

        if(isset($result['data'])) {
            foreach($result['data'] as $array) {
                $arrayList[] = new Augmentation(null, $array);
            }
        }

        return $arrayList;
    }

    // POST

    public function postAttribute() {
        global $component, $form, $curl;

        $component->h1('Add Attribute');
        $form->formStart([
            'do' => 'basic--has--value',
            'return' => 'content/bionic',
            'returnafter' => 'attribute',
            'context' => 'bionic',
            'context2' => 'attribute',
            'id' => $this->id
        ]);

        $list = $curl->get('attribute/special/0')['data'];

        $component->wrapStart();
        $form->select(true,'insert_id',$list,'Attribute','Which Attribute do you wish your bionic to have extra value in?');
        $form->number(true,'value','Value',null,null,1,8,1);
        $component->wrapEnd();

        $form->formEnd();
    }

    public function postAugmentation() {
        global $system;

        $system->contentSelectList('bionic','augmentation','post',$this->id,$system->getAugmentation());
    }

    // DELETE

    public function deleteAttribute() {
        global $system;

        $system->contentSelectList('bionic','attribute','delete',$this->id,$this->getAttribute());
    }

    public function deleteAugmentation() {
        global $system;

        $system->contentSelectList('bionic','augmentation','delete',$this->id,$this->getAugmentation());
    }

    // LIST

    public function listAttribute() {
        global $component;

        $list = $this->getAttribute();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name.' ('.$item->value.')', $item->description, $item->icon);
            }
        }

        $component->linkButton($this->siteLink.'/attribute/add','Add');
        $component->linkButton($this->siteLink.'/attribute/delete','Delete',true);
    }

    public function listAugmentation() {
        global $component;

        $list = $this->getAugmentation();

        if($list[0]) {
            foreach($list as $item) {
                $component->listItem($item->name, $item->description, $item->icon);
            }
        }

        $component->linkButton($this->siteLink.'/augmentation/add','Add');
        $component->linkButton($this->siteLink.'/augmentation/delete','Delete',true);
    }
}