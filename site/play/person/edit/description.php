<?php global $component, $form, $person, $sitemap;

if($person->isOwner) {
    $component->h2('Description');
    $component->wrapStart();
    $form->formStart([
        'do' => 'person--edit--description',
        'id' => $person->id,
        'secret' => $person->secret,
        'return' => 'play/person/id'
    ]);
    $form->varchar(true, 'nickname', 'Nickname', null, null, $person->nickname);
    $form->varchar(true, 'firstname', 'First Name', null, null, $person->firstname);
    $form->varchar(true, 'surname', 'Surname', null, null, $person->surname);
    $form->varchar(true, 'drive', 'Drive', 'What drives your character forward?', null, $person->drive);
    $form->varchar(true, 'pride', 'Pride', 'What is the thing your character is most proud of?', null, $person->pride);
    $form->varchar(true, 'problem', 'Problem', 'What kind of problem does your character fight with?', null, $person->problem);
    $form->varchar(true, 'gender', 'Gender', null, null, $person->gender);
    $form->number(true, 'age', 'Age', 'When changing age after creation, the system will no longer change any other variables.', null, 5, $person->species->maxAge, $person->age);
    $form->text(false, 'description', 'Description', 'Describe your character. Features, etc.', null, $person->description);
    $form->text(false, 'personality', 'Personality', 'Describe your character\'s personality. Behaviour, Mannerisms, etc.');
    $form->text(false, 'appearance', 'Appearance', 'Describe your character\'s appearance.');
    $form->text(false, 'species_custom', 'Species', 'Customize your species description if you wish.',null,$person->species->description);
    $form->text(false, 'background_custom', 'Background', 'Customize your background description if you wish.',null,$person->background->description);
    $form->formEnd();
    $component->wrapEnd();
}
?>