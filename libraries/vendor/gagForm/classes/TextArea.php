<?php namespace gagForm;

class TextArea extends VoidElement {
    protected static $attributesList = null;
    protected static $void = false;
    protected static $tag = 'textarea';
    protected static $hiddenAttributes = ['value'];
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'rows'=>['int'],
        'cols'=>['int'],
        'name' => [],
        'value'=> [],
        'readonly'=>['void'],
        'disabled'=>['void'],
        'tabindex'=>['int'],
    ];

    public function render() {
        $this->children = [];
        $this->children[0] = Text::create($this->attributes['value']);
        return parent::render();
    }
}