<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 11:19
 */
class Form {
    public function __construct() {}

    // refactored
    public function varchar($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $value = null) {
        $labelName = isset($label)
            ? $label
            : $uniqueName;

        $labelRequired = $required
            ? ' *'
            : null;

        $inputRequired = $required
            ? ' required'
            : null;

        $inputValue = isset($value)
            ? ' value="'.$value.'"'
            : '';

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<label class="sw-c-input__label" for="item--'.$inputUnique.'">'.$labelName.$labelRequired.'</label>'.
            '<input class="sw-c-input__item sw-js-validation" type="text" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'"'.$inputValue.$inputRequired.'/>'
        );

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    public function number($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $minimum = null, $maximum = null, $value = null) {
        $labelName = isset($label)
            ? $label
            : $uniqueName;

        $labelRequired = $required
            ? ' *'
            : null;

        $inputRequired = $required
            ? ' required'
            : null;

        $inputMinimum = isset($minimum)
            ? ' min="'.$minimum.'"'
            : null;

        $inputMaximum = isset($maximum)
            ? ' max="'.$maximum.'"'
            : '';

        $inputValue  = isset($value)
            ? ' value="'.$value.'"'
            : '';

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<label class="sw-c-input__label" for="item--'.$inputUnique.'">'.$labelName.$labelRequired.'</label>'.
            '<input class="sw-c-input__item sw-js-number sw-js-validation" type="number" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'"'.$inputMinimum.$inputMaximum.$inputValue.$inputRequired.'/>'
        );

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    public function text($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $value = null) {
        $labelName = isset($label)
            ? $label
            : $uniqueName;

        $labelRequired = $required
            ? ' *'
            : null;

        $inputRequired = $required
            ? ' required'
            : null;

        $inputValue = isset($value)
            ? ' value="'.$value.'"'
            : '';

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<label class="sw-c-input__label" for="item--'.$inputUnique.'">'.$labelName.$labelRequired.'</label>'.
            '<textarea class="sw-c-input__item sw-js-validation" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'" rows="3"'.$inputValue.$inputRequired.'></textarea>'
        );

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    public function select($required, $uniqueName, $list, $label = null, $labelDescription = null, $value = null) {
        $labelName = isset($label)
            ? $label
            : $uniqueName;

        $labelRequired = $required
            ? ' *'
            : null;

        $inputRequired = $required
            ? ' required'
            : null;

        echo(
            '<label class="sw-c-input__label" for="item--'.$uniqueName.'">'.$labelName.$labelRequired.'</label>'.
            '<select class="sw-c-input__item" name="item--'.$uniqueName.'" id="item--'.$uniqueName.'"'.$inputRequired.'>'.
            '<option disabled selected> -- select an option -- </option>'
        );

        foreach($list as $item) {
            $optionSelected = isset($value) && $item['id'] == $value
                ? ' selected'
                : null;

            echo('<option value="'.$item['id'].'"'.$optionSelected.'>'.$item['name'].'</option>');
        }

        echo('</select>');

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    public function hidden($uniqueName, $value, $type = null) {
        $inputType = isset($type)
            ? $type
            : 'item';

        echo('<input type="hidden" name="'.$inputType.'--'.$uniqueName.'" value="'.$value.'"/>');
    }

    public function icon() {
        global $curl;

        $list = $curl->get('icon')['data'];

        echo(
            '<h3>Select Icon</h3>'.
            '<div class="sw-l-iconlist">'
        );

        foreach($list as $icon) {
            echo(
                '<label for="item--icon__'.$icon['id'].'">'.
                '<div class="sw-l-iconlist__item sw-js-icon-item">'.
                '<img src="'.$icon['path'].'"/>'.
                '</div>'.
                '<input class="sw-js-icon-radio sw-is-hidden" type="radio" name="item--icon" id="item--icon__'.$icon['id'].'" value="'.$icon['id'].'"/>'.
                '</label>'
            );
        }

        echo('</div>');
    }

    public function purchase($uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $minimum = null, $maximum = null, $value = null) {
        $labelName = isset($label)
            ? $label
            : $uniqueName;

        $inputMinimum = isset($minimum)
            ? ' min="'.$minimum.'"'
            : null;

        $inputMaximum = isset($maximum)
            ? ' max="'.$maximum.'"'
            : '';

        $inputValue  = isset($value)
            ? ' value="'.$value.'"'
            : '';

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<div class="sw-c-purchase sw-js-purchase-item">'.
            '<div class="sw-c-purchase__head">'.
            '<div class="sw-c-purchase__image">'.
            '<img src="/img/missing_icon.png"/>'.
            '</div>'.
            '<div class="sw-c-purchase__title">'.$labelName.'</div>'.
            '<div class="sw-c-purchase__button">'.
            '<button type="button" class="sw-js-purchase-button sw-js-purchase-minus">'.
            '<img src="/img/minus.png"/>'.
            '</button>'.
            '</div>'.
            '<div class="sw-c-purchase__value sw-js-purchase-value">'.$value.'</div>'.
            '<div class="sw-c-purchase__button">'.
            '<button type="button" class="sw-js-purchase-button sw-js-purchase-plus">'.
            '<img src="/img/plus.png"/>'.
            '</button>'.
            '</div>'.
            '</div>'.
            '<div class="sw-c-purchase__info">'.$labelDescription.'</div>'.
            '<input type="number" class="sw-js-purchase-input sw-is-hidden" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'"'.$inputMinimum.$inputMaximum.$inputValue.'/>'.
            '</div>'
        );
    }


