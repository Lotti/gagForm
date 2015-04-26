<?php namespace gagForm;

class Input extends VoidElement {
    protected static $attributesList = null;
    protected static $tag = 'input';
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'alt'=>['url'],
        'type'=>['required'],
        'name' => [],
        'value'=> [],
        'checked'=>['void'],
        'disabled'=>['void'],
        'readonly'=>['void'],
        'tabindex'=>['int'],
        'size'=>[],
        'maxlength'=>['int'],
        'src'=>[],
        'usemap'=>[],
    ];

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['text', 'password', 'checkbox', 'radio', 'submit', 'reset', 'file', 'hidden', 'image', 'button']);
    }
}