<?php /** @noinspection ForgottenDebugOutputInspection */

namespace Meta\Classes;

/**
 * Functional run tests for Formula class
 *
 * Usage: (new FormulaTests([%case => %isCorrect, ...])->run();
 * For example ['()' => true]
 */
class FormulaTests
{
    public function __construct(private array $testCases, private bool $debugFlag = true)
    {
    }

    public function run(): void
    {
        foreach ($this->testCases as $formulaString => $isFormulaCorrect) {
            $formula = new Formula($formulaString);
            $isCheckCorrect = $formula->check();

            if ($isCheckCorrect === $isFormulaCorrect) {
                print " [v] $formulaString\r\n";
                continue;
            }

            print " [x] $formulaString\r\n";
            if ($this->debugFlag) {
                print_r($formula->getLastErrors());
            }
        }
    }
}
