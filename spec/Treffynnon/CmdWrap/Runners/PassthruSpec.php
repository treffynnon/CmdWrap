<?php

namespace spec\Treffynnon\CmdWrap\Runners;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Treffynnon\CmdWrap\Builder;

class PassthruSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Runners\Passthru');
    }

    function it_can_process_a_simple_command($builder)
    {
        $builder->beADoubleOf('Treffynnon\CmdWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn("date '+%Y-%m-%d'");
        ob_start();
        $this->run($builder);
        $this->getLastCommand()->shouldBeLike("date '+%Y-%m-%d'");
        $response = ob_get_clean();
        expect(trim($response))->shouldBeLike(date('Y-m-d'));
    }
}
