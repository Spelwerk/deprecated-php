<?php class AssetGroup {
    var $id, $canon, $popularity, $name;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('assetgroup/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];

        $this->siteLink = '/content/assetgroup/'.$this->id;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('assetgroup', $this->id);
    }

    public function put() {} //todo

    public function view() {
        global $component;

        $component->returnButton('/content/assetgroup');

        if($this->verifyOwner()) {
            $component->h1('Manage');
            $component->linkButton($this->siteLink.'/edit','Edit');
        }
    }

    public function delete() {} //todo
}