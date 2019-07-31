<?php

use App\Utilities\PatternUtility;

class PatternUtilityTest extends TestCase
{
    /**
     * @test
     * @dataProvider valid_pattern_provider
     * */
    public function will_properly_transofrm_pattern($pattern, $expected): void
    {
        // Given
        $patternUtility = new PatternUtility($pattern);
        // When
        $result = $patternUtility->transformToRegex();
        // Then
        $this->assertEquals(
            $expected,
            $result
        );
    }

    public function valid_pattern_provider(): array
    {
        return [
            ['page{id}.json', '/page(\d+).json/'],
            ['strona{id}.json', '/strona(\d+).json/'],
            ['{id}page.json', '/(\d+)page.json/']
        ];
    }

    /**
     * @test
     * @dataProvider invalid_pattern_provider
     */
    public function will_throw_exception_for_invalid_pattern($pattern): void
    {
        // Given
        $patternUtility = new PatternUtility($pattern);
        // When
        $this->expectException(\InvalidArgumentException::class);
        $result = $patternUtility->transformToRegex();
    }

    public function invalid_pattern_provider(): array
    {
        return [
            ['page(id).json'],
            ['p{a}age{id}.json'],
            ['pageid.json'],
        ];
    }
}
