<?php

namespace spec\Treffynnon\CmdWrap;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseSpec extends ObjectBehavior
{
    protected $cmd = 'date -j';
    protected $out = 'Fri 21 Oct 2016 13:01:05 AEST';
    protected $sta = 0;
    protected $err = 'Warning! Problem.';

    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\ResponseInterface');
    }

    function let()
    {
        $this->set($this->cmd, $this->sta, $this->out, $this->err);
    }

    function it_should_be_able_to_set_values()
    {
        $this->getCommand()->shouldBeString();
        $this->getCommand()->shouldReturn($this->cmd);
        $this->getStatus()->shouldBeInteger();
        $this->getStatus()->shouldReturn($this->sta);
        $this->getOutput()->shouldBeString();
        $this->getOutput()->shouldReturn($this->out);
        $this->getError()->shouldBeString();
        $this->getError()->shouldReturn($this->err);

        $this->shouldThrow('\Exception')
            ->duringSet($this->cmd, $this->sta, $this->out, $this->err);
    }

    function it_should_detect_if_was_successful()
    {
        $this->wasSuccess()->shouldReturn(true);
    }

    function it_should_return_output_as_array()
    {
        $this->getOutputAsArray()->shouldReturn([$this->out]);
    }

    function it_should_return_error_output_as_array()
    {
        $this->getErrorAsArray()->shouldReturn([$this->err]);
    }
}
