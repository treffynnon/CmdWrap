<?php

namespace spec\Treffynnon\CommandWrap\Runners;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Treffynnon\CommandWrap\Builder;

class PassthruSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Runners\Passthru');
    }

    function it_can_process_a_simple_command($builder, $response)
    {
        $builder->beADoubleOf('Treffynnon\CommandWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn("date '+%Y-%m-%d'");
        $response->beADoubleOf('Treffynnon\CommandWrap\ResponseInterface');
        $response->set("date '+%Y-%m-%d'", 0, "", "")->shouldBeCalled();
        $this->setResponseClass($response);
        ob_start();
        $this->run($builder)->shouldReturnAnInstanceOf('Treffynnon\CommandWrap\ResponseInterface');
        $response = ob_get_clean();
        expect(trim($response))->shouldBeLike(date('Y-m-d'));
    }
}
