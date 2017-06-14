<?php class Meeting {
    var $id, $name, $description, $notes;

    var $story;

    var $isOwner;

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

        $this->isOwner = $this->verifyStoryOwner();
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo

    // PRIVATE

    private function verifyStoryOwner() {
        global $curl, $user;

        if($user->isAdmin) return true;

        $result = $curl->get('user/id/'.$user->id.'/story/'.$this->story);

        $isOwner = isset($result['data']) ? intval($result['data']['owner']) : false;

        return $isOwner;
    }
}