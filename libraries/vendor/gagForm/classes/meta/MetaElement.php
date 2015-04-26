<?php namespace gagForm;

/**
 * Class MetaElement
 *
 * This class is the cornerstone of all the library.
 * It defines the structure and automatism that elements will use.
 *
 * @package gagForm
 */
abstract class MetaElement {
    use Validation;

    /**
     * Used to configure the element as void or not.
     * @var bool
     */
    protected static $void = false;
    /**
     * Represent the tag name
     * @var string
     */
    protected static $tag = 'nullTag';
    /**
     * Used to hide certain attributes from element rendering.
     * Just add attribute's name to the array.
     * @var array
     */
    protected static $hiddenAttributes = [];
    /**
     * Used on children class to declare which attributes are supported,
     * and with what validation.
     * @var array
     */
    protected static $supportedAttributes = [];
    /**
     * Populated at run-time, it will contain the complete list of attributes,
     * picked from globalAttributes and supportedOnes. A supported attribute can override
     * the global declaration.
     * @var array
     */
    protected static $attributesList = [];
    /**
     * Contains all the common attribute shared between elements.
     * Each attribute can be validated by passing one or more rules inside the array
     * @var array
     */
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
    /**
     * If filled with values it permits validation on children elements.
     * @var array
     */
    protected static $supportedElements = [];

    /**
     * A generic constructors that permits the initialization of
     * element with an array of attributes.
     *
     * @param array $args
     * @return MetaElement
     */
    public static function create(array $args = []) {
        $object = new static();
        $object->setAttributes($args);
        return $object;
    }

    /**
     * Static method that permits to instantiate an element already
     * appended to a specified parent
     *
     * @param MetaElement $parent
     * @param array $args
     * @return MetaElement
     */
    protected static function appendTo(MetaElement $parent, array $args = []) {
        $object = self::create($args);
        $parent->append($object);
        return $object;
    }

    /**
     * Static method that permits to instantiate an element already
     * prepended to a specified parent
     *
     * @param MetaElement $parent
     * @param array $args
     * @return MetaElement
     */
    protected static function prependTo(MetaElement $parent, array $args = []) {
        $object = self::create($args);
        $parent->prepend($object);
        return $object;
    }

    /**
     * Checks if passed element is a valid child for the current element.
     *
     * @param MetaElement $element
     * @return bool
     */
    private static function isValidChild(MetaElement $element) {
        if (static::$void) {
            return false;
        }

        if (is_object($element)) {
            $element = get_class($element);
        }

        if (!isset(static::$supportedElements) || empty(static::$supportedElements)) {
            return true;
        }
        return in_array($element, static::$supportedElements);
    }

    /**
     * Checks if passed string is a valid attribute name for the current element.
     *
     * @param string $attribute name of the attribute
     * @return bool
     * @throws \Exception
     */
    private static function isValidAttribute($attribute) {
        self::prepareAttributesList();
        if (isset(static::$attributesList[$attribute])) {
            return true;
        }
        else {
            foreach (static::$attributesList as $k => $v) {
                if (strpos($k, '*') !== false && preg_match('/' . str_replace('*', '.*', $k) . '/', $attribute)) {
                    return true;
                }
            }
        }
        throw new \Exception('The element '.static::$tag.' doesn\'t support an attribute called '.$attribute);
    }

    /**
     * Do all the validation checks specificied on $attributesList array
     * on passed value for a specificied attribute
     *
     * @param string $attribute name of the attribute
     * @param mixed $value value of the attribute
     * @return bool
     * @throws \Exception
     */
    private static function isValidAttributeValue($attribute, $value) {
        self::prepareAttributesList();
        $validatePrefix = 'validation_';

        if (self::isValidAttribute($attribute)) {
            $validValue = true;

            if (method_exists(get_called_class(), $validatePrefix.$attribute)) {
                $validValue = call_user_func(array(get_called_class(), $validatePrefix.$attribute), $value);
            }

            if ($validValue) {
                if(isset(static::$attributesList[$attribute])) {
                    $validateMethods = self::getAttributeValidationRules($attribute);
                    foreach ($validateMethods as $v) {
                        if (method_exists(get_called_class(), $validatePrefix.$v)) {
                            if (!call_user_func(array(get_called_class(), $validatePrefix.$v), $value)) {
                                $validValue = false;
                                break;
                            }
                        }
                        else {
                            throw new \Exception('Error on ' . get_called_class() . ': attribute ' . $attribute . ' uses a validation method "' . $v . '" that doesn\'t exist!');
                        }
                    }
                }
            }

            if (!$validValue) {
                throw new \Exception('The element '.static::$tag.' doesn\'t support value "'.$value.'" as value for the attribute '.$attribute);
            }
            return $validValue;
        }
        return false;
    }

