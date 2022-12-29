<?php

namespace Meta\Classes;

class Formula
{
    private const BRACKETS_LIST = [
        '[' => ']',
        '(' => ')',
        '{' => '}',
    ];

    public function __construct(private string $formula)
    {
    }

    /**
     * Check is formula correct
     *
     * @return bool
     */
    public function check(): bool
    {
        $isValid                = true;
        $currentOpenedBrackets  = '';

        $openedBracketsList     = self::BRACKETS_LIST;
        $closedBracketsList     = array_flip(self::BRACKETS_LIST);
        $indexMax               = strlen($this->formula);

        // {[...]}   v
        // {[}]      x
        for ($index = 0; $index < $indexMax; $index ++) {
            $currentCharacter = $this->formula[$index];

            switch (true) {
                case ($openedBracketsList[$currentCharacter] ?? null) !== null:
                    $currentOpenedBrackets .= $currentCharacter;
                    break;

                case ($revertedOpenedBracket = $closedBracketsList[$currentCharacter] ?? null) !== null:
                    $lastOpenedBracket = substr($currentOpenedBrackets, -1);
                    $currentOpenedBrackets = substr($currentOpenedBrackets, 0, -1);

                    if ($lastOpenedBracket !== $revertedOpenedBracket) {
                        $isValid = false;
                    }

                    break;
            }
        }

        if (!empty($currentOpenedBrackets)) {
            $isValid = false;
        }

        return $isValid;
    }
}
