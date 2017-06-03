<?php global $form, $component;

$component->wrapStart();
$form->formStart([
    'do' => 'user--logout',
    'return' => 'user'
]);
$form->formEnd(false,'Logout');
?>