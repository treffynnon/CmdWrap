<?php

namespace spec\Treffynnon\CmdWrap;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Treffynnon\CmdWrap\Builder');
    }

    function it_should_have_ability_to_add_a_command()
    {
        $this->addCommand('simon');
    }

    function it_print_command_to_string($assembler, $collection)
    {
        $assembler->beADoubleOf('Treffynnon\CmdWrap\Assemblers\AssemblerInterface');
        $assembler->setCommandLine(Argument::type('object'))->willReturn(null);
        $assembler->getCommandString()->willReturn('simon');

        $collection->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');

        $this->beConstructedWith($assembler, $collection);

        $this->addCommand('simon');
        $this->getCommandAssembler()->getCommandString()->shouldBeLike('simon');
    }

    function it_should_build_a_complex_command_string($assembler, $collection)
    {
        $assembler->beADoubleOf('Treffynnon\CmdWrap\Assemblers\AssemblerInterface');
        $assembler->setCommandLine(Argument::type('object'))->willReturn(null);
        $assembler->getCommandString()->willReturn("Simon -f -t='xml' src/ --verbose --results-log='/tmp/results.log'");

        $collection->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');
        $collection->push(Argument::type('Treffynnon\CmdWrap\Types\CommandLine\CommandLineInterface'))->willReturn(null);

        $this->beConstructedWith($assembler, $collection);

        $this->addCommand('Simon')
             ->addFlag('f')
             ->addFlag('t', 'xml')
             ->addCommand('src/')
             ->addArgument('verbose')
             ->addArgument('results-log', '/tmp/results.log')
             ->getCommandAssembler()
             ->getCommandString()
             ->shouldBeLike("Simon -f -t='xml' src/ --verbose --results-log='/tmp/results.log'");

    }

    function it_should_build_an_ultra_complex_command_string($assembler, $collection)
    {
        $assembler->beADoubleOf('Treffynnon\CmdWrap\Assemblers\AssemblerInterface');
        $assembler->setCommandLine(Argument::type('object'))->willReturn(null);
        $assembler->getCommandString()->willReturn("JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' hint\&\&hint foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log'");

        $collection->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');

        $this->beConstructedWith($assembler, $collection);

        $this->addEnvVar('JAVA_BIN', '/usr/bin/java')
             ->addEnvVar('TMP_DIR', '/tmp')
             ->addCommand('hint&&hint')
             ->addCommand('foo')
             ->addFlag('f')
             ->addFlag('t', 'xml')
             ->addCommand('src/')
             ->addArgument('verbose')
             ->addArgument('results-log', '/tmp/results.log')
             ->getCommandAssembler()
             ->getCommandString()
             ->shouldBeLike("JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' hint\&\&hint foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log'");
    }

    function it_should_build_an_ultra_complex_command_string_filtering_out_env_vars($assembler, $collection)
    {
        $assembler->beADoubleOf('Treffynnon\CmdWrap\Assemblers\AssemblerInterface');
        $assembler->setCommandLine(Argument::type('object'))->willReturn(null);
        $assembler->getCommandString(Argument::type('closure'))->willReturn("hint\&\&hint foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log' > /dev/null 2>&1");

        $collection->beADoubleOf('Treffynnon\CmdWrap\Types\CommandCollectionInterface');

        $this->beConstructedWith($assembler, $collection);

        $this->addEnvVar('JAVA_BIN', '/usr/bin/java')
             ->addEnvVar('TMP_DIR', '/tmp')
             ->addCommand('hint&&hint')
             ->addCommand('foo')
             ->addFlag('f')
             ->addFlag('t', 'xml')
             ->addCommand('src/')
             ->addArgument('verbose')
             ->addArgument('results-log', '/tmp/results.log')
             ->addRaw('> /dev/null 2>&1')
             ->getCommandAssembler()
             ->getCommandString(function($item) {
                 return !($item instanceOf \Treffynnon\CmdWrap\Types\CommandLine\EnvVarInterface);
             })
             ->shouldBeLike("hint\&\&hint foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log' > /dev/null 2>&1");
    }
}
