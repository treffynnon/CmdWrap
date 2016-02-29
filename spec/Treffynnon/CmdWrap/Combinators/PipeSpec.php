<?php

namespace spec\Treffynnon\CmdWrap\Combinators;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Combinators\Pipe;

class PipeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Combinators\Pipe');
    }

    function it_can_combine_two_builders(Builder $builder, Builder $builder2)
    {
        $this->set($builder, $builder2);
        $r = $this->get();
        $r->shouldHaveCount(2);
        $r[0]->shouldHaveType('Treffynnon\CmdWrap\BuilderInterface');
        $r[1]->shouldHaveType('Treffynnon\CmdWrap\BuilderInterface');
    }

    function it_can_combine_builders_and_its_self($envVar, $commandLine, $assembler, $builder, $builder2)
    {
        $assembler->beADoubleOf('Treffynnon\CmdWrap\Assemblers\AssemblerInterface');
        $assembler->getCommandString(null)->willReturn('command');

        $builder->beADoubleOf('Treffynnon\CmdWrap\BuilderInterface');
        $builder->implement('Treffynnon\CmdWrap\Combinators\CombinableInterface');
        $builder->getCommandLine()->willReturn('first command');
        $builder->getCommandAssembler()->willReturn($assembler);

        $builder2->beADoubleOf('Treffynnon\CmdWrap\BuilderInterface');
        $builder2->implement('Treffynnon\CmdWrap\Combinators\CombinableInterface');
        $builder2->getCommandLine()->willReturn('second command');
        $builder2->getCommandAssembler()->willReturn($assembler);

        $combinator = new Pipe(
            $builder->getWrappedObject(),
            $builder2->getWrappedObject()
        );
        $this->set($combinator, $builder, $combinator, $builder2, $combinator);
        $r = $this->get();
        $r->shouldHaveCount(5);
        $r[0]->shouldHaveType('Treffynnon\CmdWrap\Combinators\CombinatorInterface');
        $r[1]->shouldHaveType('Treffynnon\CmdWrap\BuilderInterface');
        $r[2]->shouldHaveType('Treffynnon\CmdWrap\Combinators\CombinatorInterface');
        $r[3]->shouldHaveType('Treffynnon\CmdWrap\BuilderInterface');
        $r[4]->shouldHaveType('Treffynnon\CmdWrap\Combinators\CombinatorInterface');

        $this->getCommandAssembler()->getCommandString()->shouldBeLike('command | command | command | command | command | command | command | command');
    }
}
