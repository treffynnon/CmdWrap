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

    function it_can_process_a_simple_command($builder)
    {
        $builder->beADoubleOf('Treffynnon\CmdWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn("date '+%Y-%m-%d'");
        $this->run($builder);
        $this->getLastCommand()->shouldBeLike("date '+%Y-%m-%d'");
        $this->getOutput()->shouldContain(date('Y-m-d'));
    }
}
