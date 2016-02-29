<?php

namespace spec\Treffynnon\CmdWrap\Types\CommandLine;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnvVarSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Types\CommandLine\EnvVar');
        $this->shouldHaveType('Treffynnon\CmdWrap\Types\CommandLine\EnvVarInterface');
    }

    function it_can_accept_and_emit_values()
    {
        $this->setValue('envar');
        $this->setExtraValue('value');
        $this->getValue()->shouldBeLike('envar');
        $this->getExtraValue()->shouldBeLike("'value'");
    }

    function it_can_return_with_correct_prefix()
    {
        $this->setValue('envar');
        $this->setExtraValue('value');
        $this->__toString()->shouldBeLike("envar='value'");
    }
}
