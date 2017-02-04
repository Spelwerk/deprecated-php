<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 11:19
 */
class Form {
    public function __construct() {}


    public function getVarchar($tableName, $name, $required, $value = null) {
        $reqLabel = $required ? '*' : '';

        $val = isset($value) ? ' value="'.$value.'"' : '';
        $req = $required ? ' required' : '';

        echo(
            '<label for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<br>'.
            '<input type="text" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$val.$req.'/>'.
            '<br>'
        );
    }

    public function getText($tableName, $name, $required, $value = null) {
        $reqLabel = $required ? '*' : '';

        $val = isset($value) ? ' value="'.$value.'"' : '';
        $req = $required ? ' required' : '';

        echo(
            '<label for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<br>'.
            '<textarea name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'" rows="4" cols="50"'.$val.$req.'></textarea>'.
            '<br>'
        );
    }

    public function getNumber($tableName, $name, $required, $minimum = null, $maximum = null, $value = null) {
        $reqLabel = $required ? '*' : '';

        $min = isset($minimum) ? ' min="'.$minimum.'"' : '';
        $max = isset($maximum) ? ' max="'.$maximum.'"' : '';
        $val = isset($value) ? ' value="'.$value.'"' : '';
        $req = $required ? ' required' : '';

        echo(
            '<label for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<br>'.
            '<input type="number" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$min.$max.$val.$req.'/>'.
            '<br>'
        );
    }

    public function getBool($tableName, $name, $required, $value = null) {
        $reqLabel = $required ? '*' : '';

        $checkedTrue = $value === 1 ? ' checked' : '';
        $checkedFalse = $value === 0 ? ' checked' : '';

        $req = $required ? ' required' : '';

        echo(
            '<label for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<br>'.
            '<input type="radio" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'" value="1"'.$req.$checkedTrue.'/> True'.
            '<br>'.
            '<input type="radio" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'" value="0"'.$req.$checkedFalse.'/> False'.
            '<br>'
        );
    }

    public function getForeignKey($tableName, $name, $foreignTable, $required, $value = null) {
        global $curl;

        $data = $curl->get($foreignTable)['data'];

        $reqLabel = $required ? '*' : '';

        $req = $required ? ' required' : '';

        $defaultSelected = isset($value) ? '' : ' selected';
        $defaultDisabled = $required ? ' disabled' : '';
        $sendZero = $required ? '-- SELECT ONE --' : '';

        echo(
            '<label for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<br>'.
            '<select name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$req.'>'.
            '<option value="0"'.$defaultDisabled.$defaultSelected.'>'.$sendZero.'</option>'
        );

        foreach($data as $row) {
            $selected = $value == $row['id'] ? ' selected' : '';

            echo('<option value="'.$foreignTable.'--'.$row['id'].'"'.$selected.'>'.$row['name'].'</option>');
        }

        echo('</select><br>');
    }

    public function getHidden($tableName, $name, $value) {
        echo('<input type="hidden" name="'.$tableName.'--'.$name.'" value="'.$value.'"/>');
    }

    public function getSelect($tableName, $name, $selectName, $selectId) {
        echo(
            '<label for="'.$name.'--'.$selectId.'">'.$selectName.'</label>'.
            '<input type="radio" name="'.$tableName.'--'.$name.'" id="'.$name.'--'.$selectId.'" value="'.$selectId.'"/>'.
            '<br>'
        );
    }

    public function getPurchase($skillName, $skillId, $skillMaximum, $value = null) {
        $min = ' min="0"';
        $max = isset($skillMaximum) ? ' max="'.$skillMaximum.'"' : '';
        $val = isset($value) ? ' value="'.$value.'"' : '';

        echo(
            '<label for="skill--'.$skillId.'">'.$skillName.'</label>'.
            '<br>'.
            '<input type="number" name="skill--'.$skillId.'" id="skill--'.$skillId.'"'.$min.$max.$val.'/>'.
            '<br>'
        );
    }


    public function genericSelect($tableName, $name, $array) {
        foreach($array as $object) {
            $this->getSelect($tableName, $name, $object->name, $object->id);
        }
    }

    public function genericStart($action = null) {
        $link = isset($action)
            ? $action
            : '/post.php';

        echo('<form action="'.$link.'" method="post">');
    }

    public function genericEnd() {
        echo('<input type="submit" value="Next &raquo;"/></form>');
    }


}