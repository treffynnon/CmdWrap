<?php

namespace Treffynnon\CmdWrap\Types;

use Treffynnon\CmdWrap\Utils as U;

abstract class TypeAbstract implements TypeInterface
{
    const PREFIX = '';
    const SUFFIX = '';

    protected $value = '';
    protected $extraValue = '';

    public function __construct($value = '', $extraValue = '')
    {
        $this->setValue($value);
        $this->setExtraValue($extraValue);
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getRawValue()
    {
        return $this->value;
    }

    public function getValue()
    {
        return U\escapeCommand($this->getRawValue());
    }

    public function setExtraValue($value)
    {
        $this->extraValue = $value;
    }

    public function getRawExtraValue()
    {
        return $this->extraValue;
    }

    public function getExtraValue()
    {
        return U\escapeArgument($this->getRawExtraValue());
    }

    public function getString()
    {
        $str = static::PREFIX . $this->getValue() . static::SUFFIX;
        if ('' !== $this->getRawExtraValue() &&
            !is_null($this->getRawExtraValue())) {
            $str .= '=' . $this->getExtraValue();
        }
        return $str;
    }

    public function __toString()
    {
        return $this->getString();
    }
}
