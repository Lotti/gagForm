<?php namespace gagForm;

/**
 * Class Button
 *
 * Represents Button element
 *
 * @package gagForm
 */
class Button extends Element {
    protected static $attributesList = [];
    protected static $tag = 'button';
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'type'=>['required'],
        'name' => [],
        'disabled'=>['void'],
        'tabindex'=>['int'],
    ];

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param MetaElement $element
     * @param string $type value of attribute type
     * @param array $args other attributes values
     * @return Button
     * @see MetaElement::create
     */
    public static function create(MetaElement $element, $type = 'button', array $args = []) {
        $args['type'] = $type;
        $object = parent::create($args);
        return $object->append($element);
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