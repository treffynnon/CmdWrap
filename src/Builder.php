<?php

namespace Treffynnon\CommandWrap;

use Treffynnon\CommandWrap\Combinators\CombinableInterface;
use Treffynnon\CommandWrap\Types\CommandCollectionInterface;
use Treffynnon\CommandWrap\Types\CommandLine as CL;
use Treffynnon\CommandWrap\Types\CommandCollection;
use Treffynnon\CommandWrap\Assemblers\ChronoAssembler;
use Treffynnon\CommandWrap\Assemblers\AssemblerInterface;
use Treffynnon\CommandWrap\Types\RunnableInterface;

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

    /**
     * Ensure that we get a fresh CommandCollection object when the builder
     * is cloned to prevent builders from working on the same Collection. If
     * they did then commands would be added to the same collection.
     */
    public function __clone()
    {
        $this->setCommandCollection(clone $this->command);
    }
}
