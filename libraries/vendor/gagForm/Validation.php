<?php namespace gagForm;

class Validation {
    public static function void($value) {
        return empty($value);
    }

    public static function required($value) {
        return !empty($value);
    }

    public static function url($value) {
        $value = parse_url($value);
        return is_array($value) && count($value) > 0;
    }

    public static function int($value) {
        return is_int($value);
    }

    public static function string($value) {
        return is_string($value);
    }

    public static function OnOff($value) {
        $value = strtolower($value);
        return in_array($value, ['on','off']);
    }
}