<?php namespace gagForm;

abstract class MetaElement {
    use Validation;

    protected static $void = false;
    protected static $tag = 'nullTag';
    protected static $hiddenAttributes = [];
    protected static $supportedAttributes = [];
    protected static $attributesList = null;
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
    protected static $supportedElements = [];

    protected static function appendTo(MetaElement $parent, array $args = []) {
        $parent->append(new static($args));
    }

    protected static function prependTo(MetaElement $parent, array $args = []) {
        $parent->prepend(new static($args));
    }

    private static function isValidChild($value) {
        if (is_object($value)) {
            $value = get_class($value);
        }

        if (!isset(static::$supportedElements) || empty(static::$supportedElements)) {
            return true;
        }
        return in_array($value, static::$supportedElements);
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
        throw new \Exception('The element '.static::$tag.' doesn\'t support an attribute called '.$name);
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
                    $validateMethods = self::getValidateMethods($name);
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

            if (!$validValue) {
                throw new \Exception('The element '.static::$tag.' doesn\'t support value "'.$value.'" as value for the attribute '.$name);
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

    private static function getValidateMethods($name) {
        $validateMethods = static::$attributesList[$name];
        if (!is_array($validateMethods)) {
            $validateMethods = explode(',', $validateMethods);
        }
        return $validateMethods;
    }

    protected $attributes = [];
    protected $children = [];

    public function __construct(array $args = []) {
        $this->setAttributes($args);
    }

    public function __get($name) {
        if (self::isValidAttribute($name)) {
            if (isset($this->attributes[$name])) {
                return $this->attributes[$name];
            }
        }
        return null;
    }

    public function __set($name, $value) {
        if (self::isValidValue($name,$value)) {
            $this->attributes[$name] = $value;
        }
    }

    public function __toString() {
        return htmlentities('<'.static::$tag.' ('.count($this->attributes).') '.(static::$void ? '/': '').'>');
    }

    protected function setAttributes(array $args) {
        foreach($args as $k=>$v) {
            $this->attr($k,$v);
        }
        return $this;
    }

    protected function getAttributes() {
        return $this->attributes;
    }

    protected function attr($name, $value = null) {
        if (is_null($value)) {
            return $this->__get($name);
        }
        else {
            $this->__set($name, $value);
        }
        return $this;
    }

    protected function removeAttr($name) {
        if (self::isValidAttribute($name)) {
            unset($this->attributes[$name]);
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

    protected function prepend(MetaElement $element) {
        if (self::isValidChild($element)) {
            array_unshift($this->children, $element);
        }
        return $this;
    }

    protected function append(MetaElement $element) {
        if (self::isValidChild($element)) {
            array_push($this->children, $element);
        }
        return $this;
    }

    protected function addChildren(MetaElement $element, $order) {
        $this->children = array_splice($this->children, $order, 0, $element);
        return $this;
    }

    protected function printAttributes() {
        $out = [];
        foreach($this->attributes as $name=>$value) {
            if (!in_array($name, static::$hiddenAttributes)) {
                $validateMethods = self::getValidateMethods($name);
                if (in_array('void', $validateMethods) && $value) {
                    $out[] = $name;
                } else if (in_array('bool', $validateMethods)) {
                    $out[] = ($name) ? 'true' : 'false';
                } else if (!empty($value)) {
                    $out[] = $name . '="' . htmlspecialchars($value) . '"';
                }
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
}