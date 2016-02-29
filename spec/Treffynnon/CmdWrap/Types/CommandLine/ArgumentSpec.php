<?php

namespace spec\Treffynnon\CmdWrap\Types\CommandLine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArgumentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Types\CommandLine\Argument');
        $this->shouldHaveType('Treffynnon\CmdWrap\Types\CommandLine\ArgumentInterface');
    }

    function it_can_accept_and_emit_values()
    {
        $this->setValue('argument');
        $this->getValue()->shouldBeLike('argument');
    }

    function it_can_return_with_correct_prefix()
    {
        $this->setValue('argument');
        $this->__toString()->shouldBeLike('--argument');
    }
}
