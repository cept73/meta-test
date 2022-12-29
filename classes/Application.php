<?php

namespace Meta\Classes;

class Application
{
    public const RESPONSE_CORRECT = 'Верно';
    public const RESPONSE_INCORRECT = 'Не верно';

    public const TEST_CASES = [
        '[({})]'    => true,
        '[(})]'     => false,
        '[({)]'     => false,
        '[({})'     => false,
        ')('        => false,
        '[(])'      => false
    ];

    public function __construct(array $arguments)
    {
        $argumentsCount = count($arguments);

        if ($argumentsCount === 1) {
            $argument = $arguments[0];

            if ($argument === '-t') {
                self::test();
                return;
            }

            print (self::run($argument) ? self::RESPONSE_CORRECT : self::RESPONSE_INCORRECT) . "\r\n";
            return;
        }

        self::help();
    }

    public static function help(): void
    {
        print <<<TEXT
Usage:
    `php check-formula.php {([])}`
        - will check formula and return is it correct or not and writes an answer.
        better use quotes notation "{([])}" to avoid issues with command line interpreter

    `php check-formula.php -t` 
        - will run tests with some cases
TEXT;
    }

    public static function run($formulaString): bool
    {
        return (new Formula($formulaString))->check();
    }

    public static function test(): void
    {
        (new FormulaTests(self::TEST_CASES))->run();
    }
}
