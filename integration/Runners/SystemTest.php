<?php

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Runners\System;

class SystemTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithExec()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $r = new System();
        $r->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(date('d-m-Y'), $r->getOutput());
        $this->assertSame(0, $r->getStatus());
    }

    public function testCanRunACommandSystemCallable()
    {
        $x = new Builder();
        $x->addCommand('date')
            ->addParameter('+%d-%m-%Y');
        $r = new System();
        $r->run($x, function ($line) {
            return str_replace(date('Y'), '', $line);
        });
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame(date('d-m-'), trim($r->getOutput()));
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedExecCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $r = new System();
        $r->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame('', $r->getOutput());
        $this->assertSame(127, $r->getStatus());
    }
}