    // needs refactoring
    public function getVarchar($tableName, $name, $required, $value = null) {
        $reqLabel = $required
            ? '*'
            : null;

        $val = isset($value)
            ? ' value="'.$value.'"'
            : null;

        $req = $required
            ? ' required'
            : null;

        echo(
            '<label class="sw-c-input__label" for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<input class="sw-c-input__item sw-js-validation" type="text" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$val.$req.'/>'
        );
    }

    public function getText($tableName, $name, $required, $value = null) {
        $reqLabel = $required ? '*' : '';

        $val = isset($value) ? ' value="'.$value.'"' : '';
        $req = $required ? ' required' : '';

        echo(
            '<label class="sw-c-input__label" for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<textarea class="sw-c-input__item sw-js-validation" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'" rows="3"'.$val.$req.'></textarea>'
        );
    }

    public function getNumber($tableName, $name, $required, $minimum = null, $maximum = null, $value = null) {
        $reqLabel = $required ? '*' : '';

        $min = isset($minimum)
            ? ' min="'.$minimum.'"'
            : '';

        $max = isset($maximum)
            ? ' max="'.$maximum.'"'
            : '';

        $val = isset($value)
            ? ' value="'.$value.'"'
            : '';

        $req = $required
            ? ' required'
            : '';

        echo(
            '<label class="sw-c-input__label" for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<input class="sw-c-input__item sw-js-number sw-js-validation" type="number" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$min.$max.$val.$req.'/>'
        );
    }

    public function getBool($tableName, $name, $required, $value = null) {
        $reqLabel = $required ? '*' : '';

        $checkedTrue = $value === 1
            ? ' checked'
            : '';

        $checkedFalse = $value === 0
            ? ' checked'
            : '';

        $req = $required
            ? ' required'
            : '';

        echo(
            '<div class="sw-c-input__label">'.$name.$reqLabel.'</div>'.

            '<div class="sw-c-input__bool sw-js-bool">'.

            '<label for="'.$tableName.'--'.$name.'--1">'.
            '<div class="sw-c-input__bool__item sw-js-input-item">'.
            '<img class="sw-js-radio-false" src="/img/radio-false.png"/>'.
            '<img class="sw-js-radio-true sw-is-hidden" src="/img/radio-true.png"/>'.
            '<div class="sw-c-input__bool__text">Yes</div>'.
            '<input class="sw-js-input-radio sw-is-hidden" type="radio" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'--1" value="1"'.$req.'/>'.
            '</div>'.
            '</label>'.

            '<label for="'.$tableName.'--'.$name.'--0">'.
            '<div class="sw-c-input__bool__item sw-js-input-item">'.
            '<img class="sw-js-radio-false sw-is-hidden" src="/img/radio-false.png"/>'.
            '<img class="sw-js-radio-true" src="/img/radio-true.png"/>'.
            '<div class="sw-c-input__bool__text">No</div>'.
            '<input class="sw-js-input-radio sw-is-hidden" type="radio" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'--0" value="0"'.$req.' checked/>'.
            '</div>'.
            '</label>'.

            '</div>'
        );
    }

    public function getDropdown($tableName, $name, $required, $list, $value = null) {
        $reqLabel = $required
            ? '*'
            : '';

        $req = $required
            ? ' required'
            : '';

        echo(
            '<label class="sw-c-input__label" for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<select class="sw-c-input__item" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$req.'>'.
            '<option disabled selected value="jonn"> -- select an option -- </option>'
        );

        foreach($list as $option) {
            $slc = isset($value) && $option['id'] == $value
                ? ' selected'
                : null;

            echo('<option value="'.$option['id'].'"'.$slc.'>'.$option['name'].'</option>');
        }

        echo('</select>');
    }

    public function getHidden($tableName, $name, $value) {
        echo('<input type="hidden" name="'.$tableName.'--'.$name.'" value="'.$value.'"/>');
    }

