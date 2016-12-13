<?php

use Treffynnon\CommandWrap\Builder;

class BuilderTest extends PHPUnit_Framework_TestCase
{
    public function testCanBuildSimpleCommand()
    {
        $x = new Builder();
        $x->addCommand('date')
          ->addParameter('+%Y-%m-%d');
        $this->assertSame("date '+%Y-%m-%d'", (string) $x);
    }

    public function testCanBuildComplexCommand()
    {
        $x = new Builder();
        $x->addEnvVar('JAVA_BIN', '/usr/bin/java')
          ->addEnvVar('TMP_DIR', '/tmp')
          ->addCommand('hint&&hint')
          ->addCommand('foo')
          ->addFlag('f')
          ->addFlag('t', 'xml')
          ->addCommand('src/')
          ->addArgument('verbose')
          ->addArgument('results-log', '/tmp/results.log')
          ->addRaw('> /dev/null 2>&1')
          ->getCommandAssembler()
          ->getCommandString();

        $this->assertSame(
            "JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' hint\&\&hint foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log' > /dev/null 2>&1",
            (string) $x
        );
    }
}
