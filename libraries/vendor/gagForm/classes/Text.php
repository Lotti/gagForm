<?php namespace gagForm;

class Text extends Input {
    protected static $attributesList = [];
    protected static $tag = 'input';

    public static function create($value, array $args = []) {
        $args['type'] = 'text';
        $args['value'] = $value;
        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['text']);
    }
}