<?php

use Treffynnon\CmdWrap\Builder;
use Treffynnon\CmdWrap\Runners\Passthru;

class PassthruTest extends PHPUnit_Framework_TestCase
{
    public function testCanRunACommandWithPassthru()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%d-%m-%Y');
        $runner = new Passthru();
        $r = $runner->run($x);
        $this->assertSame("date '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame('', $r->getOutput());
        $this->assertSame(0, $r->getStatus());
    }

    public function testFailedPassthruCommand()
    {
        $x = new Builder();
        $x->addCommand('dat1e')
            ->addParameter('+%d-%m-%Y');
        $runner = new Passthru();
        $r = $runner->run($x);
        $this->assertSame("dat1e '+%d-%m-%Y'", $r->getCommand());
        $this->assertSame('', $r->getOutput());
        $this->assertSame(127, $r->getStatus());
    }
}
