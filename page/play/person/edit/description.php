<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 16/02/2017
 * Time: 20:00
 */
global $sitemap, $form, $component;

require_once('./class/Person.php');
require_once('./class/System.php');

$person = new Person($sitemap->id, $sitemap->hash);
$system = new System();

$component->title('Edit '.$person->nickname);
?>

<?php if($person->isOwner): ?>

    <div class="sw-l-quicklink">
        <?php $component->linkQuick($person->siteLink,'Return','/img/return.png'); ?>
    </div>

    <?php
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
    $form->varchar(true, 'gender', 'Gender', null, null, $person->gender);
    $form->number(true, 'age', 'Age', 'When changing age after creation, the system will no longer change any other variables.', null, 5, $person->species->maxAge, $person->age);
    $form->text(false, 'description', 'Description', 'Describe your character. Features, etc.', null, $person->description);
    $form->text(false, 'personality', 'Personality', 'Describe your character\'s personality. Behaviour, Mannerisms, etc.');
    $form->text(false, 'appearance', 'Appearance', 'Describe your character\'s appearance.');
    $form->text(false, 'species_custom', 'Species', 'Customize your species description if you wish.',null,$person->species->description);
    $form->text(false, 'background_custom', 'Background', 'Customize your background description if you wish.',null,$person->background->description);
    $form->formEnd();
    $component->wrapEnd();
    ?>

    <script src="/js/validation.js"></script>

<?php endif; ?>