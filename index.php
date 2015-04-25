<?php
    require_once(__DIR__.'/libraries/vendor/gagForm/gagForm.php');

    gagForm\Config::$minizeOutput = false;

    echo '<pre>';
    $form = new \gagForm\Form();

    $form->method = 'post';
    $form->enctype = 'text/plain';
    $form->autocomplete(false);
    $form->attr('novalidate', true);

\gagForm\Text::appendTo($form,"blahblah");
    $text = new \gagForm\Text("this is a text");
    $input = new \gagForm\Input();

    echo htmlentities($form->render());
    echo '</pre>';
