<?php

namespace spec\Treffynnon\CommandWrap\Types;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommandCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CommandWrap\Types\CommandCollection');
    }

    function it_can_push_items_onto_command($command, $envVar, $envVar2)
    {
        $command->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\CommandInterface');
        $command->getValue()->willReturn('simon');

        $envVar->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar->getValue()->willReturn('TEST');
        $envVar->getExtraValue()->willReturn("'123'");

        $envVar2->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar2->getValue()->willReturn('TEST_VAR');
        $envVar2->getExtraValue()->willReturn("'345'");

        $this->push($command);
        $this->push($envVar);
        $this->push($envVar2);
        $this->get()->shouldHaveCount(3);
        $r = $this->get();
        $r[0]->shouldBeAnInstanceOf('Treffynnon\\CommandWrap\\Types\\CommandLine\\CommandInterface');
        $r[0]->getValue()->shouldReturn('simon');

        $r[1]->shouldBeAnInstanceOf('Treffynnon\\CommandWrap\\Types\\CommandLine\\EnvVarInterface');
        $r[1]->getValue()->shouldReturn('TEST');
        $r[1]->getExtraValue()->shouldReturn("'123'");

        $r[2]->shouldBeAnInstanceOf('Treffynnon\\CommandWrap\\Types\\CommandLine\\EnvVarInterface');
        $r[2]->getValue()->shouldReturn('TEST_VAR');
        $r[2]->getExtraValue()->shouldReturn("'345'");
    }

    function it_can_filter($command, $envVar, $envVar2)
    {
        $command->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\CommandInterface');
        $command->getValue()->willReturn('simon');

        $envVar->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar->getValue()->willReturn('TEST');
        $envVar->getExtraValue()->willReturn("'123'");

        $envVar2->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar2->getValue()->willReturn('TEST_VAR');
        $envVar2->getExtraValue()->willReturn("'345'");

        $this->push($command);
        $this->push($envVar);
        $this->push($envVar2);

        $this->get()->shouldHaveCount(3);
        $result = $this->filter(function($item) {
            return !($item instanceOf \Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface);
        })->get();
        $result->shouldHaveCount(1);
    }

    function it_can_reduce($command, $envVar, $envVar2)
    {
        $command->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\CommandInterface');
        $command->getValue()->willReturn('simon');
        $command->getString()->willReturn('simon');

        $envVar->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar->getValue()->willReturn('TEST');
        $envVar->getExtraValue()->willReturn("'123'");
        $envVar->getString()->willReturn("TEST='123'");

        $envVar2->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar2->getValue()->willReturn('TEST_VAR');
        $envVar2->getExtraValue()->willReturn("'345'");
        $envVar2->getString()->willReturn("TEST_VAR='345'");

        $this->push($command);
        $this->push($envVar);
        $this->push($envVar2);

        $this->get()->shouldHaveCount(3);
        $this->reduce(function($carry, $item) {
            return $carry . $item->getString();
        })->shouldBeLike("simonTEST='123'TEST_VAR='345'");
    }

    function it_can_sort($command, $envVar, $envVar2)
    {
        $command->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\CommandInterface');
        $command->getValue()->willReturn('simon');
        $command->getString()->willReturn('simon');

        $envVar->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar->getValue()->willReturn('TEST_ENVV');
        $envVar->getExtraValue()->willReturn("'123'");
        $envVar->getString()->willReturn("TEST_ENVV='123'");

        $envVar2->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar2->getValue()->willReturn('TEST_VAR');
        $envVar2->getExtraValue()->willReturn("'345'");
        $envVar2->getString()->willReturn("TEST_VAR='345'");

        $this->push($command);
        $this->push($envVar);
        $this->push($envVar2);

        $this->get()->shouldHaveCount(3);
        $sorted = $this->sort(function($a, $b) {
            $a = strlen($a->getValue());
            $b = strlen($b->getValue());
            if ($a === $b) {
                return 0;
            }
            return ($a > $b) ? -1 : 1;
        });
        $sorted->get()->shouldHaveCount(3);
        $sorted->reduce(function($carry, $item) {
            return $carry . $item->getString();
        })->shouldBeLike("TEST_ENVV='123'TEST_VAR='345'simon");
    }

    function it_can_reverse($command, $envVar, $envVar2)
    {
        $command->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\CommandInterface');
        $command->getValue()->willReturn('simon');
        $command->getString()->willReturn('simon');

        $envVar->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar->getValue()->willReturn('TEST');
        $envVar->getExtraValue()->willReturn("'123'");
        $envVar->getString()->willReturn("TEST='123'");

        $envVar2->beADoubleOf('Treffynnon\CommandWrap\Types\CommandLine\EnvVarInterface');
        $envVar2->getValue()->willReturn('TEST_VAR');
        $envVar2->getExtraValue()->willReturn("'345'");
        $envVar2->getString()->willReturn("TEST_VAR='345'");

        $this->push($command);
        $this->push($envVar);
        $this->push($envVar2);

        $this->get()->shouldHaveCount(3);
        $reversed = $this->reverse();
        $reversed->get()->shouldHaveCount(3);
        $reversed->reduce(function($carry, $item) {
            return $carry . $item->getString();
        })->shouldBeLike("TEST_VAR='345'TEST='123'simon");
    }
}
