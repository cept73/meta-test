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
        $currentOpenedBrackets  = '';

        $openedBracketsList     = self::BRACKETS_LIST;
        $closedBracketsList     = array_flip(self::BRACKETS_LIST);
        $indexMax               = strlen($this->formula);

        for ($index = 0; $index < $indexMax; $index ++) {
            $currentCharacter = $this->formula[$index];

            switch (true) {
                case ($openedBracketsList[$currentCharacter] ?? null) !== null:
                    $currentOpenedBrackets .= $currentCharacter;
                    break;

                case ($revertedClosedBracket = $closedBracketsList[$currentCharacter] ?? null) !== null:
                    if (empty($currentOpenedBrackets)) {
                        return false;
                    }

                    $lastOpenedBracket = substr($currentOpenedBrackets, -1);
                    $currentOpenedBrackets = substr($currentOpenedBrackets, 0, -1);
                    if ($lastOpenedBracket !== $revertedClosedBracket) {
                        return false;
                    }

                    break;
            }
        }

        return empty($currentOpenedBrackets);
    }
}
