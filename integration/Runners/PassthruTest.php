<?php

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Runners\Passthru;

class PassthruTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithExec()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $r = new Passthru();
        $r->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame('', $r->getOutput());
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedExecCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $r = new Passthru();
        $r->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getLastCommand());
        $this->assertSame('', $r->getOutput());
        $this->assertSame(127, $r->getStatus());
    }
}
