<?php global $form, $component;

$component->wrapStart();
$form->form([
    'special' => 'user',
    'do' => 'logout',
    'return' => 'user'
]);
$form->submit(false,'Logout');
?>