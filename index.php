<?php
    require_once(__DIR__.'/libraries/vendor/gagForm/gagForm.php');

    gagForm\Config::$minizeOutput = false;

    echo '<pre>';
    $form = new gagForm\Form();

    $form->method = 'post';
    $form->enctype = 'text/plain';
    $form->autocomplete = 'off';
    $form->attr('novalidate', true);

    echo htmlentities($form->render());
    echo '</pre>';
