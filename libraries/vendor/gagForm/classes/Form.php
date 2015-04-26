<?php namespace gagForm;

class Form extends Element {
    protected static $attributesList = null;
    protected static $tag = 'form';
    protected static $supportedAttributes = [
        'accept-charset'=>[],
        'action'=>['url'],
        'autocomplete'=>['onoff'],
        'enctype'=>[],
        'method'=>[],
        'name' => [],
        'novalidate'=>['void'],
        'target'=>[],
    ];

    public static function create($method, $action, array $args = []) {
        $args['method'] = $method;
        $args['action'] = $action;
        return parent::create($args);
    }

    protected static function validation_method($value) {
        $value = strtolower($value);
        return in_array($value, ['get','post']);
    }

    protected static function validation_enctype($value) {
        $value = strtolower($value);
        return in_array($value, ['application/x-www-form-urlencoded','multipart/form-data','text/plain']);
    }

    public function post() {
        $this->attributes['method'] = 'post';
        return $this;
    }

    public function get() {
        $this->attributes['method'] = 'get';
        return $this;
    }

    public function urlEncoded() {
        $this->attributes['enctype'] = 'application/x-www-form-urlencoded';
        return $this;
    }

    public function multipartData() {
        $this->attributes['enctype'] = 'multipart/form-data';
        return $this;
    }

    public function autocomplete($value) {
        if ($value) {
            $this->attributes['autocomplete'] = 'on';
        }
        else {
            $this->attributes['autocomplete'] = 'off';
        }
        return $this;
    }
}