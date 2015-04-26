<?php namespace gagForm;

/**
 * Class Input
 *
 * Represents Input element
 *
 * @package gagForm
 */
class Input extends VoidElement {
    protected static $attributesList = [];
    protected static $tag = 'input';
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'alt'=>['url'],
        'type'=>['required'],
        'name' => [],
        'value'=> [],
        'checked'=>['void'],
        'disabled'=>['void'],
        'readonly'=>['void'],
        'tabindex'=>['int'],
        'size'=>[],
        'maxlength'=>['int'],
        'src'=>[],
        'usemap'=>[],
    ];

    /**
     * Checks if passed value is an accepted type.
     *
     * @param string $value a value to be validated
     * @return bool
     */
    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['text', 'password', 'checkbox', 'radio', 'submit', 'reset', 'file', 'hidden', 'image', 'button']);
    }
}