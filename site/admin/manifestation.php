<?php
/**
 * Created by PhpStorm.
 * User: jonn
 * Date: 18/02/2017
 * Time: 17:20
 */
global $sitemap;

require_once('./class/feature/Manifestation.php');

$manifestation = null;

if(isset($sitemap->id)) {
    $manifestation = new Manifestation($sitemap->id);
}
?>

<?php if(!isset($manifestation)): ?>

    <h2>Create Manifestation</h2>
    <?php
    global $form, $curl;

    $attributeType = $curl->get('attributetype')['data']; // todo not hardcoded

    $form->genericStart();
    $form->hidden('return', 'admin/manifestation', 'post');
    $form->hidden('do', 'manifestation--post', 'post');

    $form->varchar(true, 'name');
    $form->text(false, 'description');
    $form->varchar(true, 'attribute_power', 'power name', 'The name that will be given the attribute.');
    $form->number(true, 'attribute_maximum', 'attribute maximum', null, null, 1, null, 16);
    $form->number(true, 'expertise_maximum', 'expertise maximum', null, null, 1, null, 4);

    $form->hidden('skill_attributetype_id', 10);
    //$form->select(false, 'skill_attributetype_id', $attributeType, 'skill attribute type', 'the attribute type in which skills will be.', 10);

    $form->number(true, 'skill_attribute_required', 'skill attribute required', null, null, 1, null, 2);
    $form->number(true, 'skill_attribute_increment', 'skill attribute increment', null, null, 1, null, 2);
    $form->number(false, 'startsat', 'expertise startsat', 'expertise starts at', null, 1, null, 0);

    $form->genericEnd();
    ?>

<?php endif; ?>

<?php if(isset($manifestation) && !$sitemap->thing): ?>

    <h2><?php echo $manifestation->name; ?></h2>

    <div class="sw-l-content__wrap">
        <a class="sw-c-link" href="/admin/manifestation/<?php echo $manifestation->id; ?>/discipline">Add Discipline</a>
        <a class="sw-c-link" href="/admin/manifestation/<?php echo $manifestation->id; ?>/focus">Add Focus</a>
    </div>

<?php endif; ?>

<?php if(isset($manifestation) && $sitemap->thing == 'discipline'): ?>

    <div class="sw-l-quicklink">
        <a class="sw-l-quicklink__item" href="/admin/manifestation/<?php echo $manifestation->id; ?>"><img src="/img/return.png"/></a>
    </div>

    <h2>Add Discipline</h2>
    <?php
    global $form, $curl;

    $form->genericStart();
    $form->hidden('return', 'admin/manifestation', 'post');
    $form->hidden('do', 'manifestation--discipline', 'post');
    $form->hidden('id', $manifestation->id, 'post');

    $form->varchar(true, 'name');
    $form->text(false, 'description');

    $form->hidden('attribute_id', $manifestation->skillAttribute);
    $form->hidden('attributetype_id', $manifestation->disciplineAttributeType);
    $form->hidden('expertisetype_id', $manifestation->expertiseType);

    $form->icon();

    $form->genericEnd();
    ?>

<?php endif; ?>

<?php if(isset($manifestation) && $sitemap->thing == 'focus'): ?>

    <div class="sw-l-quicklink">
        <a class="sw-l-quicklink__item" href="/admin/manifestation/<?php echo $manifestation->id; ?>"><img src="/img/return.png"/></a>
    </div>

    <h2>Add Focus</h2>
    <?php
    global $form;

    $form->genericStart();
    $form->hidden('return', 'admin/manifestation', 'post');
    $form->hidden('do', 'manifestation--discipline', 'post');
    $form->hidden('id', $manifestation->id, 'post');

    $form->varchar(true, 'name');
    $form->text(false, 'description');

    $form->icon();

    $form->genericEnd();
    ?>

<?php endif; ?>

<script src="/js/validation.js"></script>