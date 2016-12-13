<?php

use Treffynnon\CommandWrap\Builder;
use Treffynnon\CommandWrap\Runners\SymfonyProcess;

class SymfonyProcessTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithSymfonyProcess()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $runner = new SymfonyProcess();
        $r = $runner->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-Y'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandWithSymfonyProcessCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $runner = new SymfonyProcess();
        $r = $runner->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedSymfonyProcessCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $runner = new SymfonyProcess();
        $r = $runner->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame('', trim($r->getOutput()));
        $this->assertSame(127, $r->getStatus());
        $this->assertSame("sh: dat1e: command not found\n", $r->getError());
    }
}
