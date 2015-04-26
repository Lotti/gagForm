<?php namespace gagForm;

class Label extends Element {
    protected static $attributesList = [];
    protected static $tag = 'label';
    protected static $supportedAttributes = [
        'for'=>[],
        'accesskey'=>['char'],
    ];

    public static function create(MetaElement $element, array $args = []) {
        $object = parent::create($args);
        $object->append($element);
        return $object;
    }
}