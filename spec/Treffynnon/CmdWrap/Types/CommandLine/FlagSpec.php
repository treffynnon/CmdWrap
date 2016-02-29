<?php

namespace spec\Treffynnon\CmdWrap\Types\CommandLine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FlagSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Types\CommandLine\Flag');
        $this->shouldHaveType('Treffynnon\CmdWrap\Types\CommandLine\FlagInterface');
    }

    function it_can_accept_and_emit_values()
    {
        $this->setValue('flagged');
        $this->getValue()->shouldBeLike('flagged');
    }

    function it_can_return_with_correct_prefix()
    {
        $this->setValue('flagged');
        $this->__toString()->shouldBeLike('-flagged');
    }
}
