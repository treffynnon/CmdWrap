<?php

namespace spec\Treffynnon\CmdWrap\Assemblers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Treffynnon\CmdWrap\Types\CommandCollection;

class OrderedAssemblerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Assemblers\OrderedAssembler');
    }

    function it_should_call_filter(CommandCollection $cc)
    {
        $this->setCommandLine($cc);
        $cc->filter(null)->shouldBeCalled();
        $this->getCommandLine();
    }

    function it_can_assemble_a_command($cc)
    {
        $cc->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');
        $cc->reduce(Argument::type('closure'))->willReturn("TEST='value' test -v --verbose '/tmp/test.vv'");
        $cc->filter(null)->willReturn($cc);
        $cc->sort(Argument::type('closure'))->willReturn($cc);
        $cc->push(Argument::type('Treffynnon\CmdWrap\Types\CommandLine\CommandLineInterface'))->willReturn(null);

        $this->setCommandLine($cc);
        $this->getCommandString()->shouldReturn("TEST='value' test -v --verbose '/tmp/test.vv'");
    }
}