    /**
     * Runs only once.
     * It merges attributes declaration and their validation rules
     * coming from $globalAttributes array and $supportedAttributes array.
     * Attributes declared on $supportedAttributes array have priority on
     * $globalAttributes declarations.
     */
    private static function prepareAttributesList() {
        if (empty(static::$attributesList)) {
            static::$attributesList = self::$globalAttributes;
            foreach(static::$supportedAttributes as $k=>$v) {
                static::$attributesList[$k] = $v;
            }
            ksort(static::$attributesList);
        }
    }

    /**
     * Retrieves all the validation rules for a specified attribute.
     *
     * @param string $attribute
     * @return array
     */
    private static function getAttributeValidationRules($attribute) {
        $validateMethods = static::$attributesList[$attribute];
        if (!is_array($validateMethods)) {
            $validateMethods = explode(',', $validateMethods);
        }
        return $validateMethods;
    }

    /**
     * It contains attributes' data.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * It contains children elements
     *
     * @var array
     */
    protected $children = [];

    /**
     * Constructor is private. Use static method create.
     * @see create
     */
    private function __construct() {}

    /**
     * Magic method used to use attributes as object properties.
     *
     * @param string $attribute
     * @return null
     * @throws \Exception
     */
    public function __get($attribute) {
        if (self::isValidAttribute($attribute)) {
            if (isset($this->attributes[$attribute])) {
                return $this->attributes[$attribute];
            }
        }
        return null;
    }

    /**
     * Magic method used to use attributes as object properties.
     *
     * @param string $attribute
     * @param mixed $value
     * @throws \Exception
     */
    public function __set($attribute, $value) {
        if (self::isValidAttributeValue($attribute,$value)) {
            $this->attributes[$attribute] = $value;
        }
    }

    /**
     * Magic method useful for debug purposes
     *
     * @return string
     */
    public function __toString() {
        return htmlentities('<'.static::$tag.' ('.count($this->attributes).') '.(static::$void ? '/': '').'>');
    }

    /**
     * Use this method to assign attributes using a key/value array.
     *
     * @param array $args
     * @return $this
     */
    protected function setAttributes(array $args) {
        foreach($args as $k=>$v) {
            $this->attr($k,$v);
        }
        return $this;
    }

    /**
     * Use this method to get all assigned attributes as a key/value array.
     *
     * @return array
     */
    protected function getAttributes() {
        return $this->attributes;
    }

    /**
     * JQuery like method to set and get attribute value.
     * Supports chaining.
     *
     * @param string $attribute
     * @param mixed $value
     * @return $this|null
     */
    protected function attr($attribute, $value = null) {
        if (is_null($value)) {
            return $this->__get($attribute);
        }
        else {
            $this->__set($attribute, $value);
        }
        return $this;
    }

    /**
     * Delete the specified attribute from the element.
     *
     * @param $attribute
     * @throws \Exception
     */
    protected function removeAttr($attribute) {
        if (self::isValidAttribute($attribute)) {
            unset($this->attributes[$attribute]);
        }
    }

    /**
     * Render the element and all his children to an HTML string.
     *
     * @return string
     */
    public function render() {
        $out = '<'.static::$tag;
        $attributes = $this->renderAttributes();
        if (!empty($attributes)) {
            $out.=' '.$attributes;
        }
        
        if (static::$void) {
            $out.='/>';
        }
        else {
            $out.='>';
            $children = $this->renderChildren();
            if (!empty($children)) {
                if (!Config::$minizeOutput) {
                    $out .= "\n";
                }
                $out .= $this->renderChildren();
                if (!Config::$minizeOutput) {
                    $out .= "\n";
                }
            }
            $out.='</'.static::$tag.'>';
        }
        return $out;
    }

    /**
     * Prepend an element to the current one.
     *
     * @param MetaElement $element
     * @return $this
     */
    protected function prepend(MetaElement $element) {
        if (self::isValidChild($element)) {
            array_unshift($this->children, $element);
        }
        return $this;
    }

    /**
     * Append an element to the current one.
     *
     * @param MetaElement $element
     * @return $this
     */
    protected function append(MetaElement $element) {
        if (self::isValidChild($element)) {
            array_push($this->children, $element);
        }
        return $this;
    }

    /**
     * Insert an element at a specified position inside the current one.
     *
     * @param MetaElement $element
     * @param int $order
     * @return $this
     */
    protected function addChildren(MetaElement $element, $order) {
        $this->children = array_splice($this->children, $order, 0, $element);
        return $this;
    }

    /**
     * Render all ellement attributes to an HTML string.
     *
     * @return string
     */
    protected function renderAttributes() {
        $out = [];
        foreach($this->attributes as $name=>$value) {
            if (!in_array($name, static::$hiddenAttributes)) {
                $validateMethods = self::getAttributeValidationRules($name);
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

    /**
     * Invokes HTML rendering on all element's children.
     *
     * @return string
     */
    protected function renderChildren() {
        $out = [];
        foreach($this->children as $v) {
            if ($v instanceof MetaElement) {
                $out[] = $v->render();
            }
            else {
                $out[] = $v;
            }
        }
        return implode(Config::$minizeOutput ? '' : "\n",$out);
    }
}