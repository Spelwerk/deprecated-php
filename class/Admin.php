<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 01/02/2017
 * Time: 14:49
 */
class Admin {
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

    public function createWorld($world = null) {
        if(!$world) {
            echo '<h2>Create World</h2>';
            $this->worldMakeStart();
        }
    }

    public function worldMakeStart() {
        global $form, $curl;

        $attributetype = $curl->get('attributetype')['data'];
        $expertisetype = $curl->get('expertisetype')['data'];

        $form->genericStart();
        $form->getHidden('post', 'return', 'play');
        $form->getHidden('post', 'do', 'person--post');

        $form->getVarchar('world', 'name', true);

        $form->getBool('world', 'template', true);
        $form->getBool('world', 'bionic', true);
        $form->getBool('world', 'augmentation', true);
        $form->getBool('world', 'software', true);
        $form->getBool('world', 'supernatural', true);

        $form->getDropdown('world', 'skill_attributetype_id', true, $attributetype);
        $form->getDropdown('world', 'attribute_expertisetype_id', true, $expertisetype);
        $form->getDropdown('world', 'dice_expertisetype_id', true, $expertisetype);

        $form->genericEnd();
    }
}