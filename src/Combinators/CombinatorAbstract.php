<?php

namespace Treffynnon\CommandWrap\Combinators;

abstract class CombinatorAbstract implements CombinatorInterface
{
    protected $items;

    public function __construct(CombinableInterface ...$items)
    {
        $this->set(...$items);
    }

    public function add(CombinableInterface $item)
    {
        $this->items = $item;
    }

    public function get()
    {
        return $this->items;
    }

    public function set(CombinableInterface ...$items)
    {
        $this->items = $items;
    }


    public function getCommandAssembler()
    {
        $assembler = new CombinatorAssembler();
        $assembler->set(...$this->get());
        $assembler->setSeperator(static::SEPARATOR);
        return $assembler;
    }

    public function __toString()
    {
        return (string) $this->getCommandAssembler();
    }
}
