<?php class Doctrine {
    var $id, $canon, $popularity, $name, $description, $icon;

    var $manifestation;

    var $value;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('doctrine/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $defaults = $curl->get('system/doctrine');

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->maximum = $defaults['maximum'];

        $this->manifestation = $data['manifestation_id'];
        $this->expertise = $data['expertise_id'];

        $this->value = isset($data['value']) ? $data['value'] : 0;

        $this->siteLink = '/content/doctrine/'.$this->id;
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}