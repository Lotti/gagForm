<?php namespace gagForm;

class Button extends Element {
    protected static $attributesList = [];
    protected static $tag = 'button';
    protected static $hiddenAttributes = ['value'];
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'type'=>['required'],
        'name' => [],
        'value'=> [],
        'disabled'=>['void'],
        'tabindex'=>['int'],
    ];

    public static function create($value, $type = 'button', array $args = []) {
        $args['type'] = $type;
        if ($value instanceof CData) {
            $value = $value->render();
        }
        $args['value'] = $value;

        return parent::create($args);
    }

    /**
     * Checks if passed value is an accepted type.
     *
     * @param string $value a value to be validated
     * @return bool
     */
    protected static function validation_type($value) {
        $value = strtolower($value);
        return in_array($value, ['button', 'submit', 'reset']);
    }
}