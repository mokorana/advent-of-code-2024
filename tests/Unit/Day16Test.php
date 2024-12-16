<?php

/**
 * Unit tests for the Advent of Code Day 16 solution.
 *
 * @Author: Digitalbüro Mokorana
 * @Date:   2024-12-16 09:31:53
 * @Last    Modified by:   Stefan Koch <stefan.koch@mokorana.de>
 * @Last    Modified time: 2024-12-16 12:35:50
 *
 * @package Aoc
 */

namespace Aoc\Tests\Unit;

use Aoc\Day16;
use PHPUnit\Framework\TestCase;

final class Day16Test extends TestCase
{
    public function testPart1ExampleInput(): void
    {
        $dayPuzzle = new Day16();
        $input = explode("\n", Helper::getSampleData('Day16Sample.data'));

        $this->assertSame($dayPuzzle->solvePart1($input), 7036);
    }

    public function testPart2ExampleInput(): void
    {
        $dayPuzzle = new Day16();
        $input = explode("\n", Helper::getSampleData('Day16Sample.data'));

        $this->assertSame($dayPuzzle->solvePart2($input), 45);
    }
}
