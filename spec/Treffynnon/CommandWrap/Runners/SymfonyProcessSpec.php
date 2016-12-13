<?php

namespace spec\Treffynnon\CommandWrap\Runners;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use Treffynnon\CommandWrap\Builder;
use Treffynnon\CommandWrap\Types\CommandLine\EnvVar;

class SymfonyProcessSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Runners\SymfonyProcess');
    }

    function it_can_process_a_simple_command($assembler, $builder, $commandLine, $response)
    {
        $commandLine->beADoubleOf('Treffynnon\CommandWrap\Types\CommandCollectionInterface');
        $commandLine->get()->willReturn(array());
        $assembler->beADoubleOf('Treffynnon\CommandWrap\Assemblers\AssemblerInterface');
        $assembler->getCommandString(Argument::type('closure'))->willReturn("date '+%Y-%m-%d'");
        $assembler->getCommandLine(Argument::type('closure'))->willReturn($commandLine);
        $builder->beADoubleOf('Treffynnon\CommandWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn($assembler);
        $response->beADoubleOf('Treffynnon\CommandWrap\ResponseInterface');
        $response->set("date '+%Y-%m-%d'", 0, date('Y-m-d') . "\n", "")->shouldBeCalled();
        $this->setResponseClass($response);

        $this->run($builder)->shouldReturnAnInstanceOf('Treffynnon\CommandWrap\ResponseInterface');
    }

    function it_can_filter_out_env_vars($assembler, $builder)
    {
        $assembler->beADoubleOf('Treffynnon\CommandWrap\Assemblers\AssemblerInterface');
        $assembler->getCommandString(Argument::type('closure'))->willReturn("date '+%Y-%m-%d'");
        $builder->beADoubleOf('Treffynnon\CommandWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn($assembler);
        $this->getCommandStringExcludingEnvVars($builder)->shouldBeLike("date '+%Y-%m-%d'");
    }

    function it_can_get_a_list_of_env_vars($assembler, $builder, $commandLine, $envVar)
    {
        $envVar->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar->getValue()->willReturn('BIN_PATH');
        $envVar->getExtraValue()->willReturn("'/var/bin'");
        $commandLine->beADoubleOf('Treffynnon\CommandWrap\Types\CommandCollectionInterface');
        $commandLine->get()->willReturn(array($envVar));
        $assembler->beADoubleOf('Treffynnon\CommandWrap\Assemblers\AssemblerInterface');
        $assembler->getCommandLine(Argument::type('closure'))->willReturn($commandLine);
        $builder->beADoubleOf('Treffynnon\CommandWrap\Types\RunnableInterface');
        $builder->getCommandAssembler()->willReturn($assembler);

        $r = $this->getEnvVarArray($builder);
        $r->shouldBeArray();
        $r->shouldHaveCount(1);
        $r[0]->shouldBeAnInstanceOf('Treffynnon\\CommandWrap\\Types\\CommandLine\\EnvVarInterface');
        $r[0]->getValue()->shouldReturn('BIN_PATH');
        $r[0]->getExtraValue()->shouldReturn("'/var/bin'");
    }

    function it_wraps_an_anonymous_function()
    {
        $closure = $this->prepareSymfonyProcessCallable(function ($item) { echo "Item: $item"; });
        $closure->shouldBeCallable();
        ob_start();
        $closure('simon', '2');
        $r = ob_get_clean();
        expect($r)->shouldBeLike('Item: 2');
    }
}
