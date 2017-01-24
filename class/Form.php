<?php

/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 2016-12-08
 * Time: 11:19
 */
class Form {
    public function __construct() {}

    public function radio($table, $objectList) {
        foreach($objectList as $Object) {
            echo(
                '<label for="'.$table.'--'.$Object->id.'">'.$Object->name.'</label>'.
                '<input type="radio" name="'.$table.'" id="'.$table.'--'.$Object->id.'" value="'.$table.'--'.$Object->id.'">'.$Object->name.'</radio>'
            );
        }
    }

    public function select($table, $objectList) {
        echo(
            '<div>'.
            '<label for="'.$table.'--'.$Object->id.'">'.$Object->name.'</label><br>'.
            '<select name="'.$table.'" id="'.$table.'--'.$Object->id.'">'.
            '<option value="0" disabled selected>-- SELECT ONE --</option>'
        );

        foreach($objectList as $Object) {
            echo(
                '<option value="'.$table.'--'.$Object->id.'">'.$Object->name.'</option>'
            );
        }

        echo(
            '</select>'.
            '<br><br>'.
            '</div>'
        );
    }
}