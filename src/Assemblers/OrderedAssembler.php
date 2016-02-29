<?php

namespace Treffynnon\CmdWrap\Assemblers;

use Treffynnon\CmdWrap\Types\CommandLine;

class OrderedAssembler extends AssemblerAbstract implements AssemblerInterface
{
    const SORT_ORDER = [
        'EnvVarInterface',
        'CommandInterface',
        'FlagInterface',
        'ArgumentInterface',
        'ParameterInterface',
    ];

    public function getCommandString(callable $filter = null)
    {
        $sorted = $this->getCommandLine()
            ->sort(function ($a, $b) {
                $a = $this->getSortOrderByInterface($a);
                $b = $this->getSortOrderByInterface($b);
                if ($a === $b) {
                    return 0;
                }
                return ($a > $b) ? 1 : -1;
            });
        $assembler = new ChronoAssembler();
        $assembler->setCommandLine($sorted);
        return $assembler->getCommandString($filter);
    }

    protected function getSortOrderByInterface(CommandLine\CommandLineInterface $object)
    {
        foreach (static::SORT_ORDER as $key => $interface) {
            if (is_a($object, '\\Treffynnon\\CmdWrap\\Types\\CommandLine\\' . $interface)) {
                return $key;
            }
        }
        // anything else will be last
        return count(static::SORT_ORDER);
    }
}
