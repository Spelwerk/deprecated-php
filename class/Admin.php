<?php class Admin {
    public function __construct() {}

    public function makeTable($tableName) {
        global $curl;

        $data = $curl->get($tableName)['data'];

        echo('<table><thead><tr>');

        foreach($data[0] as $key => $row) {
            echo('<th>' . $key . '</th>');
        }

        echo('</tr></thead><tbody><tr>');

        foreach($data as $row) {
            echo('<tr>');
            foreach($row as $field) {
                echo('<td>' . $field . '</td>');
            }
            echo('</tr>');
        }

        echo('</tr></tbody></table>');
    }

    public function makeAdd($tableName) {
        global $curl, $form;

        $table = $curl->get($tableName.'/help')['data'];

        echo('<form>');

        foreach($table as $col) {
            $field = $col['Field'];
            $type = $col['Type'];

            $req = $col['Null'] == 'YES' ? false : true;

            if(!in_array($field,['id','hash','created','deleted','updated','icon_id'])) {

                if(strpos($type, 'int') !== false && $col['Key'] == 'MUL') {
                    $explode = explode('_', $field);
                    $position = count($explode) - 2;

                    $foreignTable = $explode[$position];

                    $form->getForeignKey($tableName, $field, $foreignTable, $req);
                }

                else if(strpos($type, 'int') !== false && strpos($type, 'tinyint') === false && $col['Key'] !== 'MUL') {
                    $form->getNumber($tableName, $field, $req);
                }

                else if(strpos($type, 'tinyint') !== false) {
                    $form->getBool($tableName, $field, $req);
                }

                else if(strpos($type, 'text') !== false) {
                    $form->getText($tableName, $field, $req);
                }

                else if(strpos($type, 'varchar') !== false) {
                    $form->getVarchar($tableName, $field, $req);
                }
            }
        }

        echo('</form>');
    }

    public function makeEdit($tableName, $id) {
        global $curl, $form;

        $data = $curl->get($tableName.'/id/'.$id)['data'][0];
        $help = $curl->get($tableName.'/help')['data'];

        echo('<form>');

        foreach($help as $col) {
            $field = $col['Field'];
            $type = $col['Type'];

            $req = $col['Null'] == 'YES' ? false : true;

            if(!in_array($field,['id','hash','created','deleted','updated','icon_id'])) {

                if(strpos($type, 'int') !== false && $col['Key'] == 'MUL') {
                    $explode = explode('_', $field);
                    $position = count($explode) - 2;

                    $foreignTable = $explode[$position];

                    $form->getForeignKey($tableName, $field, $foreignTable, $req, $data[$field]);
                }

                else if(strpos($type, 'int') !== false && strpos($type, 'tinyint') === false && $col['Key'] !== 'MUL') {
                    $form->getNumber($tableName, $field, $req, null, null, $data[$field]);
                }

                else if(strpos($type, 'tinyint') !== false) {
                    $form->getBool($tableName, $field, $req, $data[$field]);
                }

                else if(strpos($type, 'text') !== false) {
                    $form->getText($tableName, $field, $req, $data[$field]);
                }

                else if(strpos($type, 'varchar') !== false) {
                    $form->getVarchar($tableName, $field, $req, $data[$field]);
                }
            }
        }

        echo('</form>');


    }
}