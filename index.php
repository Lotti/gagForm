<?php

define('__DEBUG__', false);

require_once(__DIR__.'/libraries/vendor/gagForm/gagForm.php');

\gagForm\Config::$minizeOutput = !__DEBUG__;

$form = \gagForm\Form::create('get', '/collectData.php');

$form->enctype = 'text/plain';
$form->autocomplete(false);
$form->attr('method','post')->attr('novalidate', true);

\gagForm\CData::appendTo($form,['value'=>'blahblah', 'html'=>false]);
$text = \gagForm\CData::create(['value'=>'this is a text']);
$input = \gagForm\Input::create();
$form->append($input);
\gagForm\TextArea::appendTo($form, ['value'=>'textarea text', 'rows'=>5, 'cols'=>45]);
\gagForm\Select::appendTo($form, ['name'=>'selectedValue','options'=>[1=>'uno', 2=>'due', 3=>'tre'], 'value'=>1]);

$button = \gagForm\Button::create('ciao');
$button->append(\gagForm\CData::create('sono un bottone'));
$form->append($button);

$form->append(\gagForm\Select::create([1=>1,2=>2,3=>3], 3, ['name'=>'select2']));

$form->append(\gagForm\Label::create(\gagForm\Checkbox::create(true, ['id'=>'checkbox1']), ['for'=>'checkbox1'])->prepend(\gagForm\CData::create('label checkbox')));
$form->append(\gagForm\Radio::create(true, ['name'=>'radio']));
$form->append(\gagForm\Radio::create(false, ['name'=>'radio']));
$form->append(\gagForm\Hidden::create('123', ['name'=>'id']));
$form->append(\gagForm\Text::create('username', ['name'=>'username']));
$form->append(\gagForm\Password::create('password', ['name'=>'password']));
$form->append(\gagForm\File::create(['name'=>'file']));
$form->append(\gagForm\Submit::create('Invia il form', ['name'=>'submit']));
$form->append(\gagForm\Reset::create('Resetta il form', ['name'=>'reset']));

if (__DEBUG__) {
    echo '<pre>'.htmlspecialchars($form->render()).'</pre>';
}
else {
    echo $form->render();
}