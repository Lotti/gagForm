<?php namespace gagForm;

trait Validation {
    public static function validation_void($value) {
        return is_null($value) || empty($value) || $value === true || $value === false;
    }

    public static function validation_required($value) {
        return !empty($value);
    }

    public static function validation_url($value) {
        $value = parse_url($value);
        return is_array($value) && count($value) > 0;
    }

    public static function validation_bool($value) {
        return is_bool($value);
    }

    public static function validation_int($value) {
        return is_int($value);
    }

    public static function validation_string($value) {
        return is_string($value);
    }

    public static function validation_onoff($value) {
        $value = strtolower($value);
        return in_array($value, ['on','off']);
    }

    public static function validation_target($value) {
        $value = strtolower($value);
        return in_array($value, ['_self','_parent','_blank','_top'] || is_string($value));
    }
}