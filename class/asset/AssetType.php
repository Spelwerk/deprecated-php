<?php class AssetType {
    var $id, $canon, $popularity, $name, $icon;

    var $group;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        echo $id;

        $data = isset($id)
            ? $curl->get('assettype/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('assettype',$this->id);

        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->icon = $data['icon'];

        $this->group = $data['assetgroup_id'];

        $this->siteLink = '/content/assettype/'.$this->id;
    }

    public function put() {} //todo

    public function view() {
        global $component;

        $component->returnButton('/content/assettype');

        $component->roundImage($this->icon);
        $component->h1('Data');
        $component->p('Group ID: '.$this->group);

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}