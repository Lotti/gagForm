<?php namespace gagForm;

/**
 * Class VoidElement
 *
 * Abstract class that void elements must extended
 *
 * @package gagForm
 */
abstract class VoidElement extends CommonElement {
    /**
     * Defaulted to true for void element
     *
     * @var bool
     */
    protected static $void = true;
}