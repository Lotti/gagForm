<?php namespace gagForm;

/**
 * Class CommonElement
 *
 * Abstract class that must be extended only by Element and VoidElement classes.
 * It change visibility to some methods of MetaElement class.
 *
 * @package gagForm
 */
abstract class CommonElement extends MetaElement {
    /**
     * Wrapper of parent method. It justs change his visibility.
     *
     * @param MetaElement $parent
     * @param array $args
     * @see MetaElement::appendTo
     */
    public static function appendTo(MetaElement $parent, array $args = []) {
        parent::appendTo($parent, $args);
    }

    /**
     * Wrapper of parent method. It justs change his visibility.
     *
     * @param MetaElement $parent
     * @param array $args
     * @see MetaElement::prependTo
     */
    public static function prependTo(MetaElement $parent, array $args = []) {
        parent::prependTo($parent, $args);
    }

    /**
     * Wrapper of parent method. It justs change his visibility.
     *
     * @param string $attribute
     * @param null $value
     * @return $this|null
     * @see MetaElement::attr
     */
    public function attr($attribute, $value = null) {
        return parent::attr($attribute, $value);
    }

    /**
     * Wrapper of parent method. It justs change his visibility.
     *
     * @param string $attribute
     * @see MetaElement::removeAttr
     */
    public function removeAttr($attribute) {
        return parent::removeAttr($attribute);
    }

    /**
     * Wrapper of parent method. It justs change his visibility.
     *
     * @param array $args
     * @return $this
     * @see MetaElement::setAttributes
     */
    public function setAttributes(array $args) {
        return parent::setAttributes($args);
    }

    /**
     * Wrapper of parent method. It justs change his visibility.
     *
     * @return array
     * @see MetaElement::getAttributes
     */
    public function getAttributes() {
        return parent::getAttributes();
    }
}