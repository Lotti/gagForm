<?php namespace gagForm;

/**
 * Class CData
 *
 * Represents CData element
 *
 * @package gagForm
 */
class CData extends VoidElement {
    protected static $attributesList = [];
    protected static $supportedAttributes = [
        'html'=>['bool'],
        'value'=>[],
    ];

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param string $text
     * @param bool $isHtml
     * @return CData
     * @see MetaElement::create
     */
    public static function create($text, $isHtml = false) {
        $args = ['value' => $text ];
        if ($isHtml) {
            $args['html'] = true;
        }
        return parent::create($args);
    }

    /**
     * Magic method useful for debug purposes
     *
     * @return string
     */
    public function __toString() {
        return 'CData ('.strlen($this->content).')';
    }

    /**
     * Use this method to append passed CData content to this element
     *
     * @param CData $text
     */
    public function append(CData $text) {
        $this->attributes['value'].= $text->attr('value');
    }

    /**
     * Use this method to prepend passed CData content to this element
     *
     * @param CData $text
     */
    public function prepend(CData $text) {
        $this->attributes['value'] = $text->attr('value').$this->attributes['value'];
    }

    /**
     * Render the element and all his children to an HTML string.
     *
     * @return string
     */
    public function render() {
        if (isset($this->attributes['html']) && $this->attributes['html']) {
            return $this->attributes['value'];
        }
        else {
            return htmlspecialchars($this->attributes['value']);
        }
    }
}