<?php namespace gagForm;

class Hidden extends Input {
    protected static $attributesList = [];
    protected static $tag = 'input';

    public static function create($value, array $args = []) {
        $args['type'] = 'hidden';
        $args['value'] = $value;
        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['hidden']);
    }
}