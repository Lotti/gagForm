<?php namespace gagForm;

abstract class CommonElement extends MetaElement {
    public static function appendTo(MetaElement $parent, array $args = []) {
        parent::appendTo($parent, $args);
    }

    public static function prependTo(MetaElement $parent, array $args = []) {
        parent::prependTo($parent, $args);
    }

    public function attr($name, $value = null) {
        return parent::attr($name, $value);
    }

    protected function setAttributes(array $args) {
        return parent::setAttributes($args);
    }

    protected function getAttributes() {
        return parent::getAttributes();
    }
}