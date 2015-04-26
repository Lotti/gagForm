<?php namespace gagForm;

class Submit extends Input {
    protected static $attributesList = [];
    protected static $tag = 'input';

    public static function create($value, array $args = []) {
        $args['type'] = 'submit';
        $args['value'] = $value;
        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['submit']);
    }
}