<?php class Attribute {
    var $id, $canon, $name, $description, $icon;

    var $type, $maximum;

    var $value;

    public function __construct($id = null, $array = null) {
        global $curl;

        $data = isset($id)
            ? $curl->get('attribute/id/'.$id)['data'][0]
            : $array;

        $this->id = $data['id'];
        $this->canon = $data['canon'];
        $this->name = $data['name'];
        $this->description = $data['description'];
        $this->icon = $data['icon'];

        $this->type = isset($data['attributetype_id']) ? $data['attributetype_id'] : null;
        $this->maximum = isset($data['maximum']) ? $data['maximum'] : 0;

        $this->value = isset($data['value']) ? $data['value'] : 0;
    }
}