# Command Wrap

A PHP library to wrap the command line/terminal/shell. It provides a clean
builder that escapes arguments and commands - you can extract a command
string to run as you please or pass the builder to a runner.

## Installation

```bash
composer require treffynnon/command-wrap
```

## Example

```php
$bld = new Builder();
$bld->addEnvVar('JAVA_BIN', '/usr/bin/java')
    ->addEnvVar('TMP_DIR', '/tmp')
    ->addCommand('foo')
    ->addFlag('f')
    ->addFlag('t', 'xml')
    ->addCommand('src/')
    ->addArgument('verbose')
    ->addArgument('results-log', '/tmp/results.log')
    ->addRaw('> /dev/null 2>&1');
$sp = new SymfonyProcess();
$response = $sp->run($bld);
// JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log' > /dev/null 2>&1
```

### Using a callback to process output

Each line of the command's output can be processed by a callback/anonymous/lambda function.
You can of course pass in a closure too!

```php
$bld = new Builder();
$bld->addEnvVar('JAVA_BIN', '/usr/bin/java')
    ->addEnvVar('TMP_DIR', '/tmp')
    ->addCommand('foo')
    ->addFlag('f')
    ->addFlag('t', 'xml')
    ->addCommand('src/')
    ->addArgument('verbose')
    ->addArgument('results-log', '/tmp/results.log')
    ->addRaw('> /dev/null 2>&1');
$sp = new SymfonyProcess();
$response = $sp->run($bld, function ($line) {
    return str_replace("\t", '    ', $line);
});
// JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log' > /dev/null 2>&1
```

This would replace all tabs with four (4) spaces in each line of output from the command.
Note that the new value must be returned from your lambda.

You can then get the output in the usual way by calling `$response->getOutput()`.

If you want to have updates in real time from long running command then you need
to use the `SymfonyProcess` runner and log/echo from your custom callback function.

```php
$response = $sp->run($bld, function ($line) use ($logger) {
    $logger->push("New line added: $line");
    return str_replace("\t", '    ', $line);
});
```

### Getting a command as a string

```php
$bld = new Builder();
$bld->addEnvVar('JAVA_BIN', '/usr/bin/java')
    ->addEnvVar('TMP_DIR', '/tmp')
    ->addCommand('hint&&hint')
    ->addCommand('foo')
    ->addFlag('f')
    ->addFlag('t', 'xml')
    ->addCommand('src/')
    ->addArgument('verbose')
    ->addArgument('results-log', '/tmp/results.log')
    ->addRaw('> /dev/null 2>&1');
$cmd = $bld->getCommandAssembler()
           ->getCommandString();
// JAVA_BIN='/usr/bin/java' TMP_DIR='/tmp' foo -f -t='xml' src/ --verbose --results-log='/tmp/results.log' > /dev/null 2>&1
```

## Available command line types

| Type        | Builder method                                | Example final output           |
| ----------- | --------------------------------------------- | ------------------------------ |
| `Command`   | `addCommand('ls');`                           | `ls`                           |
| `Flag`      | `addFlag('-t');`                              | `-t`                           |
| `Flag`      | `addFlag('-t', '/tmp');`                      | `-t='/tmp'`                    |
| `Argument`  | `addArgument('results');`                     | `--results`                    |
| `Argument`  | `addArgument('results', '/tmp/results.log');` | `--results='/tmp/results.log'` |
| `Parameter` | `addParameter('parameter');`                  | `'parameter'`                  |
| `EnvVar`    | `addEnvVar('MY_ENV_VAR', 'value');`           | `MY_ENV_VAR='value'`           |
| `Raw`       | `addRaw('> /dev/null 2>&1')`                  | `> /dev/null 2>&1`             |

**Note:** As the name implies `Raw` does not perform any escaping - use with
appropriate caution.

## Available runners

* Symfony Process (`Treffynnon\CommandWrap\Runners\SymfonyProcess`) _recommended_
* `exec()` (`Treffynnon\CommandWrap\Runners\Exec`)
* `passthru()` (`Treffynnon\CommandWrap\Runners\Passthru`)
* `system()` (`Treffynnon\CommandWrap\Runners\System`)

By implementing `Treffynnon\CommandWrap\Runners\RunnerInterface` you can also
provide your own custom runner.

When a command is executed via a runner it will return an instance of `\Treffynnon\CommandWrap\Response`
containing the response from STDOUT and STDERR if available.

## Command combinators

POSIX commands can be combined with a few characters such as:

* && (`Treffynnon\CommandWrap\Combinators\AndAnd`)
* | (`Treffynnon\CommandWrap\Combinators\Pipe`)
* ; (`Treffynnon\CommandWrap\Combinators\Semicolon`)

These have been wrapped up into objects that you can use to combine
commands/builders. You can also combine combinators too!

```php
$combinator = new AndAnd(
    $builder,
    $builder2
);
$combinator2 = new Semicolon(
    $combinator,
    $builder3,
    $builder4
);
```

These can then be passed to a runner just like any builder can be:

```php
$Exec = new Exec();
$Exec->run($combinator2);
```

## Command assemblers

When a command is being converted into a string an assembler will be used
by default it will use the `ChronoAssembler`, but you can also use
`OrderedAssembler` or even provide your own by implementing `AssemblerInterface`.

`ChronoAssembler` compiles a command in the order it was added to the
builder (chronologically). `OrderedAssembler` combines into a specified
order - see the class for details.

To specify the assembler to use you provide an instance of it to the `Builder`
object.

```php
$bld = new Builder(new OrderedAssembler());
$bld->addEnvVar('JAVA_BIN', '/usr/bin/java')
    ->addCommand('hint&&hint')
    ->addCommand('foo')
    ->addFlag('f')
    ->addFlag('t', 'xml')
    ->addCommand('src/')
    ->addArgument('verbose')
    ->addArgument('results-log', '/tmp/results.log');
```

## Custom command collection

It is also possible to provide your own command collection class as the
second parameter to your `Builder` instance.

```php
$bld = new Builder(new ChronoAssembler(), new MyCommandCollection());
$bld->addEnvVar('JAVA_BIN', '/usr/bin/java')
    ->addCommand('hint&&hint')
    ->addCommand('foo')
    ->addFlag('f')
    ->addFlag('t', 'xml')
    ->addCommand('src/')
    ->addArgument('verbose')
    ->addArgument('results-log', '/tmp/results.log');
```

Again implement the `CommandCollectionInterface`.

## Tests

Unit testing is completed with phpspec, integration testing with phpunit
and the code is also linted with `php -l`, phpcs and phpcpd. To run the
tests you can use the following composer command:

```bash
composer test
```

## Licence

BSD 3 clause licence - see LICENCE.md.
