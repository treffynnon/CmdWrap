<?php

namespace Treffynnon\CmdWrap;

use Treffynnon\CmdWrap\Combinators\CombinableInterface;
use Treffynnon\CmdWrap\Types\CommandCollectionInterface;
use Treffynnon\CmdWrap\Types\CommandLine as CL;
use Treffynnon\CmdWrap\Types\CommandCollection;
use Treffynnon\CmdWrap\Assemblers\ChronoAssembler;
use Treffynnon\CmdWrap\Assemblers\AssemblerInterface;
use Treffynnon\CmdWrap\Types\RunnableInterface;

class Builder implements BuilderInterface, CombinableInterface, RunnableInterface
{
    /**
     * @var CommandCollectionInterface
     */
    protected $command;
    /**
     * @var AssemblerInterface
     */
    protected $commandAssembler;

    public function __construct(
        AssemblerInterface $commandAssembler = null,
        CommandCollectionInterface $commandCollection = null
    ) {
        $this->setCommandAssembler(new ChronoAssembler());
        if ($commandAssembler) {
            $this->setCommandAssembler($commandAssembler);
        }
        $this->command = new CommandCollection();
        if ($commandCollection) {
            $this->setCommandCollection($commandCollection);
        }
    }

    public function setCommandAssembler(AssemblerInterface $commandAssembler)
    {
        $this->commandAssembler = $commandAssembler;
    }

    public function setCommandCollection(CommandCollectionInterface $commandCollection)
    {
        $this->command = $commandCollection;
    }

    public function addEnvVar($variable, $value)
    {
        return $this->add(new CL\EnvVar($variable, $value));
    }

    public function addCommand($command)
    {
        return $this->add(new CL\Command($command));
    }

    public function addFlag($flag, $value = null)
    {
        return $this->add(new CL\Flag($flag, $value));
    }

    public function addArgument($argument, $value = null)
    {
        return $this->add(new CL\Argument($argument, $value));
    }

    public function addParameter($parameter)
    {
        return $this->add(new CL\Parameter($parameter));
    }

    public function addRaw($redirect)
    {
        return $this->add(new CL\Raw($redirect));
    }

    public function add(CL\CommandLineInterface $commandLine)
    {
        $this->command->push($commandLine);
        return $this;
    }

    /**
     * @return AssemblerInterface
     */
    public function getCommandAssembler()
    {
        $assembler = clone $this->commandAssembler;
        $assembler->setCommandLine($this->getCommandLine());
        return $assembler;
    }

    public function getCommandLine()
    {
        return $this->command;
    }

    public function __toString()
    {
        return (string) $this->getCommandAssembler();
    }
}
