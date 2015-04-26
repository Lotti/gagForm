<?php namespace gagForm;

class Radio extends Input {
    protected static $attributesList = [];
    protected static $tag = 'input';

    public static function create($checked, array $args = []) {
        $args['type'] = 'radio';
        $args['checked'] = $checked;
        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['radio']);
    }
}