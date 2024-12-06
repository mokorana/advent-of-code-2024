<?php

/**
 * Unit tests for the Advent of Code Day 06 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-06 10:32:26
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-06 13:17:57
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day06;
use PHPUnit\Framework\TestCase;

final class Day06Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day06();
        $input = explode("\n", Helper::getSampleData('Day06Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 41);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day06();
        $input = explode("\n", Helper::getSampleData('Day06Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 6);
    }
}
