<?php namespace gagForm;

/**
 * Class Select
 *
 * Represents Select element
 *
 * @package gagForm
 */
class Select extends VoidElement {
    protected static $attributesList = [];
    protected static $void = false;
    protected static $tag = 'select';
    protected static $hiddenAttributes = ['value','options'];
    protected static $supportedAttributes = [
        'accesskey'=>['char'],
        'size'=>['int'],
        'name' => [],
        'value'=> [],
        'options'=>['array'],
        'multiple'=>['void'],
        'readonly'=>['void'],
        'disabled'=>['void'],
        'tabindex'=>['int'],
    ];

    /**
     * Specialized constructor that permits the initialization the initialization of the element.
     *
     * @param array $options
     * @param string|int $value
     * @param array $args
     * @return Select
     * @see MetaElement::create
     */
    public static function create(array $options, $value, array $args = []) {
        $args['options'] = $options;
        $args['value'] = $value;
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
        $value = $this->attributes['value'];
        foreach($this->attributes['options'] as $k=>$v) {
            $this->children[] = $this->renderOption($k,$v,($k == $value || $v == $value));
        }
        return parent::render();
    }

    /**
     * Adds options passed as array to the select
     *
     * @param array $args
     */
    public function addOptions(array $args) {
        foreach($args as $k=>$v) {
            $this->addOption($k,$v);
        }
    }

    /**
     * Removes all the options of the select
     *
     */
    public function removeOptions() {
        unset($this->attributes['options']);
        unset($this->attributes['value']);
    }

    /**
     * Adds an option to the select
     *
     * @param string|int $value
     * @param string $text
     * @param bool $selected
     */
    public function addOption($value,$text,$selected=false) {
        $this->attributes['options'][$value] = $text;
        if ($selected) {
            $this->attributes['value'] = $value;
        }
    }

    /**
     * Removes a specified option by his key from the select
     *
     * @param string|int $value
     */
    public function removeOption($value) {
        if ($this->attributes['value'] == $value) {
            unset($this->attributes['value']);
        }
        unset($this->attributes['options'][$value]);
    }

    /**
     * Render the option as an HTML string.
     *
     * @param string|int $value
     * @param string $text
     * @param bool $selected
     * @return string
     */
    private function renderOption($value,$text,$selected = false) {
        $out = '<option';
        if (!is_null($value)) {
            $out.=' value="'.htmlspecialchars($value).'"';
        }
        if ($selected) {
            $out.=' selected';
        }
        $out.='>'.$text.'</option>';
        return $out;
    }
}