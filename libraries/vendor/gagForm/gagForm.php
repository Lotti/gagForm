<?php namespace gagForm;

class Config {
    public static $minizeOutput = true;
}
require_once(__DIR__ . '/traits/Validation.php');
require_once(__DIR__ . '/classes/meta/MetaElement.php');
require_once(__DIR__ . '/classes/meta/CommonElement.php');
require_once(__DIR__ . '/classes/meta/Element.php');
require_once(__DIR__ . '/classes/meta/VoidElement.php');
require_once(__DIR__ . '/classes/Form.php');
require_once(__DIR__ . '/classes/Input.php');
require_once(__DIR__ . '/classes/TextArea.php');
require_once(__DIR__ . '/classes/Select.php');
require_once(__DIR__ . '/classes/Button.php');
require_once(__DIR__ . '/classes/Text.php');