<?php namespace gagForm;

abstract class Element {
    protected static $void = false;
    protected static $tag = 'nullTag';
    protected static $supportedAttributes = [];
    private static $attributesList = null;


    protected $attributes = [];
    protected $children = [];

    public function __construct() {

    }

    public function __destruct() {

    }

    /*
    public function __call() {

    }

    public static function __callStatic() {

    }
    */

    public function __get($name) {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        else {
            return null;
        }
    }

    public function __set($name, $value) {
        if (self::isValidAttribute($name)) {
            $this->attributes[$name] = $value;
        }
    }

    public function __toString() {
        return '<'.self::$tag.' ('.count($this->attributes).') '.(self::$void ? '/': '').'>';
    }

    public function attr($name, $value = null) {
        $args = func_num_args();
        switch($args) {
            default:
                throw new BadMethodCallException('This method support only with a specific amount of parameters. With one parameter it will operate as a getter, with two as a setter');
            break;
            case 1:
                return $this->__get($name);
            break;
            case 2:
                $this->__set($name, $value);
                return $this;
            break;
        }
    }

    public function render() {
        $out = '<'.self::$tag.' '.$this->printAttributes();
        if (self::$void) {
            $out.='/>';
        }
        else {
            $out.=$this->printChildren();
            $out.='</'.self::$tag.'>';
        }
        return $out;
    }

    public function prepend(Element $element) {
        array_unshift($this->children, $element);
        return $this;
    }

    public function append(Element $element) {
        array_push($this->children, $element);
        return $this;
    }

    public function addChildren(Element $element, $order) {
        $this->children = array_splice($this->children, $order, 0, $element);
        return $this;
    }

    protected function printAttributes() {
        $out = [];
        foreach($this->attributes as $k=>$v) {
            if (!empty($v)) {
                $out[] = $k . '=' . $v;
            }
            else {
                $out[] = $k;
            }
        }
        return implode(' ',$out);
    }

    protected function printChildren() {
        $out = [];
        foreach($this->children as $v) {
            $out[] = $v->render();
        }

        if (Config::$minizeOutput) {
            $separator = '';
        }
        else {
            $separator = "\n";
        }
        return implode($separator,$out);
    }

    private static function isValidAttribute($name) {
        if (self::$attributesList == null) {
            self::$attributesList = array_merge(self::$globalAttributes, self::$supportedAttributes);
        }

        foreach(self::$attributesList as $k=>$v) {
            if ($k == $name) {
                return true;
            }
            else if (strpos($k,'*') !== false && preg_match('/'.str_replace('*','.*',$k).'/', $name)) {
                return true;
            }
        }

        return false;
    }

    protected static $globalAttributes = [
        'accesskey'=>[],
        'class'=>[],
        'contenteditable'=>[],
        'contextmenu'=>[],
        'data-*'=>[],
        'dir'=>[],
        'draggable'=>[],
        'dropzone'=>[],
        'hidden'=>[],
        'id'=>[],
        'lang'=>[],
        'on*'=>[],
        'spellcheck'=>[],
        'style'=>[],
        'tabindex'=>[],
        'title'=>[],
    ];
}