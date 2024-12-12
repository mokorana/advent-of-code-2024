<?php

/**
 * Unit tests for the Advent of Code Day 12 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-12 09:11:35
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-12 16:03:21
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day12;
use PHPUnit\Framework\TestCase;

final class Day12Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day12();
        $input = explode("\n", Helper::getSampleData('Day12Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 1930);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day12();
        $input = explode("\n", Helper::getSampleData('Day12Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 1206);
    }
}
