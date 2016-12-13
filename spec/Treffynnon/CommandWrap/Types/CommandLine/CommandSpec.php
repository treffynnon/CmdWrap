<?php

namespace spec\Treffynnon\CommandWrap\Types\CommandLine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandLine\Command');
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandLine\CommandInterface');
    }

    function it_can_accept_and_emit_values()
    {
        $this->setValue('command&&command');
        $this->getValue()->shouldBeLike('command\&\&command');
    }

    function it_doesnt_have_a_prefix_or_suffix()
    {
        $this->setValue('command&&command');
        $this->__toString()->shouldBeLike('command\&\&command');
    }
}
