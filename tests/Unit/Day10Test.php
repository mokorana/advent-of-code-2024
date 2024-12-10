<?php

/**
 * Unit tests for the Advent of Code Day 10 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-10 09:26:59
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-10 15:25:25
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day10;
use PHPUnit\Framework\TestCase;

final class Day10Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day10();
        $input = explode("\n", Helper::getSampleData('Day10Sample.data'));

        $this->assertSame($dayPuzzle->solvePart($input), 36);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day10();
        $input = explode("\n", Helper::getSampleData('Day10Sample.data'));

        $this->assertSame($dayPuzzle->solvePart($input, true), 81);
    }
}
