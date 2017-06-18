<?php class Location {
    var $id, $name, $description;

    var $person;

    var $location;

    var $isOwner;

    public function __construct($id = null, $array = null) {
        global $curl, $system;

        $data = isset($id)
            ? $curl->get('location/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->isOwner = $system->verifyOwner('location',$this->id);

        $this->name = $data['name'];
        $this->description = $data['description'];

        $this->person = isset($data['person_id'])
            ? $data['person_id']
            : null;

        $this->location = isset($data['location_id'])
            ? $data['location_id']
            : null;
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}