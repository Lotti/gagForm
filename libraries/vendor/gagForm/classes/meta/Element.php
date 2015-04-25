<?php namespace gagForm;

abstract class Element extends CommonElement {
    public function prepend(MetaElement $element) {
        return parent::prepend($element);
    }

    public function append(MetaElement $element) {
        return parent::append($element);
    }

    public function addChildren(MetaElement $element, $order) {
        return parent::addChildren($element, $order);
    }
}