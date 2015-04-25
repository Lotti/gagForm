<?php namespace gagForm;

class Form extends Element {
    protected static $tag = 'form';
    protected static $supportedAttributes = [
        'accept'=>[],
        'accept-charset'=>[],
        'action'=>[],
        'autocomplete'=>[],
        'enctype'=>[],
        'method'=>[],
        'name' => [],
        'novalidate'=>['void'],
        'onsubmit'=>[],
        'onreset'=>[],
        'target'=>[],
    ];

    protected static function method($value) {
        $value = strtolower($value);
        return in_array($value, ['get','post']);
    }

    protected static function enctype($value) {
        $value = strtolower($value);
        return in_array($value, ['get','post']);
    }

    protected static function autocomplete($value) {
        return Validation::onoff($value);
    }
}