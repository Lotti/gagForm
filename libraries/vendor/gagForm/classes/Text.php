<?php namespace gagForm;

class Text extends MetaElement {

    public static function appendTo(MetaElement $parent, $text, $isHtml = false) {
        $parent->append(new self($text, $isHtml));
    }

    public static function prependTo(MetaElement $parent, $text, $isHtml = false) {
        $parent->prepend(new self($text, $isHtml));
    }

    protected $content;

    public function __construct($text,$isHtml = false) {
        $this->set($text,$isHtml);
    }

    public function __get($name) {}

    public function __set($name, $value) {}

    public function __toString() {
        return 'Text ('.strlen($this->content).')';
    }

    public function set($text,$isHtml = false) {
        if (!$isHtml) {
            $this->content = filter_var($text, FILTER_SANITIZE_STRING);
        }
        else {
            $this->content = $text;
        }
    }

    public function append(Text $text) {
        $this->content.= $text->render();
    }

    public function prepend(Text $text) {
        $this->content = $text->render().$this->content;
    }

    public function render() {
        return $this->content;
    }
}