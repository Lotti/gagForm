<?php namespace gagForm;

trait Validation {
    public static function validation_void($value) {
        return empty($value);
    }

    public static function validation_required($value) {
        return !empty($value);
    }

    public static function validation_url($value) {
        $value = parse_url($value);
        return is_array($value) && count($value) > 0;
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
}