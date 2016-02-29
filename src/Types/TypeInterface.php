<?php

namespace Treffynnon\CmdWrap\Types;

interface TypeInterface
{
    public function setValue($value);
    public function getValue();
    public function getRawValue();

    public function setExtraValue($value);
    public function getExtraValue();
    public function getRawExtraValue();

    public function getString();
}
