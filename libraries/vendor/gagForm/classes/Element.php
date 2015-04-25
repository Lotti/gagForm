<?php namespace gagForm;

abstract class Element {
    use Validation;

    protected static $void = false;
    protected static $tag = 'nullTag';
    protected static $supportedAttributes = [];
    protected static $attributesList = null;


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
        if (self::isValidAttribute($name)) {
            if (isset($this->attributes[$name])) {
                return $this->attributes[$name];
            }
        }
        else {
            throw new \Exception('The element '.static::$tag.' doesn\'t support any attribute called '.$name);
        }
        return null;
    }

    public function __set($name, $value) {
        if (self::isValidValue($name,$value)) {
            $this->attributes[$name] = $value;
        }
        else {
            throw new \Exception('The element '.static::$tag.' doesn\'t support value "'.$value.'" as value for the attribute '.$name);
        }
        return $this;
    }

    public function __toString() {
        return htmlentities('<'.static::$tag.' ('.count($this->attributes).') '.(static::$void ? '/': '').'>');
    }

    public function attr($name, $value = null) {
        $args = func_num_args();
        switch($args) {
            default:
                throw new \BadMethodCallException('This method support only with a specific amount of parameters. With one parameter it will operate as a getter, with two as a setter');
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
        $out = '<'.static::$tag;
        $attributes = $this->printAttributes();
        if (!empty($attributes)) {
            $out.=' '.$attributes;
        }
        
        if (static::$void) {
            $out.='/>';
        }
        else {
            $out.='>';
            $out.=$this->printChildren();
            $out.='</'.static::$tag.'>';
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
                $out[] = $k . '="'.htmlspecialchars($v).'"';
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
        self::prepareAttributesList();
        if (isset(static::$attributesList[$name])) {
            return true;
        }
        else {
            foreach (static::$attributesList as $k => $v) {
                if (strpos($k, '*') !== false && preg_match('/' . str_replace('*', '.*', $k) . '/', $name)) {
                    return true;
                }
            }
        }

        throw new \Exception(static::$tag." doesn't support an attribute called ".$name);
        return false;
    }

    private static function isValidValue($name, $value) {
        self::prepareAttributesList();
        $validatePrefix = 'validation_';

        if (self::isValidAttribute($name)) {
            $validValue = true;

            if (method_exists(get_called_class(), $validatePrefix.$name)) {
                $validValue = call_user_func(array(get_called_class(), $validatePrefix.$name), $value);
            }

            if ($validValue) {
                if(isset(static::$attributesList[$name])) {
                    $validateMethods = static::$attributesList[$name];
                    if (!is_array($validateMethods)) {
                        $validateMethods = explode(',', $validateMethods);
                    }
                    foreach ($validateMethods as $v) {
                        if (method_exists(get_called_class(), $validatePrefix.$v)) {
                            if (!call_user_func(array(get_called_class(), $validatePrefix.$v), $value)) {
                                $validValue = false;
                                break;
                            }
                        }
                        else {
                            throw new \Exception('Error on ' . get_called_class() . ': attribute ' . $name . ' uses a validation method "' . $v . '" that doesn\'t exist!');
                            $validValue = false;
                            break;
                        }
                    }
                }
            }
            return $validValue;
        }
        return false;
    }

    private static function prepareAttributesList() {
        if (static::$attributesList == null) {
            static::$attributesList = self::$globalAttributes;
            foreach(static::$supportedAttributes as $k=>$v) {
                static::$attributesList[$k] = $v;
            }
            ksort(static::$attributesList);
        }
    }

    protected static $globalAttributes = [
        'accesskey'=>[],
        'class'=>[], //core attribute
        'contenteditable'=>[],
        'contextmenu'=>[],
        'data-*'=>[],
        'dir'=>[], //i18n attribute
        'draggable'=>[],
        'dropzone'=>[],
        'hidden'=>[],
        'id'=>[], //core attribute
        'itemid'=>[],
        'itemprop'=>[],
        'itemref'=>[],
        'itemscope'=>[],
        'itemtype'=>[],
        'lang'=>[], //i18n attribute
        'on*'=>[], //events attribute
        'spellcheck'=>[],
        'style'=>[], //core attribute
        'tabindex'=>[],
        'title'=>[], //core attribute
        'translate'=>[],
    ];
}