<?php namespace gagForm;

class TextArea extends VoidElement {
    protected static $attributesList = [];
    protected static $void = false;
    protected static $tag = 'textarea';
    protected static $hiddenAttributes = ['value'];
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'rows'=>['int'],
        'cols'=>['int'],
        'name' => [],
        'value' => [],
        'readonly'=>['void'],
        'disabled'=>['void'],
        'tabindex'=>['int'],
    ];

    public static function create($text, array $args = []) {
        if ($text instanceof CData) {
            $text = $text->render();
        }
        $args['value'] = $text;
        return parent::create($args);
    }


    public function render() {
        $this->children = [];
        $this->children[0] = CData::create($this->attributes['value']);
        return parent::render();
    }
}