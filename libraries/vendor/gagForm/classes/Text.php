<?php namespace gagForm;

class Text extends VoidElement {
    protected static $attributesList = null;
    protected static $supportedAttributes = [
        'html'=>['bool'],
        'value'=>[],
    ];

    public static function create($text, $isHtml = false) {
        $args = ['value' => $text ];
        if ($isHtml) {
            $args['html'] = true;
        }
        return parent::create($args);
    }

    public function __toString() {
        return 'Text ('.strlen($this->content).')';
    }

    public function append(Text $text) {
        $this->attributes['value'].= $text->attr('value');
    }

    public function prepend(Text $text) {
        $this->attributes['value'] = $text->attr('value').$this->attributes['value'];
    }

    public function render() {
        if (isset($this->attributes['html']) && $this->attributes['html']) {
            return $this->attributes['value'];
        }
        else {
            return htmlspecialchars($this->attributes['value']);
        }
    }
}