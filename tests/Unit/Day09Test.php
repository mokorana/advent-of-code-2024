<?php

/**
 * Unit tests for the Advent of Code Day 09 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-09 09:39:02
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-09 14:36:52
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day09;
use PHPUnit\Framework\TestCase;

final class Day09Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day09();
        $input = Helper::getSampleData('Day09Sample.data');

        $this->assertSame($dayPuzzle->solvePart($input), 1928);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day09();
        $input = Helper::getSampleData('Day09Sample.data');

        $this->assertSame($dayPuzzle->solvePart($input, true), 2858);
    }
}