    public function getRadio($tableName, $name, $selectName, $selectId, $description, $selected = null) {
        $s = isset($selected)
            ? ' selected'
            : '';

        echo(
            '<label for="'.$name.'--'.$selectId.'">'.
            '<div class="sw-c-radio__item sw-js-radio-item">'.
            '<div class="sw-c-radio__header">'.
            '<div class="sw-c-radio__radio">'.
            '<img class="sw-js-radio-false" src="/img/radio-false.png"/>'.
            '<img class="sw-js-radio-true sw-is-hidden" src="/img/radio-true.png"/>'.
            '</div>'.
            '<div class="sw-c-radio__title sw-js-radio-title">'.$selectName.'</div>'.
            '</div>'.
            '<div class="sw-c-radio__info sw-js-radio-info sw-is-hidden">'.$description.'</div>'.
            '<div class="sw-js-radio-input sw-is-hidden">'.
            '<input class="sw-js-radio" type="radio" name="'.$tableName.'--'.$name.'" id="'.$name.'--'.$selectId.'" value="'.$selectId.'"'.$s.'/></div></div></label>'
        );
    }

    public function getCheckbox($tableName, $rowName, $rowId, $description, $selected = null) {
        $s = isset($selected)
            ? ' checked'
            : '';

        echo(
            '<label for="'.$tableName.'--'.$rowId.'">'.
            '<div class="sw-c-radio__item sw-js-check-item">'.
            '<div class="sw-c-radio__header">'.
            '<div class="sw-c-radio__radio">'.
            '<img class="sw-js-check-false" src="/img/checkbox-false.png"/>'.
            '<img class="sw-js-check-true sw-is-hidden" src="/img/checkbox-true.png"/>'.
            '</div>'.
            '<div class="sw-c-radio__title sw-js-check-title">'.$rowName.'</div>'.
            '</div>'.
            '<div class="sw-c-radio__info sw-js-check-info sw-is-hidden">'.$description.'</div>'.
            '<input class="sw-js-check sw-is-hidden" type="checkbox" name="'.$tableName.'--'.$rowId.'" id="'.$tableName.'--'.$rowId.'" value="'.$rowId.'"'.$s.'/>'.
            '</div>'.
            '</label>'
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
            '<label class="sw-c-input__label" for="'.$tableName.'--'.$name.'">'.$name.$reqLabel.'</label>'.
            '<select class="sw-c-input__item" name="'.$tableName.'--'.$name.'" id="'.$tableName.'--'.$name.'"'.$req.'>'.
            '<option value="0"'.$defaultDisabled.$defaultSelected.'>'.$sendZero.'</option>'
        );

        foreach($data as $row) {
            $selected = $value == $row['id'] ? ' selected' : '';

            echo('<option value="'.$foreignTable.'--'.$row['id'].'"'.$selected.'>'.$row['name'].'</option>');
        }

        echo('</select><br>');
    }

    public function getPurchase($rowName, $rowId, $rowDescription, $rowMax, $value = null, $noMin = null) {

        if(!$noMin) {
            $min = isset($value)
                ? ' min="'.$value.'"'
                : ' min="0"';
        } else {
            $min = null;
        }


        $max = isset($rowMax)
            ? ' max="'.$rowMax.'"'
            : '';

        $val = isset($value)
            ? ' value="'.$value.'"'
            : '';

        $desc = isset($rowDescription)
            ? $rowDescription
            : '';

        echo(
            '<div class="sw-c-purchase sw-js-purchase-item">'.
            '<div class="sw-c-purchase__head">'.
            '<div class="sw-c-purchase__image">'.
            '<img src="/img/missing_icon.png"/>'.
            '</div>'.
            '<div class="sw-c-purchase__title">'.$rowName.'</div>'.
            '<div class="sw-c-purchase__button">'.
            '<button type="button" class="sw-js-purchase-button sw-js-purchase-minus">'.
            '<img src="/img/minus.png"/>'.
            '</button>'.
            '</div>'.
            '<div class="sw-c-purchase__value sw-js-purchase-value">'.$value.'</div>'.
            '<div class="sw-c-purchase__button">'.
            '<button type="button" class="sw-js-purchase-button sw-js-purchase-plus">'.
            '<img src="/img/plus.png"/>'.
            '</button>'.
            '</div>'.
            '</div>'.
            '<div class="sw-c-purchase__info">'.$desc.'</div>'.
            '<input type="number" class="sw-js-purchase-input sw-is-hidden" name="purchase--'.$rowId.'" id="purchase--'.$rowId.'"'.$min.$max.$val.'/>'.
            '</div>'
        );
    }


    // Generic
    public function genericSelect($tableName, $name, $array, $value = null) {
        foreach($array as $object) {
            $this->getRadio($tableName, $name, $object->name, $object->id, $object->description);
        }
    }

