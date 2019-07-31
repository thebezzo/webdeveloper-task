<?php

namespace App\Utilities;

class PatternUtility
{
    /**
     * @var string[]
     */
    private const REGEX_TYPE = [
        '{id}' => '(\d+)'
    ];

    /**
     * @var string
     */
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function transformToRegex(): string
    {
        $match = preg_match_all('/{[\s\S]+?}/', $this->pattern, $matches, PREG_SET_ORDER , 0);
        $this->validatePattern($match, $matches);
        return '/'.str_replace($matches[0][0], self::REGEX_TYPE[$matches[0][0]], $this->pattern).'/';
    }

    private function validatePattern(int $matchResult, array $regResult): void
    {
        if ($matchResult === 0) {
            throw new \InvalidArgumentException('Undefined string pattern');
        }
        if (count($regResult) > 1) {
            throw new \InvalidArgumentException('Pattern can contains only one variable');
        }
        if (!in_array($regResult[0][0], array_keys(self::REGEX_TYPE))) {
            throw new \InvalidArgumentException('Invalid pattern type');
        }
    }
}
