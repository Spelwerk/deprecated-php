<?php class AssetGroup {
    var $id, $canon, $popularity, $name;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        echo $id;

        $data = isset($id)
            ? $curl->get('assetgroup/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];

        $this->siteLink = '/content/assetgroup/'.$this->id;
    }

    public function put() {} //todo

    public function view() {
        global $component;

        $component->returnButton('/content/assetgroup');

        if($this->isOwner) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}