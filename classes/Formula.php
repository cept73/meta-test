<?php

namespace Meta\Classes;

class Formula
{
    private const BRACKETS_LIST = [
        '[' => ']',
        '(' => ')',
        '{' => '}',
    ];

    private array $lastErrors = [];

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
        $this->lastErrors       = [];
        $currentOpenedBrackets  = [];

        $openedBracketsList     = self::BRACKETS_LIST;
        $closedBracketsList     = array_flip(self::BRACKETS_LIST);
        $indexMax               = strlen($this->formula);

        for ($index = 0; $index < $indexMax; $index ++) {
            $currentCharacter = $this->formula[$index];

            switch (true) {
                case ($openedBracketsList[$currentCharacter] ?? null) !== null:
                    $currentOpenedBracketsCount = $currentOpenedBrackets[$currentCharacter] ?? 0;
                    $currentOpenedBrackets[$currentCharacter] = $currentOpenedBracketsCount + 1;
                    break;

                case ($openedBracket = $closedBracketsList[$currentCharacter] ?? null) !== null:
                    $currentOpenedBracketsCount = $currentOpenedBrackets[$openedBracket] ?? 0;
                    $newOpenedBracketsCount = $currentOpenedBracketsCount - 1;

                    if ($newOpenedBracketsCount < 0) {
                        $isValid = false;
                        $this->lastErrors[] = "Unexpected closed $openedBracket\r\n";
                    } else {
                        $currentOpenedBrackets[$openedBracket] = $newOpenedBracketsCount;
                    }

                    break;
            }
        }

        foreach ($currentOpenedBrackets as $bracketChar => $bracketOpenedCount) {
            if (!$bracketOpenedCount) {
                continue;
            }

            $isValid = false;

            if ($bracketOpenedCount > 0) {
                $this->lastErrors[] = "Still opened $bracketOpenedCount $bracketChar\r\n";
            }
        }

        return $isValid;
    }

    /**
     * Get last check errors if any
     *
     * @return string[]
     */
    public function getLastErrors(): array
    {
        return $this->lastErrors;
    }
}

