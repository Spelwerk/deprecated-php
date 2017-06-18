<?php class Sanity {
    var $id, $canon, $popularity, $name, $icon;

    var $heal, $lethal;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('sanity/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->popularity = $data['popularity'];
        $this->name = $data['name'];
        $this->icon = 'http://cdn.spelwerk.com/file/9bc8f45b21ffb3ef3ebd179309e1266a140db646.png';

        $this->heal = isset($data['heal'])
            ? $data['heal']
            : null;

        $this->healIcon = 'http://cdn.spelwerk.com/file/a473858b0c13007cfbbd302e938cebb1648ad234.png';

        $this->double = isset($data['timestwo'])
            ? $data['timestwo']
            : null;

        $this->value = $this->double
            ? 2
            : 1;
    }

    public function put() {} //todo

    public function view() {} //todo

    public function delete() {} //todo
}