<?php

namespace spec\Treffynnon\CommandWrap\Runners;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Treffynnon\CommandWrap\Builder;

class ExecSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Runners\Exec');
    }

    function it_can_process_a_simple_command($builder, $response)
    {
        $builder->beADoubleOf('Treffynnon\CommandWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn("date '+%Y-%m-%d'");
        $response->beADoubleOf('Treffynnon\CommandWrap\ResponseInterface');
        $response->set("date '+%Y-%m-%d'", 0, [date('Y-m-d')], "")->shouldBeCalled();
        $this->setResponseClass($response);
        $this->run($builder)->shouldReturnAnInstanceOf('Treffynnon\CommandWrap\ResponseInterface');
    }
}
