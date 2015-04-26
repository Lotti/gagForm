<?php namespace gagForm;

/**
 * Class TextArea
 *
 * Represents TextArea element
 *
 * @package gagForm
 */
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

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param string|CData $value textarea content
     * @param array $args other attributes values
     * @return TextArea
     * @see MetaElement::create
     */
    public static function create($text, array $args = []) {
        if ($text instanceof CData) {
            $text = $text->render();
        }
        $args['value'] = $text;
        return parent::create($args);
    }

    /**
     * Render the element and all his children to an HTML string.
     *
     * @return string
     * @see MetaElement::render
     */
    public function render() {
        $this->children = [];
        $this->children[0] = CData::create($this->attributes['value']);
        return parent::render();
    }
}