<?php class Software {
    var $id, $name, $canon, $popularity, $description, $icon, $price, $legal;

    var $hacking, $hackingBonus;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('software/id/'.$id)['data'][0]
            : $array;

        $this->isOwner = $system->verifyOwner($data);

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->legal = $data['legal'];

        $this->icon = '/img/color/software.png';

        $this->hacking = $data['hacking'];
        $this->hackingBonus = $data['hacking_bonus'];
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}