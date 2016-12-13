<?php

use Treffynnon\CommandWrap\Builder;
use Treffynnon\CommandWrap\Runners\System;

class SystemTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithExec()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $runner = new System();
        $r = $runner->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-Y'), $r->getOutput());
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandSystemCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $runner = new System();
        $r = $runner->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedExecCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $runner = new System();
        $r = $runner->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame('', $r->getOutput());
        $this->assertSame(127, $r->getStatus());
    }
}
