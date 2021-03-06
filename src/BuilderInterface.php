<?php

namespace Treffynnon\CommandWrap;

use Treffynnon\CommandWrap\Assemblers\AssemblerInterface;
use Treffynnon\CommandWrap\Types\CommandCollectionInterface;

interface BuilderInterface
{
    public function __construct(
        AssemblerInterface $commandAssembler = null,
        CommandCollectionInterface $commandCollection = null
    );
    public function setCommandAssembler(AssemblerInterface $commandAssembler);
    public function setCommandCollection(CommandCollectionInterface $commandCollection);
    public function addEnvVar($variable, $value);
    public function addCommand($command);
    public function addFlag($flag, $value = null);
    public function addArgument($argument, $value = null);
    public function addParameter($parameter);

    /**
     * @return AssemblerInterface
     */
    public function getCommandAssembler();
    public function getCommandLine();
}
