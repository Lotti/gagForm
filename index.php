<?php
    require_once(__DIR__.'/libraries/vendor/gagForm/gagForm.php');

    echo '<pre>';
    $form = new gagForm\Form();

    $form->method = 'post';

    echo htmlentities($form->render());
    echo '</pre>';
