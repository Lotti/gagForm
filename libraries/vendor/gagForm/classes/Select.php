<?php namespace gagForm;

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

    public static function create(array $options, $value, array $args = []) {
        $args['options'] = $options;
        $args['value'] = $value;
        return parent::create($args);
    }

    public function render() {
        $this->children = [];
        $value = $this->attributes['value'];
        foreach($this->attributes['options'] as $k=>$v) {
            $this->children[] = $this->renderOption($k,$v,($k == $value || $v == $value));
        }
        return parent::render();
    }

    public function addOptions(array $args) {
        foreach($args as $k=>$v) {
            $this->addOption($k,$v);
        }
    }

    public function removeOptions() {
        unset($this->attributes['options']);
        unset($this->attributes['value']);
    }

    public function addOption($value,$text,$selected=false) {
        $this->attributes['options'][$value] = $text;
        if ($selected) {
            $this->attributes['value'] = $value;
        }
    }

    public function removeOption($value) {
        if ($this->attributes['value'] == $value) {
            unset($this->attributes['value']);
        }
        unset($this->attributes['options'][$value]);
    }

    private function renderOption($value,$text,$selected=false) {
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