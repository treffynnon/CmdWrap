<?php

namespace spec\Treffynnon\CommandWrap\Types\CommandLine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RawSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandLine\Raw');
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandLine\RawInterface');
    }

    function it_can_accept_and_emit_values()
    {
        $this->setValue('raw');
        $this->getValue()->shouldBeLike('raw');
    }

    function it_doesnt_have_a_prefix_or_suffix()
    {
        $this->setValue('raw');
        $this->__toString()->shouldBeLike('raw');
    }
}
