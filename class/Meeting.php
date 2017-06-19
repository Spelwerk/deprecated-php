<?php class Meeting {
    var $id, $name, $description, $notes;

    var $story;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('meeting/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->notes = $data['notes'];

        $this->story = isset($data['story_id'])
            ? $data['story_id']
            : null;
    }

    public function verifyOwner() {
        global $system;

        return $system->verifyOwner('story', $this->story);
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}