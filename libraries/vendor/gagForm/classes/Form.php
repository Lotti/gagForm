<?php namespace gagForm;

/**
 * Class Form
 *
 * Represents Form element
 *
 * @package gagForm
 */
class Form extends Element {
    protected static $attributesList = [];
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

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param string $method form send method (values: get or post)
     * @param string $action the form action value
     * @param array $args other attributes values
     * @return Form
     * @see MetaElement::create
     */
    public static function create($method, $action, array $args = []) {
        $args['method'] = $method;
        $args['action'] = $action;
        return parent::create($args);
    }

    /**
     * Checks if passed value is an accepted type.
     *
     * @param string $value a value to be validated
     * @return bool
     */
    protected static function validation_method($value) {
        $value = strtolower($value);
        return in_array($value, ['get','post']);
    }

    /**
     * Checks if passed value is an accepted type.
     *
     * @param string $value a value to be validated
     * @return bool
     */
    protected static function validation_enctype($value) {
        $value = strtolower($value);
        return in_array($value, ['application/x-www-form-urlencoded','multipart/form-data','text/plain']);
    }

    /**
     * Sets the form method to post
     *
     * @return $this
     */
    public function post() {
        $this->attributes['method'] = 'post';
        return $this;
    }

    /**
     * Sets the form method to get
     *
     * @return $this
     */
    public function get() {
        $this->attributes['method'] = 'get';
        return $this;
    }

    /**
     * Sets the form enctype to urlencoded
     *
     * @return $this
     */
    public function urlEncoded() {
        $this->attributes['enctype'] = 'application/x-www-form-urlencoded';
        return $this;
    }

    /**
     * Sets the form enctype to multipart/form-data
     *
     * @return $this
     */
    public function multipartData() {
        $this->attributes['enctype'] = 'multipart/form-data';
        return $this;
    }

    /**
     * Sets the autocomplete attribute
     *
     * @param bool $value
     * @return $this
     */
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