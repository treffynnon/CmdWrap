<?php

namespace spec\Treffynnon\CmdWrap\Runners;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Treffynnon\CmdWrap\Builder;

class SystemSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Runners\System');
    }

    function it_can_process_a_simple_command($builder, $response)
    {
        $builder->beADoubleOf('Treffynnon\CmdWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn("date '+%Y-%m-%d'");
        $response->beADoubleOf('Treffynnon\CmdWrap\ResponseInterface');
        $response->set("date '+%Y-%m-%d'", 0, date('Y-m-d'), "")->shouldBeCalled();
        $this->setResponseClass($response);
        $this->run($builder)->shouldReturnAnInstanceOf('Treffynnon\CmdWrap\ResponseInterface');
    }
}