    public function genericStart($action = null) {
        $link = isset($action)
            ? $action
            : 'post.php';

        echo('<form action="/'.$link.'" method="post">');
    }

    public function genericEnd($disabled = true) {
        $cls = $disabled
            ? ' sw-is-unclickable'
            : ' sw-is-clickable';

        $dsb = $disabled
            ? ' disabled'
            : null;

        echo(
            '<input class="sw-c-submit sw-js-submit'.$cls.'" type="submit" value="Save &raquo;"'.$dsb.'/>'.
            '</form>'
        );
    }


    // Roll
    public function rollNumber($name, $times) {
        echo(
            '<div class="sw-c-randomizer sw-js-randomizer">'.
            '<button type="button" class="sw-c-randomizer__button sw-js-random-number" data-roll-type="'.$name.'" data-rolls="'.$times.'">'.
            '<div class="sw-c-randomizer__image">'.
            '<img class="" src="/img/dice.png"/>'.
            '<div class="sw-c-randomizer__rolltext">Click here to roll</div>'.
            '</div>'.
            '</button>'.
            '<div class="sw-c-randomizer__value sw-js-random-value">&nbsp;</div>'.
            '<div class="sw-c-randomizer__rollfor">Rolling for</div>'.
            '<div class="sw-c-randomizer__attribute">'.$name.'</div>'.
            '</div>'
        );
    }

    public function rollRadio($name) {
        echo(

            '<div class="sw-c-randomizer sw-js-randomizer">'.
            '<button type="button" class="sw-c-randomizer__button sw-js-random-radio">'.
            '<div class="sw-c-randomizer__image">'.
            '<img class="" src="/img/dice.png"/>'.
            '<div class="sw-c-randomizer__rolltext">Click here to roll</div>'.
            '</div>'.
            '</button>'.
            '<div class="sw-c-randomizer__title sw-js-random-title">&nbsp;</div>'.
            '<div class="sw-c-randomizer__info sw-js-random-info">&nbsp;</div>'.
            '<div class="sw-c-randomizer__rollfor">Rolling for</div>'.
            '<div class="sw-c-randomizer__attribute">'.$name.'</div>'.
            '</div>'
        );
    }


    // View
    public function viewStart() {
        echo(
            '<div class="sw-c-viewmore">'.
            '<button type="button" class="sw-c-viewmore__button sw-js-view-button">'.
            '<div class="sw-c-viewmore__label">'.
            '<div class="sw-c-viewmore__text sw-js-view-text">decide yourself</div>'.
            '<div class="sw-c-viewmore__image">'.
            '<img class="sw-js-chevron-down" src="/img/chevron-down.png"/>'.
            '<img class="sw-js-chevron-up sw-is-hidden" src="/img/chevron-up.png"/>'.
            '</div>'.
            '</div>'.
            '</button>'.
            '</div>'.
            '<div class="sw-js-view-content sw-is-hidden">'
        );
    }

    public function viewEnd() {
        echo('</div>');
    }


    // Points
    public function pointsForm($points, $text) {
        echo(
            '<div class="sw-c-points">'.
            '<span class="sw-js-points-text">'.$points.'</span> '.$text.
            '</div>'.
            '<input type="hidden" class="sw-js-points-input" name="post--points" value="'.$points.'"/>'
        );
    }


    // Print
    public function printPerson($tableData, $header) {

        echo('<div class="sw-l-table"><h3>'.$header.'</h3>');

        foreach($tableData as $person) {

            $hash = isset($person['person_hash'])
                ? '/'.$person['person_hash']
                : '';

            $owner = isset($person['person_hash'])
                ? '<div class="sw-l-table__image"><img title="owner" src="/img/user-owner.png"/></div>'
                : null;

            echo(
                '<div class="sw-l-table__row">'.
                '<a class="sw-l-table__link" href="/play/'.$person['person_id'].$hash.'">'.
                '<div class="sw-l-table__col">'.$person['nickname'].'</div>'.
                $owner.
                '</a>'.
                '</div>'
            );
        }

        echo('</div>');
    }

    public function printTableRow($title, $link, $id, $hash = null) {
        $linkHash = isset($hash)
            ? '/'.$hash
            : null;

        $owner = isset($hash)
            ? '<div class="sw-l-table__image"><img title="owner" src="/img/user-owner.png"/></div>'
            : null;

        echo(
            '<div class="sw-l-table__row">'.
            '<a class="sw-l-table__link" href="'.$link.$id.$linkHash.'">'.
            '<div class="sw-l-table__col">'.$title.'</div>'.
            $owner.
            '</a>'.
            '</div>'
        );
    }
}