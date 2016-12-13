<?php

namespace spec\Treffynnon\CommandWrap\Types\CommandLine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParameterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandLine\Parameter');
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandLine\ParameterInterface');
    }

    function it_can_take_and_emit_parameters()
    {
        $this->setValue('help');
        $this->getValue()->shouldBeLike("'help'");
    }

    function it_doesnt_have_prefix_or_suffix()
    {
        $this->setValue('help');
        $this->__toString()->shouldBeLike("'help'");
    }
}
