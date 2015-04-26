<?php namespace gagForm;

class File extends Input {
    protected static $attributesList = [];
    protected static $tag = 'input';

    public static function create(array $args = []) {
        $args['type'] = 'file';
        return parent::create($args);
    }

    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['file']);
    }
}