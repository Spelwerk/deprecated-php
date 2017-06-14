<?php class Form {
    public function __construct() {}

    // INPUT

    public function varchar($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $value = null, $placeholder = null) {
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
            : null;

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        $inputPlaceholder = isset($placeholder)
            ? ' placeholder="'.$placeholder.'"'
            : null;

        echo(
            '<label for="item--'.$inputUnique.'">'.
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.
            '</label>'.
            '<input class="sw-js-validation" type="text" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'"'.$inputPlaceholder.$inputValue.$inputRequired.'/>'
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
            '<label for="item--'.$inputUnique.'">'.
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.
            '</label>'.
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

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<label for="item--'.$inputUnique.'">'.
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.
            '</label>'.
            '<textarea class="sw-c-input__item sw-js-validation" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'" rows="3"'.$inputRequired.'>'.$value.'</textarea>'
        );

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    public function pick($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $pickTrue = 'Yes', $pickFalse = 'No', $value = null) {
        $labelName = isset($label)
            ? $label
            : $uniqueName;

        $labelRequired = $required
            ? ' *'
            : null;

        $inputRequired = $required
            ? ' required'
            : null;

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        $inputValue = isset($value)
            ? $value
            : false;

        $radioTrueChecked = $inputValue == true
            ? ' checked'
            : null;

        $radioTrueHiddenTrue = $inputValue == false
            ? ' sw-is-hidden'
            : null;

        $radioTrueHiddenFalse = $inputValue == true
            ? ' sw-is-hidden'
            : null;

        $radioFalseHiddenTrue = $inputValue == true
            ? ' sw-is-hidden'
            : null;

        $radioFalseHiddenFalse = $inputValue == false
            ? ' sw-is-hidden'
            : null;

        $radioFalseChecked = $inputValue == false
            ? ' checked'
            : null;

        echo(
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.

            '<div class="sw-js-pick sw-c-pick">'.

            '<label for="item--'.$inputUnique.'--1">'.
            '<div class="sw-js-pick-item sw-c-pick__item">'.
            '<div class="sw-js-pick-true sw-c-pick__icon'.$radioTrueHiddenTrue.'"><img src="/img/color/radio-true.png"/></div>'.
            '<div class="sw-js-pick-false sw-c-pick__icon'.$radioTrueHiddenFalse.'"><img src="/img/color/radio-false.png"/></div>'.
            '<div class="sw-c-pick__text">'.$pickTrue.'</div>'.
            '<input class="sw-js-pick-input sw-is-hidden" type="radio" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'--1" value="1"'.$inputRequired.$radioTrueChecked.'/>'.
            '</div>'.
            '</label>'.

            '<label for="item--'.$inputUnique.'--0">'.
            '<div class="sw-js-pick-item sw-c-pick__item">'.
            '<div class="sw-js-pick-true sw-c-pick__icon'.$radioFalseHiddenTrue.'"><img src="/img/color/radio-true.png"/></div>'.
            '<div class="sw-js-pick-false sw-c-pick__icon'.$radioFalseHiddenFalse.'"><img src="/img/color/radio-false.png"/></div>'.
            '<div class="sw-c-pick__text">'.$pickFalse.'</div>'.
            '<input class="sw-js-pick-input sw-is-hidden" type="radio" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'--0" value="0"'.$inputRequired.$radioFalseChecked.'/>'.
            '</div>'.
            '</label>'.
            '</div>'
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
            '<label for="item--'.$uniqueName.'">'.
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.
            '</label>'.
            '<select class="sw-c-input__item" name="item--'.$uniqueName.'" id="item--'.$uniqueName.'"'.$inputRequired.'>'.
            '<option value="" disabled selected> -- select an option -- </option>'
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

    public function email($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $value = null) {
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
            : null;

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<label for="item--'.$inputUnique.'">'.
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.
            '</label>'.
            '<input class="sw-js-validation" type="email" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'" placeholder="e@mail.com"'.$inputValue.$inputRequired.'/>'
        );

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    public function password($required, $uniqueName, $label = null, $labelDescription = null, $uniqueId = null, $value = null) {
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
            : null;

        $inputUnique = isset($uniqueId)
            ? $uniqueName.'__'.$uniqueId
            : $uniqueName;

        echo(
            '<label for="item--'.$inputUnique.'">'.
            '<div class="sw-c-input__title">'.$labelName.$labelRequired.'</div>'.
            '</label>'.
            '<input class="sw-js-validation" type="password" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'"'.$inputValue.$inputRequired.'/>'
        );

        if($labelDescription) {
            echo('<div class="sw-c-input__description">'.$labelDescription.'</div>');
        }
    }

    // SPECIAL

    public function quick($options = null) {
        $postDo = isset($options['do'])
            ? '<input type="hidden" name="post--do" value="'.$options['do'].'"/>'
            : null;

        $postId = isset($options['id'])
            ? '<input type="hidden" name="post--id" value="'.$options['id'].'"/>'
            : null;

        $postUser = isset($options['user'])
            ? '<input type="hidden" name="post--user" value="'.$options['user'].'"/>'
            : null;

        $postReturn = isset($options['return'])
            ? '<input type="hidden" name="post--return" value="'.$options['return'].'"/>'
            : null;

        $postReturnId = isset($options['returnid'])
            ? '<input type="hidden" name="post--returnid" value="'.$options['returnid'].'"/>'
            : null;

        $postReturnAfter = isset($options['returnafter'])
            ? '<input type="hidden" name="post--returnafter" value="'.$options['returnafter'].'"/>'
            : null;

        $postContext = isset($options['context'])
            ? '<input type="hidden" name="post--context" value="'.$options['context'].'"/>'
            : null;

        $postContext2 = isset($options['context2'])
            ? '<input type="hidden" name="post--context2" value="'.$options['context2'].'"/>'
            : null;

        $postExtra = isset($options['extra'])
            ? '<input type="hidden" name="post--extra" value="'.$options['extra'].'"/>'
            : null;

        $postExtra2 = isset($options['extra2'])
            ? '<input type="hidden" name="post--extra2" value="'.$options['extra2'].'"/>'
            : null;

        $postIcon = isset($options['icon'])
            ? '<input class="sw-u-action" type="image" src="/img/'.$options['icon'].'.png" alt="Submit" />'
            : '<input class="sw-u-action" type="image" src="/img/missing_icon.png" alt="Submit" />';

        return
            '<form action="/post/post.php" method="post">'.
            $postDo.
            $postId.
            $postUser.
            $postReturn.
            $postReturnId.
            $postReturnAfter.
            $postContext.
            $postContext2.
            $postExtra.
            $postExtra2.
            $postIcon.
            '</form>';
    }

    public function hidden($uniqueName, $value, $type = null) {
        $inputType = isset($type)
            ? $type
            : 'item';

        echo('<input type="hidden" name="'.$inputType.'--'.$uniqueName.'" value="'.$value.'"/>');
    }

    // LIST

    public function radioList($itemList, $options = null) {
        $idList = isset($options['idList'])
            ? $options['idList']
            : null;

        $currentId = isset($options['currentId'])
            ? $options['currentId']
            : null;

        $tableName = isset($options['tableName'])
            ? $options['tableName']
            : 'insert_id';

        if(isset($itemList)) {
            foreach($itemList as $item) {
                $selected = false;

                if(!$idList || !in_array($item->id, $idList)) {
                    if($item->id == $currentId) {
                        $selected = true;
                    }

                    $this->radio($tableName, $item->name, $item->description, $item->id, $selected);
                }
            }
        }
    }

    public function checkboxList($itemList, $options = null) {
        $idList = isset($options['idList'])
            ? $options['idList']
            : null;

        if(isset($itemList)) {
            foreach($itemList as $item) {
                if(!$idList || !in_array($item->id, $idList)) {
                    $this->checkbox($item->name, $item->description, $item->id);
                }
            }
        }
    }

    // LIST COMPONENTS

    public function purchase($uniqueName, $label = null, $labelDescription = null, $labelIcon = null, $uniqueId = null, $minimum = null, $maximum = null, $value = null) {
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
            '<div class="sw-js-purchase-item sw-c-purchase">'.
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-purchase__head">'.
            '<div class="sw-c-purchase__icon"><img src="'.$labelIcon.'"/></div>'.
            '<div class="sw-c-purchase__title">'.$labelName.'</div>'.
            '<div class="sw-js-purchase-button sw-js-purchase-minus sw-c-purchase__action"><img src="/img/minus.png"/></div>'.
            '<div class="sw-js-purchase-value sw-c-purchase__value">'.$value.'</div>'.
            '<div class="sw-js-purchase-button sw-js-purchase-plus sw-c-purchase__action"><img src="/img/plus.png"/></div>'.
            '</div>'.
            '<div class="sw-c-purchase__body">'.
            '<div class="sw-c-purchase__text">'.
            $labelDescription.
            '</div>'.
            '</div>'.
            '<input type="number" class="sw-js-purchase-input sw-is-hidden" name="item--'.$inputUnique.'" id="item--'.$inputUnique.'"'.$inputMinimum.$inputMaximum.$inputValue.'/>'.
            '</div>'.
            '</div>'
        );
    }

    public function radio($tableName, $label, $labelDescription = null, $uniqueId = null, $selected = false) {
        if($selected) {
            $jsRadioItem = ' sw-is-selected';
            $jsRadioBody = null;
            $jsRadioTrue = null;
            $jsRadioFalse = ' sw-is-hidden';

            $inputSelected = ' selected';
        } else {
            $jsRadioItem = null;
            $jsRadioBody = ' sw-is-hidden';
            $jsRadioTrue = ' sw-is-hidden';
            $jsRadioFalse = null;

            $inputSelected = null;
        }

        echo(
            '<div class="sw-js-radio-item sw-c-list'.$jsRadioItem.'">'.
            '<div class="sw-l-wrap">'.
            '<label for="item--'.$uniqueId.'">'.
            '<input class="sw-js-radio sw-is-hidden" type="radio" name="item--'.$tableName.'" id="item--'.$uniqueId.'" value="'.$uniqueId.'"'.$inputSelected.'/>'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-js-radio-true sw-c-list__select'.$jsRadioTrue.'"><img src="/img/color/radio-true.png"/></div>'.
            '<div class="sw-js-radio-false sw-c-list__select'.$jsRadioFalse.'"><img src="/img/color/radio-false.png"/></div>'.
            '<div class="sw-js-radio-title sw-c-list__title">'.$label.'</div>'.
            '</div>'.
            '<div class="sw-js-radio-body sw-c-list__body'.$jsRadioBody.'">'.
            '<div class="sw-js-radio-info sw-c-list__text">'.
            $labelDescription.
            '</div>'.
            '</div>'.
            '</label>'.
            '</div>'.
            '</div>'
        );
    }

    public function checkbox($label, $labelDescription = null, $uniqueId = null, $selected = false) {
        $selected = $selected
            ? ' checked'
            : '';

        echo(
            '<div class="sw-js-checkbox-item sw-c-list">'.
            '<div class="sw-l-wrap">'.
            '<label for="item--'.$uniqueId.'">'.
            '<input class="sw-js-checkbox-input sw-is-hidden" type="checkbox" name="item--'.$uniqueId.'" id="item--'.$uniqueId.'" value="'.$uniqueId.'"'.$selected.'/>'.
            '<div class="sw-c-list__head">'.
            '<div class="sw-js-checkbox-true sw-c-list__select sw-is-hidden"><img src="/img/color/check-true.png"/></div>'.
            '<div class="sw-js-checkbox-false sw-c-list__select"><img src="/img/color/check-false.png"/></div>'.
            '<div class="sw-c-list__title">'.$label.'</div>'.
            '</div>'.
            '<div class="sw-js-checkbox-body sw-c-list__body sw-is-hidden">'.
            '<div class="sw-c-list__text">'.
            $labelDescription.
            '</div>'.
            '</div>'.
            '</div>'.
            '</div>'
        );
    }

    public function icon() {
        global $curl;

        $list = $curl->get('icon')['data'];

        echo('<h2>Select Icon</h2><div class="sw-c-iconlist">');

        foreach($list as $icon) {
            echo(
                '<label for="item--icon__'.$icon['id'].'">'.
                '<div class="sw-c-iconlist__item sw-js-icon-item">'.
                '<img src="'.$icon['path'].'"/>'.
                '</div>'.
                '<input class="sw-js-icon-radio sw-is-hidden" type="radio" name="item--icon" id="item--icon__'.$icon['id'].'" value="'.$icon['path'].'"/>'.
                '</label>'
            );
        }

        echo('</div>');
    }

    // POINTS

    public function points($points, $text = null) {
        $text = isset($text)
            ? $text
            : ' points';

        echo(
            '<div class="sw-js-points">'.
            '<div class="sw-c-points"><span class="sw-js-points-text">'.$points.'</span> '.$text.'</div>'.
            '<input type="hidden" class="sw-js-points-input" name="post--points" value="'.$points.'"/>'.
            '</div>'
        );
    }

    // FORM

    public function form($options = null) {
        $formAction = isset($options['action'])
            ? $options['action']
            : 'post/post.php';

        $postDo = isset($options['do']) && $options['do'] != null
            ? '<input type="hidden" name="post--do" value="'.$options['do'].'"/>'
            : null;

        $postSpecial = isset($options['special']) && $options['special'] != null
            ? '<input type="hidden" name="post--special" value="'.$options['special'].'"/>'
            : null;

        $postId = isset($options['id']) && $options['id'] != null
            ? '<input type="hidden" name="post--id" value="'.$options['id'].'"/>'
            : null;

        $postReturn = isset($options['return']) && $options['return'] != null
            ? '<input type="hidden" name="post--return" value="'.$options['return'].'"/>'
            : null;

        $postReturnId = isset($options['returnid']) && $options['returnid'] != null
            ? '<input type="hidden" name="post--returnid" value="'.$options['returnid'].'"/>'
            : null;

        $postReturnAfter = isset($options['returnafter']) && $options['returnafter'] != null
            ? '<input type="hidden" name="post--returnafter" value="'.$options['returnafter'].'"/>'
            : null;

        $postContext = isset($options['context']) && $options['context'] != null
            ? '<input type="hidden" name="post--context" value="'.$options['context'].'"/>'
            : null;

        $postContext2 = isset($options['context2']) && $options['context2'] != null
            ? '<input type="hidden" name="post--context2" value="'.$options['context2'].'"/>'
            : null;

        $postExtra = isset($options['extra']) && $options['extra'] != null
            ? '<input type="hidden" name="post--extra" value="'.$options['extra'].'"/>'
            : null;

        $postExtra2 = isset($options['extra2']) && $options['extra2'] != null
            ? '<input type="hidden" name="post--extra2" value="'.$options['extra2'].'"/>'
            : null;

        $postPoints = isset($options['points']) && $options['points'] != null
            ? '<input type="hidden" name="post--points" value="'.$options['points'].'"/>'
            : null;

        $postExperience = isset($options['experience']) && $options['experience'] != null
            ? '<input type="hidden" name="post--experience" value="'.$options['experience'].'"/>'
            : null;

        echo(
            '<form action="/'.$formAction.'" method="post">'.
            $postDo.
            $postSpecial.
            $postId.
            $postReturn.
            $postReturnId.
            $postReturnAfter.
            $postContext.
            $postContext2.
            $postExtra.
            $postExtra2.
            $postPoints.
            $postExperience
        );
    }

    public function submit($disabled = true, $submitText = null) {
        $class = $disabled
            ? ' sw-is-unclickable'
            : ' sw-is-clickable';

        $disabled = $disabled
            ? ' disabled'
            : null;

        $submitText = isset($submitText)
            ? $submitText
            : 'Save &raquo;';

        echo(
            '<input class="sw-js-submit'.$class.'" type="submit" value="'.$submitText.'"'.$disabled.'/>'.
            '</form>'
        );
    }

    // RANDOM

    public function randomRadio($title) {
        echo(
            '<div class="sw-l-wrap">'.
            '<div class="sw-js-randomizer sw-c-randomizer">'.
            '<button type="button" class="sw-js-random-radio sw-c-randomizer__button">'.
            '<div class="sw-c-randomizer__image">'.
            '<img class="" src="/img/dice.png"/>'.
            '<div class="sw-c-randomizer__rolltext">Click here to roll</div>'.
            '</div>'.
            '</button>'.
            '<div class="sw-js-random-title sw-c-randomizer__title">&nbsp;</div>'.
            '<div class="sw-js-random-info sw-c-randomizer__info">&nbsp;</div>'.
            '<div class="sw-c-randomizer__rollfor">Rolling for</div>'.
            '<div class="sw-c-randomizer__attribute">'.$title.'</div>'.
            '</div>'.
            '</div>'
        );
    }

    public function randomNumber($title, $times) {
        echo(
            '<div class="sw-l-wrap">'.
            '<div class="sw-js-randomizer sw-c-randomizer">'.
            '<button type="button" class="sw-js-random-number sw-c-randomizer__button" data-roll-type="'.$title.'" data-rolls="'.$times.'">'.
            '<div class="sw-c-randomizer__image">'.
            '<img class="" src="/img/dice.png"/>'.
            '<div class="sw-c-randomizer__rolltext">Click here to roll</div>'.
            '</div>'.
            '</button>'.
            '<div class="sw-js-random-value sw-c-randomizer__value">&nbsp;</div>'.
            '<div class="sw-c-randomizer__rollfor">Rolling for</div>'.
            '<div class="sw-c-randomizer__attribute">'.$title.'</div>'.
            '</div>'.
            '</div>'
        );
    }

    // VIEW

    public function viewStart() {
        echo(
            '<div class="sw-l-wrap">'.
            '<div class="sw-c-viewmore">'.
            '<button type="button" class="sw-js-viewmore sw-c-viewmore__button">'.
            '<div class="sw-c-viewmore__label">'.
            '<div class="sw-c-viewmore__text sw-js-view-text">decide yourself</div>'.
            '<div class="sw-c-viewmore__image">'.
            '<img class="sw-js-chevron-down" src="/img/chevron-down.png"/>'.
            '<img class="sw-js-chevron-up sw-is-hidden" src="/img/chevron-up.png"/>'.
            '</div>'.
            '</div>'.
            '</button>'.
            '</div>'.
            '</div>'.
            '<div class="sw-js-view-content sw-is-hidden">'
        );
    }

    public function viewEnd() {
        echo('</div>');
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

    public function pointsForm($points, $text) {
        echo(
            '<div class="sw-c-points">'.
            '<span class="sw-js-points-text">'.$points.'</span> '.$text.
            '</div>'.
            '<input type="hidden" class="sw-js-points-input" name="post--points" value="'.$points.'"/>'
        );
    }

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