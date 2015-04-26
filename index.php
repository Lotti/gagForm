<?php
    require_once(__DIR__.'/libraries/vendor/gagForm/gagForm.php');

    gagForm\Config::$minizeOutput = false;

    echo '<pre>';
    $form = new \gagForm\Form(['action'=>'/collectData.php']);

    $form->enctype = 'text/plain';
    $form->autocomplete(false);
    $form->attr('method','post')->attr('novalidate', true);

    \gagForm\Text::appendTo($form,['value'=>'blahblah', 'html'=>false]);
    $text = new \gagForm\Text(['value'=>'this is a text']);
    $input = new \gagForm\Input();
    $form->append($input);
    \gagForm\TextArea::appendTo($form, ['value'=>'textarea text', 'rows'=>15, 'cols'=>30]);

    echo htmlentities($form->render());
    echo '</pre>';
