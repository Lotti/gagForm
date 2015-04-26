<?php namespace gagForm;

class Label extends Element {
    protected static $attributesList = [];
    protected static $tag = 'label';
    protected static $supportedAttributes = [
        'for'=>[],
        'accesskey'=>['char'],
    ];
}