<?php namespace gagForm;

/**
 * Class Label
 *
 * Represents Label element
 *
 * @package gagForm
 */
class Label extends Element {
    protected static $attributesList = [];
    protected static $tag = 'label';
    protected static $supportedAttributes = [
        'for'=>[],
        'accesskey'=>['char'],
    ];

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param MetaElement $element
     * @param array $args other attributes values
     * @return Label
     * @see MetaElement::create
     */
    public static function create(MetaElement $element, array $args = []) {
        $object = parent::create($args);
        $object->append($element);
        return $object;
    }
}