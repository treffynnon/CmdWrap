<?php

namespace spec\Treffynnon\CmdWrap\Assemblers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Treffynnon\CmdWrap\Types\CommandCollection;

class ChronoAssemblerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Assemblers\ChronoAssembler');
    }

    function it_should_call_filter(CommandCollection $cc)
    {
        $this->setCommandLine($cc);
        $cc->filter(null)->shouldBeCalled();
        $this->getCommandLine();
    }

    function it_can_filter_command_line($cc, $command, $flag)
    {
        $cc->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');
        $cc->reduce(Argument::type('closure'))->willReturn('test -v');
        $cc->filter(Argument::type('closure'))->willReturn($cc);

        $this->setCommandLine($cc);
        $this->getCommandString(function($item) {
            return !($item instanceOf \Treffynnon\CmdWrap\Types\EnvVarInterface);
        })->shouldReturn('test -v');
    }

    function it_can_assemble_a_command($cc, $command, $flag)
    {
        $cc->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');
        $cc->reduce(Argument::type('closure'))->willReturn('test -v');
        $cc->filter(null)->willReturn($cc);

        $this->setCommandLine($cc);
        $this->getCommandString()->shouldReturn('test -v');
    }
}
