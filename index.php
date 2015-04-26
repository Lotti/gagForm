<?php
    require_once(__DIR__.'/libraries/vendor/gagForm/gagForm.php');

    gagForm\Config::$minizeOutput = false;

    echo '<pre>';
    $form = \gagForm\Form::create(['action'=>'/collectData.php']);

    $form->enctype = 'text/plain';
    $form->autocomplete(false);
    $form->attr('method','post')->attr('novalidate', true);

    \gagForm\Text::appendTo($form,['value'=>'blahblah', 'html'=>false]);
    $text = \gagForm\Text::create(['value'=>'this is a text']);
    $input = \gagForm\Input::create();
    $form->append($input);
    \gagForm\TextArea::appendTo($form, ['value'=>'textarea text', 'rows'=>15, 'cols'=>30]);
    \gagForm\Select::appendTo($form, ['name'=>'selectedValue','options'=>[1=>'uno', 2=>'due', 3=>'tre'], 'value'=>1]);

    $form->append(\gagForm\Button::create('ciao'));

    $form->append(\gagForm\Select::create([1=>1,2=>2,3=>3], 3, ['name'=>'select2']));

    echo htmlentities($form->render());
    echo '</pre>';
