<?php namespace gagForm;

class Button extends Element {
    protected static $attributesList = null;
    protected static $tag = 'button';
    protected static $hiddenAttributes = ['value'];
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'type'=>['required'],
        'name' => [],
        'value'=> [],
        'disabled'=>['void'],
        'tabindex'=>['int'],
    ];

    public static function create($value, array $args = []) {
        if (!isset($args['type'])) {
            $args['type'] = 'button';
        }

        $args['value'] = $value;

        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['button', 'submit', 'reset']);
    }
}